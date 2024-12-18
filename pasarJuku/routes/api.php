<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\shippingAddressController;
// get user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login & Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); //logout with token
});
//reset-password
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

//businessProfile
 //middleware hanya penambak yang bisa buat dan lihat profilenya 
Route::middleware(['auth:sanctum', 'role:penambak'])->group(function () {
    Route::post('/business-profile', [App\Http\Controllers\Api\businessProfileController::class, 'store']);   // Create a new profile
    Route::get('/business-profile/user', [App\Http\Controllers\Api\businessProfileController::class, 'show']); // Get profile by token logged in
});

//user
Route::get('/users', [UserController::class, 'index']); // Retrieve all users
Route::get('/users/{id}', [UserController::class, 'show']); // Retrieve a single user by ID
Route::post('/users', [UserController::class, 'store']); // Create a new user
Route::put('/users/{id}', [UserController::class, 'update']); // Update a user by ID
Route::delete('/users/{id}', [UserController::class, 'destroy']);

//shipping address

Route::get('shipping-addresses', [shippingAddressController::class, 'index']);
Route::get('shipping-addresses/{id}', [shippingAddressController::class, 'show']);
Route::post('shipping-addresses', [shippingAddressController::class, 'store']);
Route::put('shipping-addresses/{id}', [shippingAddressController::class, 'update']);
Route::delete('shipping-addresses/{id}', [shippingAddressController::class, 'destroy']);

