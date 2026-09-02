<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->alias([
            'role'         => \App\Http\Middleware\CheckRole::class,
            'active_check' => \App\Http\Middleware\CheckActiveStatus::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Throttle: tampilkan pesan error ramah alih-alih halaman 429 default
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null; // biarkan default JSON untuk API
            }

            $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
            $minutes    = ceil($retryAfter / 60);
            $message    = $minutes >= 2
                ? "Terlalu banyak percobaan. Coba lagi dalam {$minutes} menit."
                : "Terlalu banyak percobaan. Coba lagi dalam {$retryAfter} detik.";

            return back()->with('error', $message);
        });
    })->create();
