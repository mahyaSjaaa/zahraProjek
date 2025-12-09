<?php
namespace App\Http;

    use Illuminate\Foundation\Http\Kernel as HttpKernel;

    class Kernel extends HttpKernel
    {
        /**
         * The application's global HTTP middleware stack.
         *
         * These middleware run during every request to your application.
         */
        protected $middleware = [
            // Handle global middleware
            \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ];

        /**
         * The application's route middleware groups.
         */
        protected $middlewareGroups = [
                'web' => [
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                // boleh kosong dulu, atau kalau mau global:
                // \App\Http\Middleware\PreventBackHistory::class,
            ],

            'api' => [
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
        ];

        /**
         * The application's route middleware.
         *
         * These middleware may be assigned to groups or used independently.
         */
        protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'admin' => \App\Http\Middleware\Admin::class,
        'preventbackhistory' => \App\Http\Middleware\PreventBackHistory::class,
    ];

    }

