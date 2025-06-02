<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckBlacklistedToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token && DB::table('blacklisted_tokens')->where('token', $token)->exists()) {
            return response()->json(['message' => 'Token tidak valid (blacklisted)'], 401);
        }

        return $next($request);
    }
}
