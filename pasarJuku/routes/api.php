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
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

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

//product
Route::middleware(['auth:sanctum', 'role:penambak'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']); // Create a new product
    Route::put('/products/{id}', [ProductController::class, 'update']); // Update a product by ID
    Route::delete('/products/{id}', [ProductController::class, 'destroy']); // Delete a product by ID
});

Route::get('/products', [ProductController::class, 'index']); // Retrieve all products
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/{id}', [ProductController::class, 'show']); // Retrieve a single product by ID

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user/{userID}/shipping-address')->group(function () {
        Route::post('/', [ShippingAddressController::class, 'createShippingAddress']);
        // Mengambil semua shipping address user
        Route::get('/', [ShippingAddressController::class, 'getUserShippingAddresses']);
        Route::get('/{shippingAddressID}', [ShippingAddressController::class, 'getShippingAddress']);
        Route::put('/{shippingAddressID}', [ShippingAddressController::class, 'updateShippingAddress']);
        Route::delete('/{shippingAddressID}', [ShippingAddressController::class, 'deleteShippingAddress']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('orders')->group(function () {
        // Create new order
        Route::post('/', [OrderController::class, 'createOrder']);
        // Get user's orders
        Route::get('/', [OrderController::class, 'getUserOrders']);
        // Get specific order detail
        Route::get('/{orderID}', [OrderController::class, 'getOrderDetail']);
        // Update order status
        Route::put('/{orderID}/status', [OrderController::class, 'updateOrderStatus']);
        // Cancel order
        Route::put('/{orderID}/cancel', [OrderController::class, 'cancelOrder']);
    });
});

//payment process
Route::get('payment-processes', [PaymentProcessController::class, 'index']);
Route::get('payment-processes/{id}', [PaymentProcessController::class, 'show']);
Route::post('payment-processes', [PaymentProcessController::class, 'store']);
Route::put('payment-processes/{id}', [PaymentProcessController::class, 'update']);
// Route::delete('payment-processes/{id}', [PaymentProcessController::class, 'destroy']);

//review


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('review')->group(function () {
        // Endpoint untuk membuat review
        Route::post('/order-item/{orderItemID}', [ReviewController::class, 'createReview']);
        // Endpoint untuk mendapatkan review berdasarkan order item ID
        Route::get('/order-item/{orderItemID}', [ReviewController::class, 'getReviewsByOrderItem']);
        // Endpoint untuk mendapatkan semua review milik user yang sedang login
        Route::get('/user', [ReviewController::class, 'getUserReviews']);
        Route::put('/{reviewID}', [ReviewController::class, 'updateReview']);
        Route::get('/average-rating/{productID}', [ReviewController::class, 'getAverageRatingByProduct']);
        
    });
});
