<?php


namespace App\Http\Middleware;


use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Response;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyAccessKey
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
//            $user = JWTAuth::parseToken()->authenticate();
//            if (isset($user) && isset($user->status) && $user->status !== User::USER_IS_ACTIVE['ACTIVE']) {
//                return response()->json(['message' => 'User deleted'], Response::HTTP_UNAUTHORIZED);
//            }
            dd($request->route()->parameters());
            return response()->json(['message' => 'Key not found'], Response::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json(['message' => 'Page not found'], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
