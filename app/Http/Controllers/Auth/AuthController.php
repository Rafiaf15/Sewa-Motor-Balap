<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',                    // Minimal 8 karakter
                'regex:/[A-Z]/',           // Harus ada huruf kapital
                'regex:/[0-9]/',           // Harus ada angka
                'regex:/[@$!%*#?&]/',      // Harus ada karakter spesial
                'confirmed'                 // Harus sama dengan password_confirmation
            ],
        ], [
            'password.regex' => [
                '/[A-Z]/' => 'Password harus memiliki setidaknya satu huruf kapital.',
                '/[0-9]/' => 'Password harus memiliki setidaknya satu angka.',
                '/[@$!%*#?&]/' => 'Password harus memiliki setidaknya satu karakter spesial (@$!%*#?&).'
            ]
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // default role
        ]);

        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}