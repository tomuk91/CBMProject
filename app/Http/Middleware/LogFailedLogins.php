<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogFailedLogins
{
    /**
     * Handle an incoming request and log failed login attempts.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if this is a login attempt that failed
        if ($request->is('login') && $request->isMethod('POST') && $response->isRedirection()) {
            if (session()->has('errors')) {
                Log::warning('Failed login attempt', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'email' => $request->input('email'),
                    'timestamp' => now(),
                ]);
            }
        }

        return $response;
    }
}
