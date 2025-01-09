<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\shippingAddressController;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\businessProfileController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PaymentProcessController;
use App\Http\Controllers\Api\ReviewController;


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

//order items
Route::get('order-items', [OrderItemController::class, 'index']);
Route::get('order-items/{id}', [OrderItemController::class, 'show']);
Route::post('order-items', [OrderItemController::class, 'store']);
Route::put('order-items/{id}', [OrderItemController::class, 'update']);
Route::delete('order-items/{id}', [OrderItemController::class, 'destroy']);

//payment process
Route::get('payment-processes', [PaymentProcessController::class, 'index']);
Route::get('payment-processes/{id}', [PaymentProcessController::class, 'show']);
Route::post('payment-processes', [PaymentProcessController::class, 'store']);
Route::put('payment-processes/{id}', [PaymentProcessController::class, 'update']);
// Route::delete('payment-processes/{id}', [PaymentProcessController::class, 'destroy']);

//review
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('reviews/{id}', [ReviewController::class, 'show']);
Route::post('reviews', [ReviewController::class, 'store']);
Route::put('reviews/{id}', [ReviewController::class, 'update']);
// Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);
