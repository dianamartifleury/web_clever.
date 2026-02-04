<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
     // 🟢 Middleware global para mantener el idioma en sesión
    ->withMiddleware(function (Middleware $middleware): void {
       
        $middleware->web(append: [
            \App\Http\Middleware\LanguageMiddleware::class,
        ]);
           $middleware->validateCsrfTokens(except: [
        'cookie-events',
        'customer-metadata/basic',
        'customer-metadata/consent',
        'customer-metadata/click',
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
