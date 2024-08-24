<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCart()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();

        $total = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });

        return response()->json([
            'status' => 'Success',
            'message' => 'Cart retrieved successfully',
            'data' => [
                'carts' => $carts,
                'totalPayment' => $total
            ]
        ]);
    }

    public function addCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Product added to cart successfully!',
                'data' => $cart
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to add product to cart.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteCart($id)
    {
        $userId = auth()->id();

        $cart = Cart::where('id', $id)->first();

        if (!$cart) {
            return response()->json(['status' => 'Failed', 'message' => 'Item not found or does not belong to you'], 404);
        }

        if ($cart->delete()) {
            return response()->json(['status' => 'Success', 'message' => 'Item deleted successfully']);
        } else {
            return response()->json(['status' => 'Failed', 'message' => 'Failed to delete item'], 500);
        }
    }
}