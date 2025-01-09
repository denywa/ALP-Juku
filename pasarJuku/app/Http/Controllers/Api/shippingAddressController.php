<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ShippingAddressResource;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $addresses = ShippingAddress::all();
        return response()->json([
            'status' => true,
            'message' => 'Shipping addresses retrieved successfully',
            'data' => ShippingAddressResource::collection($addresses)
        ], 200);
    }

    public function show($id)
    {
        try {
            $address = ShippingAddress::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Shipping address found successfully',
                'data' => new ShippingAddressResource($address)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Shipping address not found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pos_code' => 'required|integer|digits:5',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $address = ShippingAddress::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Shipping address created successfully',
                'data' => new ShippingAddressResource($address)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create shipping address'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pos_code' => 'required|integer|digits:5',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $address = ShippingAddress::findOrFail($id);
            $address->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Shipping address updated successfully',
                'data' => new ShippingAddressResource($address)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update shipping address'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $address = ShippingAddress::findOrFail($id);
            $address->delete();

            return response()->json([
                'status' => true,
                'message' => 'Shipping address deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete shipping address'
            ], 500);
        }
    }
}
