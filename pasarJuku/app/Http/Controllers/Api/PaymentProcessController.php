<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\payment_process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentProcessController extends Controller
{
    public function index()
    {
        $paymentprocesses = payment_process::all();

        return response()->json([
            'status' => true,
            'message' => 'Payment processes retrieved successfully',
            'data' => $paymentprocesses
        ], 200);
    }

    /**
     * Store a newly created payment process in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderID' => 'required|exists:orders,orderID',
            'paymentID' => 'required|exists:payments,paymentID',
            'total_price' => 'required|integer|min:0',
            'payment_status' => 'required|in:pending,success',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $paymentprocesses = payment_process::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Payment process created successfully',
            'data' => $paymentprocesses
        ], 201);
    }

    /**
     * Display the specified payment process.
     */
    public function show($id)
    {
        $paymentprocesses = payment_process::find($id);

        if (!$paymentprocesses) {
            return response()->json([
                'status' => false,
                'message' => 'Payment process not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Payment process retrieved successfully',
            'data' => $paymentprocesses
        ], 200);
    }

    /**
     * Update the specified payment process in storage.
     */
    public function update(Request $request, $id)
    {
        $paymentprocesses = payment_process::find($id);

        if (!$paymentprocesses) {
            return response()->json([
                'status' => false,
                'message' => 'Payment process not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'orderID' => 'required|exists:orders,orderID',
            'paymentID' => 'required|exists:payments,paymentID',
            'total_price' => 'integer|min:0',
            'payment_status' => 'in:pending,success',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $paymentprocesses->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Payment process updated successfully',
            'data' => $paymentprocesses
        ], 200);
    }

    /**
     * Remove the specified payment process from storage.
     */
    public function destroy($id)
    {
        $paymentprocesses = payment_process::find($id);

        if (!$paymentprocesses) {
            return response()->json([
                'status' => false,
                'message' => 'Payment process not found'
            ], 404);
        }

        $paymentprocesses->delete();

        return response()->json([
            'status' => true,
            'message' => 'Payment process deleted successfully'
        ], 200);
    }
}
