<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $apiToken = config('custom.API_TOKEN');

        if ($token !== "Bearer $apiToken") {
            return response()->json(['message' => "Unauthorized"], 401);
        }

        return $next($request);
    }
}
