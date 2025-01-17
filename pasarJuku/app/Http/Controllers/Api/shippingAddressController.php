<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\user_shippingAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShippingAddressController extends Controller
{
    /**
     * Verify if the authenticated user matches the requested userID
     */
    private function verifyUser($userID)
    {
        if (Auth::id() != $userID) {
            return false;
        }
        return true;
    }

    /**
     * Create a new shipping address for specific user
     */
    public function createShippingAddress(Request $request, $userID)
    {
        // Verify user authorization
        if (!$this->verifyUser($userID)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'pos_code' => 'required|integer|digits_between:5,6',
                'recipient_name' => 'required|string|max:100',
                'phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Create shipping address
            $shippingAddress = shippingAddress::create([
                'address' => $request->address,
                'city' => $request->city,
                'pos_code' => $request->pos_code,
                'recipient_name' => $request->recipient_name,
                'phone' => $request->phone
            ]);

            // Create relation in pivot table
            $userShippingAddress = user_shippingAddress::create([
                'userID' => $userID,
                'shippingAddressID' => $shippingAddress->shippingAddressID
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Shipping address created successfully',
                'data' => [
                    'shippingAddress' => $shippingAddress,
                    'user_shippingAddressID' => $userShippingAddress->user_shippingAddressID
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create shipping address'
            ], 500);
        }
    }

    /**
     * Get all shipping addresses for specific user
     */
    public function getUserShippingAddresses($userID)
    {
        // Verify user authorization
        if (!$this->verifyUser($userID)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            $userShippingAddresses = DB::table('user_shippingaddress')
                ->join('shippingAddress', 'user_shippingaddress.shippingAddressID', '=', 'shippingAddress.shippingAddressID')
                ->where('user_shippingaddress.userID', $userID)
                ->select(
                    'user_shippingaddress.user_shippingAddressID',
                    'shippingAddress.shippingAddressID',
                    'shippingAddress.address',
                    'shippingAddress.city',
                    'shippingAddress.pos_code',
                    'shippingAddress.recipient_name',
                    'shippingAddress.phone'
                )
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $userShippingAddresses,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch shipping addresses'
            ], 500);
        }
    }

    public function getShippingAddress($userID, $shippingAddressID)
    {
        // Verify user authorization
        if (!$this->verifyUser($userID)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            // Check if address exists and belongs to user
            $userAddress = user_shippingAddress::where('userID', $userID)
                ->where('shippingAddressID', $shippingAddressID)
                ->with('shippingAddress')
                ->first();

            if (!$userAddress) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Address not found or unauthorized'
                ], 404);
            }

            // Format the address data
            $addressDetail = [
                'shipping_address_id' => $userAddress->shippingAddress->shippingAddressID,
                'address' => $userAddress->shippingAddress->address,
                'city' => $userAddress->shippingAddress->city,
                'pos_code' => $userAddress->shippingAddress->pos_code,
                'recipient_name' => $userAddress->shippingAddress->recipient_name,
                'phone' => $userAddress->shippingAddress->phone,
                'created_at' => $userAddress->shippingAddress->created_at,
                'updated_at' => $userAddress->shippingAddress->updated_at
            ];

            return response()->json([
                'status' => 'success',
                'data' => $addressDetail
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch shipping address detail'
            ], 500);
        }
    }

    /**
     * Update specific shipping address
     */
    public function updateShippingAddress(Request $request, $userID, $shippingAddressID)
    {
        // Verify user authorization
        if (!$this->verifyUser($userID)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'pos_code' => 'required|integer|digits_between:5,6',
                'recipient_name' => 'required|string|max:100',
                'phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            // Check if address belongs to user
            $userAddress = user_shippingAddress::where('userID', $userID)
                ->where('shippingAddressID', $shippingAddressID)
                ->first();

            if (!$userAddress) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Address not found or unauthorized'
                ], 404);
            }

            // Update shipping address
            $shippingAddress = shippingAddress::find($shippingAddressID);
            $shippingAddress->update([
                'address' => $request->address,
                'city' => $request->city,
                'pos_code' => $request->pos_code,
                'recipient_name' => $request->recipient_name,
                'phone' => $request->phone
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Shipping address updated successfully',
                'data' => $shippingAddress
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update shipping address'
            ], 500);
        }
    }

    /**
     * Delete specific shipping address
     */
    public function deleteShippingAddress($userID, $shippingAddressID)
    {
        // Verify user authorization
        if (!$this->verifyUser($userID)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            DB::beginTransaction();

            // Check if address belongs to user
            $userAddress = user_shippingAddress::where('userID', $userID)
                ->where('shippingAddressID', $shippingAddressID)
                ->first();

            if (!$userAddress) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Address not found or unauthorized'
                ], 404);
            }

            // Delete from pivot table first
            $userAddress->delete();

            // Delete shipping address
            shippingAddress::find($shippingAddressID)->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Shipping address deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete shipping address'
            ], 500);
        }
    }
}
