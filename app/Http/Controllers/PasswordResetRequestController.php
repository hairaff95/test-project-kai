<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Mail\TempPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetRequestController extends Controller
{
    /**
     * Smart entry point "Ubah Kata Sandi".
     *
     * Logika:
     * - Jika tidak ada session atau session > 1 jam → form request email
     * - Jika ada session valid + request approved + OTP valid → halaman OTP
     * - Jika ada session valid + request approved + OTP expired → halaman OTP (tampil expired, kirim ulang)
     * - Jika ada session valid + request pending → halaman status (menunggu)
     */
    public function changePassword()
    {
        $sessionStartedAt = session('session_started_at');
        $userId           = session('pending_reset_user_id');

        // Cek apakah session masih dalam 1 jam
        $sessionValid = $sessionStartedAt && now()->timestamp - $sessionStartedAt < 3600;

        if (!$sessionValid || !$userId) {
            // Session habis / tidak ada → bersihkan dan mulai dari awal
            session()->forget([
                'pending_reset_user_id',
                'session_started_at',
                'reset_request_id',
                'otp_verified',
                'otp_session_expires_at',
            ]);
            return redirect()->route('password.request');
        }

        // Ada session valid → cek status request di DB
        $resetRequest = PasswordResetRequest::where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();

        if (!$resetRequest) {
            // Tidak ada request aktif (mungkin rejected/completed) → form baru
            session()->forget([
                'pending_reset_user_id',
                'session_started_at',
                'reset_request_id',
                'otp_verified',
                'otp_session_expires_at',
            ]);
            return redirect()->route('password.request');
        }

        if ($resetRequest->status === 'approved') {
            // Set session reset_request_id untuk halaman OTP
            session([
                'reset_request_id'       => $resetRequest->id,
                'otp_session_expires_at' => $resetRequest->otp_expires_at?->timestamp,
            ]);
            // Langsung ke halaman OTP (controller akan handle expired/valid)
            return redirect()->route('password.verify');
        }

        // Status pending → halaman menunggu
        return redirect()->route('password.request.status');
    }

    /**
     * Tampilkan form request reset password.
     * Tidak butuh login — siapapun bisa akses.
     */
    public function showRequestForm()
    {
        // Hanya bersihkan session OTP — jangan hapus pending_reset_user_id
        // karena masih dibutuhkan oleh halaman status jika user kembali ke form ini
        session()->forget(['reset_request_id', 'otp_verified', 'otp_session_expires_at']);

        return view('auth.request-reset');
    }

    /**
     * Admin submit request reset password via email.
     * Tidak butuh login.
     */
    public function submitRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Cari user berdasarkan email, pastikan role admin
        $user = User::where('email', $request->input('email'))
            ->where('role', 'admin')
            ->where('is_active', true)
            ->first();

        // Jika email tidak ditemukan, tetap tampilkan pesan sukses (keamanan — tidak bocorkan info)
        if (!$user) {
            return redirect()->route('password.request')
                ->with('success', 'Jika email terdaftar, request akan segera diproses oleh Super Admin.');
        }

        // Cek apakah sudah ada request pending atau approved dengan OTP masih valid
        $existing = PasswordResetRequest::where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere(function ($q) {
                        // approved hanya dianggap aktif jika OTP belum expired
                        $q->where('status', 'approved')
                            ->where('otp_expires_at', '>', now());
                    });
            })
            ->first();

        if ($existing) {
            // Pastikan session masih menyimpan user_id agar halaman status bisa menampilkan data
            session(['pending_reset_user_id' => $user->id]);

            // Jika sudah approved, set juga reset_request_id agar user bisa langsung ke OTP
            if ($existing->status === 'approved' && $existing->isOtpValid()) {
                session([
                    'reset_request_id'       => $existing->id,
                    'otp_session_expires_at' => $existing->otp_expires_at?->timestamp,
                ]);
            }

            return redirect()->route('password.request.status')
                ->with('info', 'Request untuk email ini sudah ada dan sedang diproses. Silakan tunggu atau cek email Anda.');
        }

        PasswordResetRequest::create([
            'user_id'            => $user->id,
            'status'             => 'pending',
            'request_expires_at' => now()->addHours(24),
        ]);

        // Simpan user_id + waktu mulai session di session (berlaku 1 jam)
        session([
            'pending_reset_user_id' => $user->id,
            'session_started_at'    => now()->timestamp,
        ]);

        return redirect()->route('password.request.status')
            ->with('success', 'Request berhasil dikirim. Menunggu persetujuan Super Admin...');
    }

    /**
     * Tampilkan status request.
     */
    public function requestStatus()
    {
        $userId = auth()->id() ?? session('pending_reset_user_id');

        $resetRequest = null;

        if ($userId) {
            $resetRequest = PasswordResetRequest::where('user_id', $userId)
                ->whereIn('status', ['pending', 'approved'])
                ->latest()
                ->first();

            // Jika sudah approved dan OTP masih valid, langsung redirect ke halaman OTP
            if ($resetRequest && $resetRequest->status === 'approved' && $resetRequest->isOtpValid()) {
                session([
                    'reset_request_id'       => $resetRequest->id,
                    'otp_session_expires_at' => $resetRequest->otp_expires_at?->timestamp,
                ]);
                return redirect()->route('password.verify');
            }

            // Jika approved tapi OTP sudah expired — reset request ke null
            // agar tampilkan form "tidak ada request aktif" dan user bisa request ulang
            if ($resetRequest && $resetRequest->status === 'approved' && !$resetRequest->isOtpValid()) {
                $resetRequest = null;
            }
        }

        return view('auth.request-status', compact('resetRequest'));
    }

    /**
     * Polling endpoint — return JSON status request untuk auto-redirect di frontend.
     */
    public function pollStatus()
    {
        $userId = auth()->id() ?? session('pending_reset_user_id');

        if (!$userId) {
            return response()->json(['status' => 'none']);
        }

        $resetRequest = PasswordResetRequest::where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();

        if (!$resetRequest) {
            return response()->json(['status' => 'none']);
        }

        if ($resetRequest->status === 'approved' && $resetRequest->isOtpValid()) {
            session([
                'reset_request_id'      => $resetRequest->id,
                'otp_session_expires_at' => $resetRequest->otp_expires_at->timestamp,
            ]);
            return response()->json([
                'status'       => 'approved',
                'redirect_url' => route('password.verify'),
            ]);
        }

        return response()->json(['status' => $resetRequest->status]);
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
        $resetRequest = $requestId ? PasswordResetRequest::find($requestId) : null;

        // Fallback: cari via pending_reset_user_id jika reset_request_id tidak ada
        if (!$resetRequest) {
            $userId = session('pending_reset_user_id');
            if ($userId) {
                $resetRequest = PasswordResetRequest::where('user_id', $userId)
                    ->where('status', 'approved')
                    ->latest()
                    ->first();

                if ($resetRequest) {
                    session(['reset_request_id' => $resetRequest->id]);
                }
            }
        }

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

        // Update session expiry
        session(['otp_session_expires_at' => now()->addMinute()->timestamp]);

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
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
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
