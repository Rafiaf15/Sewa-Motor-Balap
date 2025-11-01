<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KycRequired
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Check required profile fields
        if (empty($user->phone) || empty($user->ktp) || empty($user->address)) {
            return redirect()->route('profile')
                ->with('error', 'Lengkapi nomor telepon, NIK/KTP, dan alamat terlebih dahulu.');
        }

        $hasKtp = !empty($user->ktp_photo);
        $hasSim = !empty($user->simc_photo);

        if (!$hasKtp || !$hasSim) {
            return redirect()->route('profile')
                ->with('error', 'Lengkapi verifikasi KTP dan SIM C terlebih dahulu.');
        }

        if (empty($user->kyc_verified_at)) {
            return redirect()->route('profile')
                ->with('error', 'Menunggu verifikasi identitas oleh admin.');
        }

        return $next($request);
    }
}
