<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            // Jika ada, validasi token
            $token = $request->bearerToken();
            $accessToken = PersonalAccessToken::findToken($token);

            if ($accessToken) {
                if ($accessToken->isExpired()) {  // Pastikan token telah kedaluwarsa
                    return response()->json(['message' => 'Token expired'], 401);
                }
                Auth::login($accessToken->tokenable);  // Login menggunakan tokenable
            }
        }

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
