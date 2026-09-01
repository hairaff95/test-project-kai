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
            return redirect()->route('password.request')
                ->with('error', 'Request untuk email ini sudah ada dan sedang diproses. Silakan tunggu atau cek email Anda.');
        }

        PasswordResetRequest::create([
            'user_id'            => $user->id,
            'status'             => 'pending',
            'request_expires_at' => now()->addHours(24),
        ]);

        return redirect()->route('password.request')
            ->with('success', 'Request reset password berhasil dikirim. Super Admin akan segera memprosesnya.');
    }

    /**
     * Tampilkan status request (butuh login karena halaman ini untuk user yang sudah login).
     */
    public function requestStatus()
    {
        $resetRequest = null;

        if (auth()->check()) {
            $resetRequest = PasswordResetRequest::where('user_id', auth()->id())
                ->whereIn('status', ['pending', 'approved'])
                ->latest()
                ->first();
        }

        return view('auth.request-status', compact('resetRequest'));
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
