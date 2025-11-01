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

            $user = Auth::user();
            
            // Check if email is verified (skip for admin users)
            if ($user->role !== 'admin' && !$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Please verify your email address before logging in.',
                ]);
            }

            // Load persisted cart into session after successful login
            $userId = Auth::id();
            if ($userId) {
                $cartModel = \App\Models\Cart::where('user_id', $userId)->first();
                if ($cartModel && is_array($cartModel->data)) {
                    $sessionCart = $request->session()->get('cart', []);
                    $merged = array_merge($sessionCart, $cartModel->data ?? []);
                    $request->session()->put('cart', $merged);
                }
            }

            // Admin: direct redirect to admin dashboard (ignore intended)
            if (auth()->user() && auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // User: honor intended URL falling back to user dashboard
            return redirect()->intended(route('dashboard'));
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // default role
            'avatar' => null,
        ]);
    
        // Send verification email and redirect to verification notice
        // DO NOT auto-login the user
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}