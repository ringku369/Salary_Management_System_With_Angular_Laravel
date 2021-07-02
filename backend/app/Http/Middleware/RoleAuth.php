<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Closure;

class RoleAuth
{
    
    
    public function handle($request, Closure $next, $roles)
    {
      $token = JWTAuth::parseToken();   
      $user = $token->authenticate();
      if ($user->role  != $roles) {
        return response()->json(['error' => 'You are unauthorized to access this resource'], 401);
      }
      return $next($request);
    }

  private function unauthorized($message = null){
    return response()->json([
        'message' => $message ? $message : 'You are unauthorized to access this resource',
        'success' => false
    ], 401);
  }
}
