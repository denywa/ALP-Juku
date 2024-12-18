<?php

namespace App\Http\Controllers;

use App\Models\shippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class shippingAddressController extends Controller
{
    public function index()
    {
        $addresses = shippingAddress::all();
        return response()->json([
            'status' => true,
            'message' => 'Shipping addresses retrieved successfully',
            'data' => $addresses
        ], 200);
    }

    public function show($id)
    {
        $addresses = shippingAddress::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Shipping address found successfully',
            'data' => $addresses
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pos_code' => 'required|integer|max:5',
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

        $address = shippingAddress::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Shipping address created successfully',
            'data' => $address
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pos_code' => 'required|integer|max:5',
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

        // Cari shipping address berdasarkan ID
        $addresses = shippingAddress::findOrFail($id);

        // Update data shipping address
        $addresses->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Shipping address updated successfully',
            'data' => $addresses
        ], 200);
    }

    public function destroy($id)
    {
        $addresses = shippingAddress::findOrFail($id);
        $addresses->delete();

        return response()->json([
            'status' => true,
            'message' => 'Shipping address deleted successfully',
        ], 200);
    }
}
