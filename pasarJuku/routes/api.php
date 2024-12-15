<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// get user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login & Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
//reset-password
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
