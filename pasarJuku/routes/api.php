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
