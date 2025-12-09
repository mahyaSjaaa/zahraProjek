<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {

            // khusus akses keranjang & checkout
            if ($request->routeIs('keranjang.*', 'checkout.*')) {
                session()->flash('error', 'Silakan login untuk mengakses keranjang dan checkout.');
            } else {
                // akses halaman lain yang butuh auth
                session()->flash('error', 'Silakan login terlebih dahulu.');
            }

            return route('login');
        }

        return null;
    }
}
