<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsVendor
{
    /**
     * Handle an incoming request.
     * Ensures the authenticated user has vendor role and has a vendor profile.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isVendor()) {
            abort(403, 'Akses hanya untuk vendor.');
        }

        // Ensure vendor profile exists
        if (!$user->vendor) {
            return redirect()->route('vendor.register')
                ->with('warning', 'Silakan lengkapi profil vendor Anda terlebih dahulu.');
        }

        return $next($request);
    }
}
