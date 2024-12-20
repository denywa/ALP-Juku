<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderitems = order_item::all();
        return response()->json([
            'status' => true,
            'message' => 'Order items retrieved successfully',
            'data' => $orderitems
        ], 200);
    }

    public function show($id)
    {
        $orderitems = order_item::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Order items found successfully',
            'data' => $orderitems
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productID' => 'required|exists:products,productID', // pastikan productID ada di tabel products
            'quantity' => 'required|integer|min:1', // jumlah harus integer dan minimal 1
            'orderID' => 'required|exists:orders,orderID', // pastikan orderID ada di tabel orders
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $orderitems = order_item::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Order items created successfully',
            'data' => $orderitems
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'productID' => 'required|exists:products,productID', // pastikan productID ada di tabel products
            'quantity' => 'required|integer|min:1', // jumlah harus integer dan minimal 1
            'orderID' => 'required|exists:orders,orderID', // pastikan orderID ada di tabel orders
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari shipping address berdasarkan ID
        $orderitems = order_item::findOrFail($id);

        // Update data shipping address
        $orderitems->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Order items updated successfully',
            'data' => $orderitems
        ], 200);
    }

    public function destroy($id)
    {
        $orderitems = order_item::findOrFail($id);
        $orderitems->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order items deleted successfully',
        ], 200);
    }
}
