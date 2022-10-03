<?php


namespace App\Services;



use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService
{
    protected function setModel()
    {
        $this->model = new User();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function register($data) {
        try{
            $register = User::query()->create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
            ]);
            return $this->responseSuccess($register);
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login($data) {
        try {
            $isRemember = $data['is_remember'];
            if ($isRemember) {
                JWTAuth::factory()->setTTL(Carbon::now()->addMonth()->subDay()->diffInMinutes(Carbon::now()));
            } else {
                JWTAuth::factory()->setTTL(Carbon::now()->addWeek()->diffInMinutes(Carbon::now()));
            }
            unset($data['is_remember']);
            $credentials = [
                'email' => $data['email'],
                'password' => $data['password'],
                'status' => User::USER_IS_ACTIVE['ACTIVE']
            ];
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->responseError(__('Login Error'), Response::HTTP_BAD_REQUEST);
            } else {
                return $this->responseSuccess([
                    'expires_in' => JWTAuth::factory()->getTTL(),
                    'access_token' => $token
                ]);;
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detailUser() {
        $user = Auth::user();
        return $this->responseSuccess(['user' => $user, 'roles' => ['admin']]);
    }


}
