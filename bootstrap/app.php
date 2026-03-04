<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // bootstrap/app.php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.client' => \App\Http\Middleware\RedirectIfNotClient::class,
            'auth.admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
