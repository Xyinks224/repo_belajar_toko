<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class JWTMiddleware extends BaseMiddleware
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
        try 
        {
            $user = JWTAuth::parseToken()->authenticate();
        } 

        catch (Exception $e) 
        {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredExceptions)
            {
                return Response()->json(['status' => 'Token is Expired']);
            } 

            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidExceptions) 
            {
                return Response()->json(['status' => 'Token is Invalid']);
            }

            else
            {
                return Response()->json(['status' => 'Authorization Token not found']);
            }
            
        }
        return $next($request);
    }
}
