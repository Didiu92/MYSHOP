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
    ->withMiddleware(function (Middleware $middleware) {
        // Registrar middleware con alias
        $middleware->alias([
            'track.visits' => \App\Http\Middleware\TrackPageVisits::class,
            'log.activity' => \App\Http\Middleware\LogUserActivity::class,
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'worker' => \App\Http\Middleware\IsWorker::class,
        ]);

        $middleware->appendToGroup('web', [
            \App\Http\Middleware\TrackPageVisits::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();