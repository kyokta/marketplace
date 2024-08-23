<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\DetailCheckout;
use App\Models\DetailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $history = Checkout::where('user_id', $userId)->get();

        return view('user.history', compact('history'));
    }

    public function checkout(Request $request)
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

            return response()->json(['success' => 'Checkout completed successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function detailCheckout($id)
    {
        $userId = auth()->id();

        $checkout = Checkout::where('user_id', $userId)
            ->with('detailCheckouts.product')
            ->findOrFail($id);

        return response()->json([
            'checkout' => $checkout
        ]);
    }
}