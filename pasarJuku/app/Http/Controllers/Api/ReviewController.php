<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = review::all();
        return response()->json([
            'status' => true,
            'message' => 'Reviews retrieved successfully',
            'data' => $reviews
        ], 200);
    }

    public function show($id)
    {
        $reviews = review::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Reviews found successfully',
            'data' => $reviews
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userID' => 'required|exists:users,userID',
            'order_itemID' => 'required|exists:order_items,order_itemID',  
            'rating' => 'required|integer|between:1,5', 
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $reviews = review::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Reviews created successfully',
            'data' => $reviews
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'userID' => 'required|exists:users,userID',
            'order_itemID' => 'required|exists:order_items,order_itemID',  
            'rating' => 'required|integer|between:1,5', 
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari shipping address berdasarkan ID
        $reviews = review::findOrFail($id);

        // Update data shipping address
        $reviews->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Reviews updated successfully',
            'data' => $reviews
        ], 200);
    }

    public function destroy($id)
    {
        $reviews = review::findOrFail($id);
        $reviews->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reviews deleted successfully',
        ], 200);
    }
}
