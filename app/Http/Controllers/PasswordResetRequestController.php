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

        // Cek apakah sudah ada request pending atau approved
        $existing = PasswordResetRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->route('password.request.status')
                ->with('error', 'Request untuk email ini sudah ada dan sedang diproses. Silakan tunggu atau cek email Anda.');
        }

        PasswordResetRequest::create([
            'user_id'            => $user->id,
            'status'             => 'pending',
            'request_expires_at' => now()->addHours(24),
        ]);

        // Simpan user_id di session supaya halaman status bisa diakses tanpa login
        session(['pending_reset_user_id' => $user->id]);

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

            // Jika sudah approved, set session reset_request_id + expiry
            if ($resetRequest && $resetRequest->status === 'approved') {
                session([
                    'reset_request_id'       => $resetRequest->id,
                    'otp_session_expires_at' => $resetRequest->otp_expires_at?->timestamp,
                ]);
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
            ->with('success', 'Sukses update kata sandi baru! Silakan masuk dengan kata sandi baru Anda.');
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
