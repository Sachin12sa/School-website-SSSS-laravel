<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:      __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health:   '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register the 'admin' middleware alias
        // Used as: ->middleware(['auth', 'admin']) in routes
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Redirect unauthenticated users to the admin login page
        // (Laravel's default is route('login') which doesn't exist in this app)
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            $message = 'The upload is too large for one request. Please upload files up to 200MB each, or split very large batches into smaller uploads.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 413);
            }

            return back()->withErrors(['upload' => $message])->withInput();
        });
    })
    ->create();
