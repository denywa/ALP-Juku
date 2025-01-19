<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\order_item;

class ReviewController extends Controller
{
    /**
     * Membuat review untuk order item tertentu
     */
    public function createReview(Request $request, $orderItemID)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }

        // Pastikan order item ada dan milik pengguna yang sedang login
        $orderItem = order_item::where('order_itemID', $orderItemID)
            ->whereHas('order', function ($query) {
                $query->whereHas('user_ShippingAddress', function ($q) {
                    $q->where('userID', Auth::id());
                });
            })
            ->first();

        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found or unauthorized',
            ], 404);
        }

        // Cek apakah review untuk order item ini sudah ada
        $existingReview = review::where('order_itemID', $orderItemID)->first();
        if ($existingReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'Review for this order item already exists',
            ], 400);
        }

        // Buat review baru
        $review = review::create([
            'userID' => Auth::id(), // Tambahkan baris ini
            'order_itemID' => $orderItemID,
            'shippingAddressID' => $orderItem->order->user_shippingAddressID,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Review created successfully',
            'data' => $review,
        ], 201);
    }

    public function updateReview(Request $request, $reviewID)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }

        // Cari review berdasarkan reviewID dan pastikan milik user yang sedang login
        $review = Review::where('reviewID', $reviewID)
            ->whereHas('user', function ($query) {
                $query->where('userID', Auth::id());
            })
            ->first();

        if (!$review) {
            return response()->json([
                'status' => 'error',
                'message' => 'Review not found or unauthorized',
            ], 404);
        }

        // Perbarui review
        $review->update($request->only(['rating', 'comment']));

        return response()->json([
            'status' => 'success',
            'message' => 'Review updated successfully',
            'data' => $review,
        ], 200);
    }

    /**
     * Mendapatkan semua review berdasarkan order item ID
     */
    public function getReviewsByOrderItem($orderItemID)
    {
        $reviews = review::where('order_itemID', $orderItemID)->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No reviews found for this order item',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $reviews,
        ]);
    }

    /**
     * Mendapatkan semua review untuk user yang sedang login
     */
    public function getUserReviews()
    {
        $reviews = review::whereHas('user', function ($query) {
            $query->where('userID', Auth::id());
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $reviews,
        ]);
    }

    public function getAverageRatingByProduct($productID)
    {
        // Hitung rata-rata rating untuk produk tertentu
        $averageRating = review::whereHas('order_item', function ($query) use ($productID) {
            $query->where('productID', $productID);
        })->avg('rating');

        if ($averageRating === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'No reviews found for this product',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'productID' => $productID,
            'average_rating' => $averageRating,
        ]);
    }
}
