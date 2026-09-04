<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Mail\TempPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PasswordResetRequestController extends Controller
{
    /**
     * Tampilkan form request reset password.
     * Tidak butuh login — siapapun bisa akses.
     */
    public function showRequestForm()
    {
        // Bersihkan session OTP lama agar tidak ada konflik
        session()->forget(['reset_request_id', 'otp_verified', 'pending_reset_user_id', 'otp_session_expires_at']);

        return view('auth.request-reset');
    }

    /**
     * Admin submit request reset password via email.
     * Tidak butuh login.
     *
     * Siklus request:
     * - Setiap baris baru di DB = 1 request dalam siklus (request_count naik per baris)
     * - Setelah 3 request (request_count = 3 pada baris terakhir), admin di-block:
     *   tidak bisa buat request baru, harus tunggu superadmin approve/reject request terakhir
     * - Jika request sebelumnya approved/completed/rejected → siklus baru, request_count mulai dari 1
     */
    public function submitRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Cari user berdasarkan email yang dimasukkan (semua role, asal aktif)
        $user = User::where('email', $request->input('email'))
            ->where('is_active', true)
            ->first();

        // Jika email tidak ditemukan, tetap tampilkan pesan sukses (keamanan — tidak bocorkan info)
        if (!$user) {
            return redirect()->route('password.request')
                ->with('success', 'Jika email terdaftar, request akan segera diproses oleh Super Admin.');
        }

        // Ambil request aktif terakhir milik user ini
        $existing = PasswordResetRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();

        // ── Kasus 1: sudah ada request APPROVED yang masih berlaku ──
        if ($existing && $existing->status === 'approved' && $existing->isOtpValid()) {
            session(['pending_reset_user_id' => $user->id]);
            return redirect()->route('password.request.status', ['email' => $user->email])
                ->with('error', 'Request Anda sudah disetujui. Silakan cek email untuk kode OTP.');
        }

        // ── Kasus 2: ada request PENDING yang sedang di-block (sudah 3x request) ──
        if ($existing && $existing->isPending() && $existing->isBlocked()) {
            session(['pending_reset_user_id' => $user->id]);
            return redirect()->route('password.request.status', ['email' => $user->email])
                ->with('error', 'Anda telah mencapai batas maksimal request (' . PasswordResetRequest::MAX_REQUESTS_PER_CYCLE . 'x). Silakan tunggu Super Admin memproses request terakhir Anda.');
        }

        // ── Kasus 3: ada request PENDING yang belum di-block ──
        if ($existing && $existing->isPending() && !$existing->isBlocked()) {

            // Sub-kasus 3a: temp password sudah dikirim dan MASIH berlaku
            // → Admin masih bisa login, arahkan ke status
            if ($existing->temp_password_sent_at !== null && $existing->isTempPasswordValid()) {
                session(['pending_reset_user_id' => $user->id]);
                return redirect()->route('password.request.status', ['email' => $user->email])
                    ->with('error', 'Password sementara Anda masih berlaku. Silakan login menggunakan password sementara yang telah dikirim ke email Anda.');
            }

            // Sub-kasus 3b: temp password sudah expired (atau belum dikirim tapi sudah melewati
            // batas waktu tunggu temp password + lifetime = 1 menit + 2 menit = 3 menit)
            // → Session admin sudah habis, boleh buat request baru untuk mendapatkan temp password baru
            $tempExpired = $existing->temp_password_sent_at !== null && !$existing->isTempPasswordValid();
            $waitExpired = $existing->temp_password_sent_at === null
                && $existing->created_at->diffInSeconds(now()) > (
                    PasswordResetRequest::TEMP_PASSWORD_DELAY_SECONDS +
                    (PasswordResetRequest::TEMP_PASSWORD_LIFETIME_MINS * 60)
                );

            if ($tempExpired || $waitExpired) {
                // Hitung posisi dalam siklus
                $cycleCount = PasswordResetRequest::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->where('created_at', '>=', $this->getLastCycleResetTime($user->id))
                    ->count();

                $newCount = $cycleCount + 1;

                if ($newCount > PasswordResetRequest::MAX_REQUESTS_PER_CYCLE) {
                    // Tandai request terakhir sebagai blocked agar tidak bisa coba lagi
                    $existing->update(['request_count' => PasswordResetRequest::MAX_REQUESTS_PER_CYCLE]);
                    session(['pending_reset_user_id' => $user->id]);
                    return redirect()->route('password.request.status', ['email' => $user->email])
                        ->with('error', 'Anda telah mencapai batas maksimal request (' . PasswordResetRequest::MAX_REQUESTS_PER_CYCLE . 'x). Silakan tunggu Super Admin memproses request terakhir Anda.');
                }

                // Buat request baru dalam siklus yang sama
                PasswordResetRequest::create([
                    'user_id'            => $user->id,
                    'status'             => 'pending',
                    'request_count'      => $newCount,
                    'request_expires_at' => now()->addHours(24),
                ]);

                session(['pending_reset_user_id' => $user->id]);

                $remaining = PasswordResetRequest::MAX_REQUESTS_PER_CYCLE - $newCount;
                $msg = 'Request baru berhasil dikirim. Password sementara baru akan dikirim ke email Anda dalam 1 menit jika Super Admin belum merespons.';
                if ($remaining > 0) {
                    $msg .= " (Sisa kesempatan request: {$remaining}x)";
                } else {
                    $msg .= ' Ini adalah request terakhir Anda dalam siklus ini.';
                }

                return redirect()->route('password.request.status', ['email' => $user->email])
                    ->with('success', $msg);
            }

            // Sub-kasus 3c: temp password belum dikirim dan masih dalam masa tunggu (< 1 menit)
            // → Masih menunggu superadmin, arahkan ke halaman status
            session(['pending_reset_user_id' => $user->id]);
            return redirect()->route('password.request.status', ['email' => $user->email])
                ->with('error', 'Request Anda sedang diproses. Password sementara akan dikirim ke email jika Super Admin tidak merespons dalam 1 menit.');
        }

        // ── Kasus 4: tidak ada request aktif — bisa buat request baru ──
        // Hitung berapa kali sudah request dalam siklus ini (sejak terakhir ada approved/completed)
        $cycleCount = PasswordResetRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('created_at', '>=', $this->getLastCycleResetTime($user->id))
            ->count();

        // +1 untuk request yang akan dibuat sekarang
        $newCount = $cycleCount + 1;

        if ($newCount > PasswordResetRequest::MAX_REQUESTS_PER_CYCLE) {
            // Ini seharusnya tidak terjadi karena sudah di-block di kasus 2, tapi jaga-jaga
            return redirect()->route('password.request')
                ->with('error', 'Anda telah mencapai batas maksimal request. Silakan tunggu Super Admin memproses request terakhir Anda.');
        }

        // Buat request baru dengan request_count sesuai posisi dalam siklus
        PasswordResetRequest::create([
            'user_id'            => $user->id,
            'status'             => 'pending',
            'request_count'      => $newCount,
            'request_expires_at' => now()->addHours(24),
        ]);

        session(['pending_reset_user_id' => $user->id]);

        $remaining = PasswordResetRequest::MAX_REQUESTS_PER_CYCLE - $newCount;
        $msg = 'Request berhasil dikirim. Menunggu persetujuan Super Admin...';
        if ($remaining > 0) {
            $msg .= " (Sisa kesempatan request: {$remaining}x)";
        } else {
            $msg .= ' Ini adalah request terakhir Anda dalam siklus ini.';
        }

        return redirect()->route('password.request.status', ['email' => $user->email])
            ->with('success', $msg);
    }

    /**
     * Dapatkan waktu reset siklus terakhir untuk user:
     * yaitu waktu terakhir ada request yang approved atau completed.
     * Jika tidak ada, return epoch (1970) agar semua request masuk hitungan.
     */
    private function getLastCycleResetTime(int $userId): \Carbon\Carbon
    {
        $last = PasswordResetRequest::where('user_id', $userId)
            ->whereIn('status', ['approved', 'completed', 'rejected'])
            ->latest('updated_at')
            ->value('updated_at');

        return $last ? \Carbon\Carbon::parse($last) : \Carbon\Carbon::createFromTimestamp(0);
    }

    /**
     * Tampilkan status request.
     * Bekerja dengan atau tanpa login, dan dengan atau tanpa session.
     */
    public function requestStatus(Request $request)
    {
        $resetRequest = null;

        // Prioritas 1: user sedang login
        if (auth()->check()) {
            $userId = auth()->id();
            $resetRequest = PasswordResetRequest::where('user_id', $userId)
                ->whereIn('status', ['pending', 'approved'])
                ->latest()
                ->first();
        }

        // Prioritas 2: ada session pending_reset_user_id
        if (!$resetRequest && session('pending_reset_user_id')) {
            $userId = session('pending_reset_user_id');
            $resetRequest = PasswordResetRequest::where('user_id', $userId)
                ->whereIn('status', ['pending', 'approved'])
                ->latest()
                ->first();
        }

        // Prioritas 3: ada query string email (fallback jika session hilang)
        if (!$resetRequest && $request->filled('email')) {
            $user = User::where('email', $request->input('email'))
                ->where('is_active', true)
                ->first();
            if ($user) {
                session(['pending_reset_user_id' => $user->id]);
                $resetRequest = PasswordResetRequest::where('user_id', $user->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->latest()
                    ->first();
            }
        }

        // Jika sudah approved, set session
        if ($resetRequest && $resetRequest->status === 'approved') {
            session([
                'reset_request_id'       => $resetRequest->id,
                'otp_session_expires_at' => $resetRequest->otp_expires_at?->timestamp,
            ]);
        }

        return view('auth.request-status', compact('resetRequest'));
    }

    /**
     * Polling endpoint — return JSON status request untuk auto-redirect di frontend.
     * Juga trigger pengiriman temp password langsung (tanpa butuh scheduler).
     *
     * Di-cache 5 detik per user agar polling agresif dari frontend tidak membebani DB.
     * Cache di-invalidasi jika ada perubahan status (approved / temp_password dikirim).
     */
    public function pollStatus()
    {
        $userId = auth()->id() ?? session('pending_reset_user_id');

        if (!$userId) {
            return response()->json(['status' => 'none']);
        }

        // Cache hasil poll per user selama 5 detik
        $cacheKey = "poll_status_user_{$userId}";

        $result = Cache::remember($cacheKey, 5, function () use ($userId) {
            $resetRequest = PasswordResetRequest::where('user_id', $userId)
                ->whereIn('status', ['pending', 'approved'])
                ->latest()
                ->first();

            if (!$resetRequest) {
                return ['status' => 'none'];
            }

            if ($resetRequest->status === 'approved' && $resetRequest->isOtpValid()) {
                return [
                    'status'       => 'approved',
                    'redirect_url' => route('password.verify'),
                    '_request_id'  => $resetRequest->id, // dipakai untuk set session di bawah
                    '_otp_expires' => $resetRequest->otp_expires_at->timestamp,
                ];
            }

            if ($resetRequest->status === 'pending') {
                $sent = $this->trySendTempPassword($resetRequest);

                // Jika baru saja kirim temp password, invalidasi cache agar next poll langsung fresh
                if ($sent) {
                    Cache::forget("poll_status_user_{$userId}");
                }

                return [
                    'status'        => 'pending',
                    'temp_pwd_sent' => $sent,
                ];
            }

            return ['status' => $resetRequest->status];
        });

        // Set session untuk redirect (dilakukan di luar cache agar tidak disimpan di cache)
        if (($result['status'] ?? '') === 'approved') {
            session([
                'reset_request_id'       => $result['_request_id'],
                'otp_session_expires_at' => $result['_otp_expires'],
            ]);
            // Kembalikan respons tanpa field internal
            return response()->json([
                'status'       => 'approved',
                'redirect_url' => $result['redirect_url'],
            ]);
        }

        return response()->json($result);
    }

    /**
     * Generate dan kirim temp password ke email user.
     * Menggunakan atomic DB update untuk mencegah race condition / spam.
     *
     * Aturan:
     * - Kirim SEKALI per request (per baris DB), setelah 1 menit pending tanpa response superadmin
     * - Berlaku 2 menit
     * - Jika admin ingin password baru, ia harus submit request baru (siklus baru)
     *
     * Return true jika berhasil kirim, false jika tidak perlu kirim atau sudah diproses.
     */
    private function trySendTempPassword(PasswordResetRequest $resetRequest): bool
    {
        if (!$resetRequest->user || !$resetRequest->user->is_active) {
            return false;
        }

        $now    = now();
        $cutoff = $now->copy()->subSeconds(PasswordResetRequest::TEMP_PASSWORD_DELAY_SECONDS);

        // Atomic update: hanya update jika:
        // 1. Status masih pending
        // 2. Belum pernah kirim temp password (temp_password_sent_at IS NULL)
        // 3. Request sudah pending >= 1 menit (created_at <= now - 60 detik)
        // Ini mencegah double-send akibat race condition concurrent HTTP requests
        $plainPassword = Str::random(12);
        $expiresAt     = $now->copy()->addMinutes(PasswordResetRequest::TEMP_PASSWORD_LIFETIME_MINS);

        $affected = DB::table('password_reset_requests')
            ->where('id', $resetRequest->id)
            ->where('status', 'pending')
            ->whereNull('temp_password_sent_at')           // Hanya kirim SEKALI per request
            ->where('created_at', '<=', $cutoff)           // Sudah pending >= 1 menit
            ->update([
                'temp_password'            => $plainPassword,
                'temp_password_sent_at'    => $now,
                'temp_password_expires_at' => $expiresAt,
            ]);

        // 0 rows affected = kondisi tidak terpenuhi atau sudah dikirim oleh request lain
        if ($affected === 0) {
            return false;
        }

        try {
            Mail::to($resetRequest->user->email)
                ->send(new TempPasswordMail($resetRequest->user, $plainPassword));

            Log::info("TempPassword: Sent to {$resetRequest->user->email}, expires {$expiresAt}");
            return true;
        } catch (\Exception $e) {
            Log::error("TempPassword: Failed to send to {$resetRequest->user->email} — {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Tampilkan form verifikasi OTP.
     */
    public function showVerifyOtp()
    {
        if (!session('reset_request_id')) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses.');
        }

        return view('auth.verify-code');
    }

    /**
     * Kirim ulang OTP ke email admin.
     */
    public function resendOtp()
    {
        $requestId    = session('reset_request_id');
        $resetRequest = PasswordResetRequest::find($requestId);

        if (!$resetRequest || !$resetRequest->isApproved()) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses.');
        }

        // Generate OTP baru
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $resetRequest->update([
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinute(),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($resetRequest->user->email)
                ->send(new \App\Mail\OtpMail($resetRequest->user, $otp, $resetRequest));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim ulang OTP: ' . $e->getMessage());
        }

        return redirect()->route('password.verify')
            ->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    /**
     * Verifikasi OTP yang dimasukkan admin.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $requestId    = session('reset_request_id');
        $resetRequest = PasswordResetRequest::find($requestId);

        if (!$resetRequest || !$resetRequest->isApproved()) {
            return redirect()->route('password.request')
                ->with('error', 'Request tidak ditemukan atau belum disetujui.');
        }

        if (!$resetRequest->isOtpValid()) {
            return redirect()->route('password.request')
                ->with('error', 'Kode OTP sudah kedaluwarsa. Minta Super Admin untuk approve ulang.');
        }

        if ($resetRequest->otp_code !== $request->input('otp')) {
            return back()->withErrors(['otp' => 'Kode OTP tidak sesuai.']);
        }

        // OTP valid — simpan di session untuk halaman reset
        session(['otp_verified' => true, 'reset_request_id' => $resetRequest->id]);

        return redirect()->route('password.reset');
    }

    /**
     * Proses ganti password baru.
     */
    public function resetPassword(Request $request)
    {
        if (!session('otp_verified') || !session('reset_request_id')) {
            return redirect()->route('password.verify')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses.');
        }

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[0-9]/',
                'regex:/[A-Z]/',
                'regex:/[^A-Za-z0-9]/',
            ],
        ], [
            'password.regex' => 'Kata sandi harus memenuhi semua kriteria keamanan.',
        ]);

        $resetRequest = PasswordResetRequest::find(session('reset_request_id'));

        if (!$resetRequest) {
            return redirect()->route('password.request')
                ->with('error', 'Request tidak ditemukan.');
        }

        // Update password user
        $resetRequest->user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        // Update status request
        $resetRequest->update([
            'status'       => 'completed',
            'completed_at' => now(),
            'otp_code'     => null,
        ]);

        // Bersihkan session
        session()->forget(['otp_verified', 'reset_request_id']);

        return redirect()->route('login')
            ->with('success', 'Kata sandi berhasil diperbarui. Silakan masuk dengan kata sandi baru.');
    }

    /**
     * Admin akses halaman OTP via link di email (tanpa login).
     */
    public function accessViaToken(PasswordResetRequest $resetRequest)
    {
        if (!$resetRequest->isApproved() || !$resetRequest->isOtpValid()) {
            return redirect()->route('login')
                ->with('error', 'Link tidak valid atau sudah kedaluwarsa.');
        }

        session(['reset_request_id' => $resetRequest->id]);

        return redirect()->route('password.verify');
    }
}
