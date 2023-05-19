<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePasswordController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);



Route::put('/change-password/{user_id}', [ChangePasswordController::class, 'update']);



Route::group(['middleware' => ['auth:sanctum', 'role:super-admin'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', function () {
        // code to display dashboard
    });
});

