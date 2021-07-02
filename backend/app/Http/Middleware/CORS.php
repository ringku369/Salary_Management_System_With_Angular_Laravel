<?php

namespace App\Http\Middleware;

use Closure;

class CORS
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
      $response = $next( $request );
      $response->header( 'Access-Control-Allow-Origin', '*' );
      $response->header( 'Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, Authorization' );
      $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
      return $response;

      /*return $next($request)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, Authorization');*/
    }
}
