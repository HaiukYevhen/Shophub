<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            Log::warning('Unauthorized admin panel access attempt.', [
                'user_id' => auth()->id(),
                'path' => $request->path(),
                'ip' => $request->ip(),
            ]);

            abort(403);
        }

        return $next($request);
    }
}