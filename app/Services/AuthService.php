<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function login($email, $password)
    {
        try {
            $user = $this->userService->getUserByEmail($email);
            if ($user) {
                $pwMatch = env('PW_CRYPT', true) === true ? Hash::check($password, $user->password) : $password === $user->password;
                if (!$pwMatch) {
                    $user = null;
                }
            }

            if (!$user) {
                throw new ServiceException(__('response.invalid_credentials'), 401);
            }

            $result = $this->userService->createToken($user->id);
            if (!$result['success']) {
                throw new ServiceException($result['message'], $result['status_code']);
            }

            return ResponseHelper::handleServiceSuccess([
                'token' => $result['data']->plainTextToken,
                'token_type' => 'Bearer'
            ]);
        } catch (Exception $e) {
            return ResponseHelper::handleServiceException($e);
        }
    }

    public function revokeAllTokens($id) {
        try {
            $user = $this->userService->getUserById($id);

            if(!$user) {
                throw new ServiceException(__('response.user_not_found'), 404);
            }

            $user->tokens()->delete();

            return ResponseHelper::handleServiceSuccess(null, 204);
        } catch (Exception $e) {
            return ResponseHelper::handleServiceException($e);
        }
    }
}
