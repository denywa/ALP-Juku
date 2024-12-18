<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\OrderController;

Route::get('/users', [UserController::class, 'index']); // Retrieve all users
Route::get('/users/{id}', [UserController::class, 'show']); // Retrieve a single user by ID
Route::post('/users', [UserController::class, 'store']); // Create a new user
// Route::put('/users/{id}', [UserController::class, 'update']); // Update a user by ID
Route::delete('/users/{id}', [UserController::class, 'destroy']);


Route::get('shipping-addresses', [ShippingAddressController::class, 'index']);
Route::get('shipping-addresses/{id}', [ShippingAddressController::class, 'show']);
Route::post('shipping-addresses', [ShippingAddressController::class, 'store']);
Route::put('shipping-addresses/{id}', [ShippingAddressController::class, 'update']);
Route::delete('shipping-addresses/{id}', [ShippingAddressController::class, 'destroy']);

Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::post('orders', [OrderController::class, 'store']);
Route::put('orders/{id}', [OrderController::class, 'update']);
Route::delete('orders/{id}', [OrderController::class, 'destroy']);
