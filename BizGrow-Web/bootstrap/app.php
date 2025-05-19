<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\CheckBlacklistedToken; // Tambahkan use ini
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registrasi alias middleware (untuk route)
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'check.blacklist' => CheckBlacklistedToken::class, // ✅ Tambahkan ini
        ]);

        // Jika kamu ingin dijadikan middleware global (seluruh route):
        // $middleware->append(CheckBlacklistedToken::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
