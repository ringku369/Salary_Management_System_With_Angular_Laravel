<?php

namespace App\Http\Middleware;

use Closure;
//use Tymon\JWTAuth\Facades\JWTAuth;
//use tymon\JWTAuth\Facades\JWTAuth;

use JWTAuth;

class JWT
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
        JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}
