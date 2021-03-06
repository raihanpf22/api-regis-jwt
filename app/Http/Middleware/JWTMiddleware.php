<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

class JWTMiddleware extends BaseMiddleware
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
        }catch(Exception $err){
            if ($err instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {

                return response()->json(['status' => 'Token is Invalid']);

            }elseif ($err instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                
                return response()->json(['status'=>'Token is Expired']);

            }else {
                return response()->json(['status' => 'Authorization Token not Found']);
            }

        }
        return $next($request);
    }
}
