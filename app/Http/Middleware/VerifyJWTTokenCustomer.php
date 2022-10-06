<?php


namespace App\Http\Middleware;


use App\Models\Customer;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Response;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJWTTokenCustomer
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
            Config::set('jwt.user', Customer::class);
            Config::set('auth.providers', ['users' => [
                'driver' => 'eloquent',
                'model' => Customer::class,
            ]]);
            $user = JWTAuth::parseToken()->authenticate();
            if (isset($user) && isset($user->status) && $user->status !== Customer::CUSTOMER_IS_ACTIVE['ACTIVE']) {
                return response()->json(['message' => 'Customer deleted'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json(['message' => 'Token is Invalid'], Response::HTTP_UNAUTHORIZED);
            }

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['message' => 'Token is Expired'], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json(['message' => 'Authorization Token not found'], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
