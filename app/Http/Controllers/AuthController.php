<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login page.
     * Redirect jika sudah login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required'    => 'Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $login    = $request->input('login');
        $password = $request->input('password');

        // Cek apakah input berupa email atau username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field     => $login,
            'password' => $password,
        ];

        // ── Coba login normal terlebih dahulu ──
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()
                    ->withInput($request->only('login'))
                    ->withErrors(['login' => 'Akun Anda dinonaktifkan. Hubungi Super Admin.']);
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // ── Jika login normal gagal, coba temp password ──
        $user = \App\Models\User::where($field, $login)
            ->where('is_active', true)
            ->first();

        if ($user) {
            $resetRequest = \App\Models\PasswordResetRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->whereNotNull('temp_password')
                ->whereNotNull('temp_password_expires_at')
                ->where('temp_password_expires_at', '>', now())
                ->latest('temp_password_sent_at')
                ->first();

            if ($resetRequest && hash_equals($resetRequest->temp_password, $password)) {
                // Login berhasil via temp password
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                // Simpan flag & waktu expired di session
                session([
                    'is_using_temp_password'     => true,
                    'temp_password_expires_at'   => $resetRequest->temp_password_expires_at->timestamp,
                    'temp_password_request_id'   => $resetRequest->id,
                ]);

                return redirect()->route('dashboard');
            }
        }

        return back()
            ->withInput($request->only('login'))
            ->withErrors(['login' => 'Email/username atau kata sandi tidak sesuai.']);
    }

    /**
     * Redirect user ke dashboard.
     */
    private function redirectByRole(User $user)
    {
        return redirect()->route('dashboard');
    }

    /**
     * Show the OTP verification page.
     */
    public function showVerifyCode(\Illuminate\Http\Request $request)
    {
        $requestId      = session('reset_request_id');
        $sessionExpires = session('otp_session_expires_at');
        $resetRequest   = $requestId ? \App\Models\PasswordResetRequest::find($requestId) : null;

        // Fallback: jika session reset_request_id belum ada, cari dari session user atau query email
        if (!$resetRequest) {
            $userId = auth()->id() ?? session('pending_reset_user_id');
            if (!$userId && $request->filled('email')) {
                $user = User::where('email', $request->input('email'))->where('is_active', true)->first();
                $userId = $user?->id;
            }
            if ($userId) {
                $resetRequest = \App\Models\PasswordResetRequest::where('user_id', $userId)
                    ->whereIn('status', ['pending', 'approved'])
                    ->latest()
                    ->first();
                if ($resetRequest) {
                    session([
                        'reset_request_id'       => $resetRequest->id,
                        'otp_session_expires_at' => $resetRequest->otp_expires_at?->timestamp ?? now()->addMinutes(15)->timestamp,
                        'pending_reset_user_id'  => $userId,
                    ]);
                    $sessionExpires = $resetRequest->otp_expires_at?->timestamp ?? now()->addMinutes(15)->timestamp;
                }
            }
        }

        $sessionExpired = $sessionExpires && now()->timestamp > $sessionExpires;

        // Session / request tidak ada sama sekali → redirect ke form request
        if (!$resetRequest) {
            return redirect()->route('password.request');
        }

        // Session ada tapi expired
        if ($sessionExpired) {
            session()->forget(['reset_request_id', 'otp_verified', 'pending_reset_user_id', 'otp_session_expires_at']);
            return redirect()->route('password.request')
                ->with('error', 'Kode OTP sudah kedaluwarsa. Silakan ajukan ulang.');
        }

        return view('auth.verify-code');
    }

    /**
     * Show the reset password page.
     */
    public function showResetPassword()
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.verify')
                ->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        return view('auth.reset-password');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
