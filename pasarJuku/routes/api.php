<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\shippingAddressController;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\businessProfileController;


Route::get("/", function (Request $request) {
    return response()->json([
        "message" => "Invalid token, please login"
    ], Response::HTTP_UNAUTHORIZED);
})->name("login");

// Login & Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); //logout with token

//reset-password
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

//businessProfile
//middleware hanya penambak yang bisa buat dan lihat profilenya 
Route::middleware(['auth:sanctum', 'role:penambak'])->group(function () {
    Route::get('/business-profiles', [businessProfileController::class, 'index']);
    Route::get('/business-profiles/me', [businessProfileController::class, 'getMyData']); // Get profile by token logged in
    Route::post('/business-profiles', [businessProfileController::class, 'store']);   // Create a new profile
    Route::get('/business-profiles/{id}', [businessProfileController::class, 'show']);
    Route::put('/business-profiles/{id}', [businessProfileController::class, 'update']);
    Route::delete('/business-profiles/{id}', [businessProfileController::class, 'destroy']);
});

//user
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Retrieve all users
    Route::get('/users/me', [UserController::class, 'getMyData']); // Get user by token logged in
    Route::get('/users/{id}', [UserController::class, 'show']); // Retrieve a single user by ID
    Route::post('/users', [UserController::class, 'store']); // Create a new user
    Route::put('/users/{id}', [UserController::class, 'update']); // Update a user by ID
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete a user by ID
});


Route::get('shipping-addresses', [shippingAddressController::class, 'index']);
Route::get('shipping-addresses/{id}', [shippingAddressController::class, 'show']);
Route::post('shipping-addresses', [shippingAddressController::class, 'store']);
Route::put('shipping-addresses/{id}', [shippingAddressController::class, 'update']);
Route::delete('shipping-addresses/{id}', [shippingAddressController::class, 'destroy']);

