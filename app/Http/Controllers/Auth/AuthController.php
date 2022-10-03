<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    protected function setModel()
    {
        $this->model = new User();
    }

    public function __construct(AuthService $authService)
    {
        parent::__construct();
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request) {
        return $this->authService->register($request->getData());
    }

    public function login(LoginRequest $request) {
        return $this->authService->login($request->getData());
    }

    public function details() {
        return $this->authService->detailUser();
    }

    public function logout() {
        auth()->logout();
        return response()->json([], Response::HTTP_OK);
    }
}
