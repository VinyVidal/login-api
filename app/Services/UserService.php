<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService {
    /**
     * @return User[]
     */
    public function getAllUsers() {
        return User::orderBy('id')->get();
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function getUserById($id) {
        return User::find($id);
    }

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail($email) {
        return User::where('email', $email)->first();
    }

    public function createUser($data) {
        try {
            $user = new User([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            if(env('PW_CRYPT', true) === true) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();
            return ResponseHelper::handleServiceSuccess($user, 201);
        } catch (Exception $e) {
            return ResponseHelper::handleServiceException($e);
        }
    }

    public function updateUser($id, $data) {
        try {
            $user = $this->getUserById($id);

            if(!$user) {
                throw new ServiceException(__('response.user_not_found'), 404);
            }

            $userData = [
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'password' => $data['password'] ?? null,
            ];
            $user->fill(array_filter($userData, function($field) {
                return $field !== null;
            }));

            if($userData['password'] && env('PW_CRYPT', true) === true) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();
            return ResponseHelper::handleServiceSuccess($user);
        } catch (Exception $e) {
            return ResponseHelper::handleServiceException($e);
        }
    }

    public function deleteUser($id) {
        try {
            $user = $this->getUserById($id);

            if($user) {
                $user->delete();
            }

            return ResponseHelper::handleServiceSuccess(null, 204);
        } catch (Exception $e) {
            return ResponseHelper::handleServiceException($e);
        }
    }

    public function createToken(int $userId, $tokenName = 'access-token') {
        try {
            $user = $this->getUserById($userId);

            if(!$user) {
                throw new ServiceException(__('response.user_not_found'), 404);
            }

            $user->tokens()->delete();

            $token = $user->createToken($tokenName);

            return ResponseHelper::handleServiceSuccess($token);
        } catch (Exception $e) {
            return ResponseHelper::handleServiceException($e);
        }
    }
}
