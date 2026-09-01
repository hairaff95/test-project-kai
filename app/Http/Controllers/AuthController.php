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

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors(['login' => 'Email/username atau kata sandi tidak sesuai.']);
        }

        $user = Auth::user();

        // Cek apakah akun aktif
        if (!$user->is_active) {
            Auth::logout();

            return back()
                ->withInput($request->only('login'))
                ->withErrors(['login' => 'Akun Anda dinonaktifkan. Hubungi Super Admin.']);
        }

        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    /**
     * Redirect user berdasarkan role.
     */
    private function redirectByRole(User $user)
    {
        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect()->route('welcome');
    }

    /**
     * Show the OTP verification page.
     */
    public function showVerifyCode()
    {
        // Pastikan session request_id ada
        if (!session('reset_request_id')) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi tidak valid. Silakan mulai ulang proses reset password.');
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
