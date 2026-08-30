<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle the login request.
     * For now, bypasses credentials so clicking 'Masuk' logs in directly.
     */
    public function login(Request $request)
    {
        $user = User::first();

        if ($user) {
            Auth::login($user);
        }

        $request->session()->regenerate();

        return redirect()->route('welcome');
    }

    /**
     * Show the OTP code verification page.
     */
    public function showVerifyCode()
    {
        return view('auth.verify-code');
    }

    /**
     * Show the reset/change password page.
     */
    public function showResetPassword()
    {
        return view('auth.reset-password');
    }

    /**
     * Handle logout and redirect to login page.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
