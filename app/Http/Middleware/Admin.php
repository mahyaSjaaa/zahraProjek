<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Symfony\Component\HttpFoundation\Response;

    class Admin
    {
        /**
         * Handle an incoming request.
         */
        public function handle(Request $request, Closure $next): Response
        {
            // Belum login → paksa ke login
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('success', 'Silakan login terlebih dahulu.');
            }

            // Sudah login tapi bukan admin → kembalikan ke beranda
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('home')
                    ->with('success', 'Anda tidak memiliki akses ke halaman admin.');
            }

            return $next($request);
        }
    }
        