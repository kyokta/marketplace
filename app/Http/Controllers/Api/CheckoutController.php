<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\DetailCheckout;
use App\Models\DetailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function getCheckout()
    {
        $userId = auth()->id();
        $checkout = Checkout::where('user_id', $userId)->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Checkout retrieved successfully',
            'data' => $checkout
        ]);
    }

    public function addCheckout(Request $request)
    {
        $items = $request->items;
        $user = auth()->user();
        $userId = $user->id;

        DB::beginTransaction();
        try {
            $orderTotal = 0;

            foreach ($items as $item) {
                $cart = Cart::findOrFail($item['id']);
                $quantity = $item['quantity'];

                $orderTotal += $quantity * $cart->product->price;
            }

            $checkout = Checkout::create([
                'user_id' => $userId,
                'total_amount' => $orderTotal,
                'status' => 'pending'
            ]);

            foreach ($items as $item) {
                $cart = Cart::findOrFail($item['id']);
                $quantity = $item['quantity'];

                DetailCheckout::create([
                    'checkout_id' => $checkout->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $quantity,
                    'price' => $cart->product->price,
                    'total_price' => $quantity * $cart->product->price,
                ]);

                $order = Order::create([
                    'seller_id' => $cart->product->store,
                    'checkout_id' => $checkout->id,
                    'total_amount' => $orderTotal,
                    'status' => 'pending'
                ]);

                DetailOrder::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $quantity,
                    'price' => $cart->product->price,
                    'total_price' => $quantity * $cart->product->price,
                ]);
            }

            Cart::whereIn('id', array_column($items, 'id'))->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checkout completed successfully.',
                'checkout_id' => $checkout->id
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Checkout failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function detailCheckout($id)
    {
        $userId = auth()->id();

        $checkout = Checkout::where('id', $id)
            ->where('user_id', $userId)
            ->with('detailCheckouts.product')
            ->first();

        if (!$checkout) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data checkout not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'Detail checkout completed successfully',
            'checkout' => $checkout
        ]);
    }
}