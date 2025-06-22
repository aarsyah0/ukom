<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMultipleGuards
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $guard = null): Response
    {
        // Check if user is authenticated in any guard
        $isAuthenticated = false;

        if ($guard === 'dosen') {
            $isAuthenticated = Auth::guard('dosen')->check();
        } elseif ($guard === 'mahasiswa') {
            $isAuthenticated = Auth::guard('mahasiswa')->check();
        } else {
            // Default guard (admin)
            $isAuthenticated = Auth::check();
        }

        if (!$isAuthenticated) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect('/login');
        }

        return $next($request);
    }
}
