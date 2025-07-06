<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware global que se ejecuta en todas las peticiones.
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Http\Middleware\TrustProxies::class,
    ];

    /**
     * Agrupación de middlewares por tipo de ruta.
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Uncomment if Sanctum is installed
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware individuales que puedes aplicar en rutas.
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Middleware de roles de Spatie (descomenta si tienes instalado spatie/laravel-permission)
        // 'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        // 'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        // 'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,

        // Tu middleware personalizado (si lo usas)
        'role.redirect' => \App\Http\Middleware\RoleRedirect::class,
    ];
}
