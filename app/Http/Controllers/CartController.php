<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();

        $total = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });

        return view('user.cart', compact('carts', 'total'));
    }

    public function storeCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add product to cart.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteChart($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->delete()) {
            return response()->json(['success' => true, 'message' => 'Item deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to delete item'], 500);
        }
    }
}