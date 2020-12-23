<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken() == 'my-token')
            return $next($request);
        return response()->json([
            'code' => 401,
            'message' => 'Your token is not valid',
            'data' => null,
        ], 401);
    }
}
