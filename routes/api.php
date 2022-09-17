<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth', [AuthController::class, 'login']);

Route::apiResource('user', UserController::class)->only('store');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('auth/me', [AuthController::class, 'user']);
    Route::delete('auth/token', [AuthController::class, 'revokeAllTokens']);

    Route::apiResource('user', UserController::class)->except('store');
});
