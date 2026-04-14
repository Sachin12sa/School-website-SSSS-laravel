<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Must be logged in
        if (!$request->user()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please log in to access the admin panel.');
        }

        // Must have admin or editor role
        if (!in_array($request->user()->role, ['admin', 'editor'])) {
            abort(403, 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}