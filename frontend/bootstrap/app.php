<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add web middleware stack
        $middleware->web(append: [
            \App\Http\Middleware\SanitizeInput::class,
        ]);
        
        // Add middleware aliases
        $middleware->alias([
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'student' => \App\Http\Middleware\EnsureStudent::class,
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'staff' => \App\Http\Middleware\EnsureAdmin::class, // Staff uses same as admin for now
            'sanitize' => \App\Http\Middleware\SanitizeInput::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions
    })->create();