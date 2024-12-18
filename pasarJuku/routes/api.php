<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

//user
Route::get('/users', [UserController::class, 'index']); // Retrieve all users
Route::get('/users/{id}', [UserController::class, 'show']); // Retrieve a single user by ID
Route::post('/users', [UserController::class, 'store']); // Create a new user
// Route::put('/users/{id}', [UserController::class, 'update']); // Update a user by ID
Route::delete('/users/{id}', [UserController::class, 'destroy']);
