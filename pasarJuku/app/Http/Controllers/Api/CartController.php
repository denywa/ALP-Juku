<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a list of all products in the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::id();
        $cart = Cart::where('userID', $user)->get();
        return response()->json($cart);
    }

    /**
     * Store a newly created product in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'productID' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        $user = Auth::id();
        $product = Product::find($validatedData['productID']);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cart = Cart::where([
            ['userID', $user],
            ['productID', $validatedData['productID']],
        ])->first();

        // Hitung total harga
        $totalPrice = $validatedData['quantity'] * $product->price;

        if ($cart) {
            $cart->increment('quantity', $validatedData['quantity']);
            $cart->total_price = $cart->quantity * $product->price; // Update total_price
            $cart->save();
        } else {
            Cart::create([
                'userID' => $user,
                'productID' => $validatedData['productID'],
                'quantity' => $validatedData['quantity'],
                'total_price' => $totalPrice, // Set total_price saat membuat item baru
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Product added to cart successfully', 'data' => ['productID' => $validatedData['productID'], 'quantity' => $validatedData['quantity'], 'totalPrice' => $totalPrice]], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer',
        ]);

        $user = Auth::id();
        $cart = Cart::where([
            ['userID', $user],
            ['cartID', $id],
        ])->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $product = $cart->product;
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cart->quantity = $validatedData['quantity'];
        $cart->total_price = $validatedData['quantity'] * $product->price; // Update total_price
        $cart->save();

        return response()->json(['success' => true, 'message' => 'Cart item updated successfully', 'data' => ['cartID' => $id, 'quantity' => $validatedData['quantity'], 'totalPrice' => $cart->total_price]], 200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::id();
        $cart = Cart::where([
            ['userID', $user],
            ['cartID', $id],
        ])->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cart->delete();

        return response()->json(['success' => true, 'message' => 'Cart item removed successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::id();
        $cart = Cart::where([
            ['userID', $user],
            ['cartID', $id],
        ])->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Cart item found', 'data' => $cart], 200);
    }
}
