<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\shippingAddressController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PaymentProcessController;
use App\Http\Controllers\Api\ReviewController;

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

//shipping address
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
