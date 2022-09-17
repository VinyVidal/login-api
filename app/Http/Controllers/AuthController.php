<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function user() {
        $user = Auth::user();
        return ResponseHelper::handleControllerResponse([
            'success' => !!$user,
            'data' => $user,
            'status_code' => $user ? 200 : 404,
        ]);
    }

    public function revokeAllTokens(Request $request) {
        $response = $this->authService->revokeAllTokens($request->user()->id);

        return ResponseHelper::handleControllerResponse($response);
    }
}
