<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Load persisted cart (if any) into session after successful login
        $userId = auth()->id();
        if ($userId) {
            $cartModel = \App\Models\Cart::where('user_id', $userId)->first();
            if ($cartModel && is_array($cartModel->data)) {
                // If there is an existing session cart, merge with DB cart (DB wins on conflicts)
                $sessionCart = $request->session()->get('cart', []);
                $merged = array_merge($sessionCart, $cartModel->data ?? []);
                $request->session()->put('cart', $merged);
            }
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
