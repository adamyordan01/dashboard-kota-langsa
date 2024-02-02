<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function viewLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // validate incoming request
        // $validator = $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ], [
        //     'email.required' => 'Email harus diisi',
        //     'email.email' => 'Email tidak valid',
        //     'password.required' => 'Password harus diisi',
        // ]);

        // // attempt login and check if has remember me
        // $remember = $request->remember ? true : false;

        // if (auth()->attempt($validator, $remember)) {
        //     $request->session()->regenerate();
        //     return redirect()->route('dashboard');
        // }

        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');

        // validate incoming request
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'email.required' => 'Email atau username harus diisi',
            'password.required' => 'Password harus diisi',
            'g-recaptcha-response.required' => 'Harap verifikasi bahwa Anda bukan robot',
            'g-recaptcha-response.captcha' => 'Terjadi kesalahan pada verifikasi captcha, coba lagi atau hubungi administrator sistem',
        ]);

        // make login using email or username
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$fieldType => $request->email]);

        if (Auth::attempt($request->only($fieldType, 'password'), $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.view-login');
    }
}
