<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\DetailCheckout;
use App\Models\DetailOrder;
use App\Models\DetailUser;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class HistoryController extends Controller
{
    public function index()
    {
        $history = Checkout::all();

        return view('user.history', compact('history'));
    }

    public function checkout(Request $request)
    {
        $items = $request->cartIds;
        $user = auth()->user();
        $userId = $user->id;
        $name = $user->name;
        $phone = $user->phone;
        $address = $user->detail->address ?? null;

        DB::beginTransaction();
        try {
            $carts = Cart::whereIn('id', $items)->get();

            $orderTotal = 0;
            foreach ($carts as $cart) {
                $orderTotal += $cart->quantity * $cart->product->price;
            }

            $checkout = Checkout::create([
                'user_id' => $userId,
                'total_amount' => $orderTotal,
                'status' => 'pending'
            ]);

            foreach ($carts as $cart) {
                DetailCheckout::create([
                    'checkout_id' => $checkout->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'total_price' => $cart->quantity * $cart->product->price,
                ]);

                $order = Order::create([
                    'seller_id' => $cart->product->store,
                    'checkout_id' => $checkout->id,
                    'customer_id' => $userId,
                    'name' => $name,
                    'address' => $address,
                    'phone' => $phone,
                    'total_amount' => $orderTotal,
                    'status' => 'pending'
                ]);

                DetailOrder::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'total_price' => $cart->quantity * $cart->product->price,
                ]);
            }

            Cart::whereIn('id', $items)->delete();

            DB::commit();

            return response()->json(['success' => 'Checkout completed successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred during checkout.'], 500);
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