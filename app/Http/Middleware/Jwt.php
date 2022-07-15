<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Jwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['sucees'=>false,'message' => 'توکن نامعتبر است']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['sucees'=>false,'message' => 'توکن منقضی شده است']);
            }else{
                return response()->json(['sucees'=>false,'message' => 'توکن نامعتبر است']);
            }
        }
        return $next($request);
    }
}
