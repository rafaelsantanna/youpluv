<?php

namespace App\Http\Middleware;

use Closure;

use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenMiddleware
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
        $response = $next($request);
        $oldToken = JWTAuth::getToken(); 
        $newToken = JWTAuth::refresh($oldToken);

        $response->headers->set('Authorization', 'Bearer '.$newToken);
        
        return $response;
    }
}
