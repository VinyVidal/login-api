<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request) {
        $data = $request->only('email', 'password');

        $response = $this->authService->login($data['email'], $data['password']);

        return ResponseHelper::handleControllerResponse($response);
    }

    public function revokeAllTokens(Request $request) {
        $response = $this->authService->revokeAllTokens($request->user()->id);

        return ResponseHelper::handleControllerResponse($response);
    }
}
