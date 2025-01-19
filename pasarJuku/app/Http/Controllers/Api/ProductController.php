<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::all();
        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], 200);
    }

    public function show($id)
    {
        $product = product::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Product found successfully',
            'data' => $product
        ], 200);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoryID' => 'required|exists:category,categoryID',
            'unit' => 'required|string|in:kg,gr,liter,ml,pcs', // Added unit validation
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Upload image
        $image = $request->file('image');
        $image->storeAs('product-image', $image->hashName(), 'public');

        // Create product
        $product = product::create([
            'businessProfileID' => Auth::user()->businessProfile->businessProfileID, // Ensure businessProfileID is used as FK
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit, // Added unit field
            'stock' => $request->stock,
            'categoryID' => $request->categoryID,
            'image' => $image->hashName(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Find the product by ID
        $product = product::findOrFail($id);

        // Check if the authenticated user is the owner of the business profile
        if ($product->businessProfileID !== Auth::user()->businessProfile->businessProfileID) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this product.'
            ], 403);
        }

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'categoryID' => 'sometimes|required|exists:category,categoryID',
            'unit' => 'sometimes|required|string|in:kg,gr,liter,ml,pcs', // Added unit validation
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update image if a new file is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('product-image', $image->hashName(), 'public');
            $product->image = $image->hashName();
        }

        // Update product
        $product->update($request->only(['name', 'description', 'price', 'stock', 'categoryID', 'unit'])); // Added unit field

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
        // Find the product by ID
        $product = product::findOrFail($id);

        // Check if the authenticated user is the owner of the business profile
        if ($product->businessProfileID !== Auth::user()->businessProfile->businessProfileID) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this product.'
            ], 403);
        }

        // Delete the product
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ], 200);
    }

    public function search(Request $request)
    {
        // Validate the search parameter
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Perform the search
        $products = Product::where('name', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('description', 'LIKE', "%{$request->keyword}%")
                          ->get();

        // Check if there are no search results
        if ($products->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No search results found',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Search results retrieved successfully',
            'data' => $products
        ], 200);
    }
}
