<?php


namespace App\Http\Middleware;


use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Response;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (isset($user) && isset($user->status) && $user->status !== User::USER_IS_ACTIVE['ACTIVE']) {
                return response()->json(['message' => 'User deleted'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json(['message' => 'Token is Invalid'], Response::HTTP_UNAUTHORIZED);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['message' => 'Token is Expired'], Response::HTTP_UNAUTHORIZED);
            }else{
                return response()->json(['message' => 'Authorization Token not found'], Response::HTTP_UNAUTHORIZED);
            }
        }
        return $next($request);
    }
}
