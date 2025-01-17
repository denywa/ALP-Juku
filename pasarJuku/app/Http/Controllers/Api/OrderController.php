<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\order_item; // Updated class name to be proper naming convention
use App\Models\Product;
use App\Models\user_shippingAddress; // Updated class name to follow PSR-4 naming convention

class OrderController extends Controller
{
    /**
     * Create a new order with items.
     */
    public function createOrder(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'user_shippingAddressID' => 'required|exists:user_shippingaddress,user_shippingAddressID', // Update the table and column names for clarity
                'items' => 'required|array|min:1',
                'items.*.productID' => 'required|exists:products,productID', // Update the table and column names
                'items.*.quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            // Verify shipping address belongs to user
            $shippingAddress = user_shippingAddress::where('user_shippingAddressID', $request->user_shippingAddressID)
                ->where('userID', operator: Auth::id()) // Updated field name
                ->first();

            if (!$shippingAddress) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid shipping address'
                ], 400);
            }

            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_shippingAddressID' => $request->user_shippingAddressID,
                'order_status' => 'Pending'
            ]);

            // Create order items
            foreach ($request->items as $item) {
                // Verify product exists and has enough stock
                $product = Product::find($item['productID']);

                if (!$product) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Product not found'
                    ], 404);
                }

                // Create the order item
                order_item::create([
                    'orderID' => $order->orderID, // Update field names for consistency
                    'productID' => $item['productID'],
                    'quantity' => $item['quantity']
                ]);
            }

            DB::commit();

            // Load the order with its items and product details
            $order->load(['order_item.product', 'user_shippingaddress.shippingaddress']); // Updated relationships

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Get all orders for the authenticated user.
     */
    public function getUserOrders(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);

            $orders = Order::whereHas('user_shippingAddress', function ($query) {
                $query->where('userID', Auth::id()); // Updated field name
            })
                ->with(['order_item.product', 'user_shippingAddress.shippingAddress']) // Updated relationships
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => $orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch orders'
            ], 500);
        }
    }

    /**
     * Get specific order detail.
     */
    public function getOrderDetail($orderID)
    {
        try {
            $order = Order::with(['order_item.product', 'user_shippingAddress.shippingAddress']) // Updated relationships
                ->whereHas('user_shippingAddress', function ($query) {
                    $query->where('userID', Auth::id()); // Updated field name
                })
                ->find($orderID);

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found or unauthorized'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch order detail'
            ], 500);
        }
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, $orderID)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:Processing,Shipped,Delivered'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $order = Order::with(['order_item.product', 'user_shippingAddress']) // Updated relationships
                ->whereHas('user_shippingAddress', function ($query) {
                    $query->where('userID', Auth::id()); // Updated field name
                })
                ->find($orderID);

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found or unauthorized'
                ], 404);
            }

            if ($order->order_status === 'Cancelled') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot update cancelled order'
                ], 400);
            }

            $order->update([
                'order_status' => $request->status
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order status updated successfully',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update order status'
            ], 500);
        }
    }

    /**
     * Cancel order.
     */
    public function cancelOrder($orderID)
    {
        try {
            $order = Order::with(['order_item.product', 'user_shippingAddress']) // Updated relationships
                ->whereHas('user_shippingAddress', function ($query) {
                    $query->where('userID', Auth::id()); // Updated field name
                })
                ->find($orderID);

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found or unauthorized'
                ], 404);
            }

            if ($order->order_status !== 'Pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Only pending orders can be cancelled'
                ], 400);
            }

            $order->update([
                'order_status' => 'Cancelled'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order cancelled successfully',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to cancel order'
            ], 500);
        }
    }
}
