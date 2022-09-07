<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function index() {
        $users = $this->userService->getAllUsers();

        return ResponseHelper::handleControllerResponse([
            'success' => true,
            'data' => $users,
            'status_code' => 200,
        ]);
    }

    public function show($id) {
        $user = $this->userService->getUserById($id);

        return ResponseHelper::handleControllerResponse([
            'success' => !!$user,
            'data' => $user,
            'status_code' => $user ? 200 : 404,
            'message' => $user ? null : __('response.user_not_found'),
        ]);
    }

    public function store(CreateUserRequest $request) {
        $data = $request->only('name', 'email', 'password');

        $response = $this->userService->createUser($data);

        return ResponseHelper::handleControllerResponse($response);
    }

    public function update(UpdateUserRequest $request, $id) {
        $data = $request->only('name', 'email', 'password');

        $response = $this->userService->updateUser($id, $data);

        return ResponseHelper::handleControllerResponse($response);
    }

    public function destroy($id) {
        $response = $this->userService->deleteUser($id);

        return ResponseHelper::handleControllerResponse($response);
    }
}
