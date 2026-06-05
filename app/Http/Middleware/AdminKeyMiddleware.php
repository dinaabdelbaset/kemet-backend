<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminKeyMiddleware
{
    /**
     * Handle an incoming request.
     * Validates the X-Admin-Key header against the configured admin secret.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminKey = config('app.admin_secret_key', env('ADMIN_SECRET_KEY', 'kemet-admin-2026-secret'));

        $providedKey = $request->header('X-Admin-Key');

        if (!$providedKey || $providedKey !== $adminKey) {
            return response()->json([
                'error'   => 'Unauthorized',
                'message' => 'Valid admin key required. Access denied.',
            ], 401);
        }

        return $next($request);
    }
}
