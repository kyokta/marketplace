<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function getOrder()
    {
        $userId = auth()->id();
        $orders = DB::table('orders')
            ->select(
                'orders.checkout_id',
                DB::raw('MIN(orders.id) AS order_id'),
                'users.name AS customer_name',
                DB::raw('MIN(orders.created_at) AS order_date'),
                DB::raw('MIN(orders.total_amount) AS total_amount'),
                DB::raw('MIN(orders.status) AS status')
            )
            ->join('checkouts', 'orders.checkout_id', '=', 'checkouts.id')
            ->join('users', 'checkouts.user_id', '=', 'users.id')
            ->where('orders.seller_id', $userId)
            ->groupBy('orders.checkout_id', 'users.name')
            ->orderBy('orders.checkout_id')
            ->get();

        return view('seller.order', compact('orders'));
    }

    public function detailOrder($id)
    {
        $orderId = Order::where('checkout_id', $id)
            ->pluck('id')
            ->toArray();

        $status = Order::where('checkout_id', $id)->first()->status;

        $orders = DetailOrder::with(['products'])
            ->whereIn('order_id', $orderId)
            ->get();

        return response()->json([
            'status' => $status,
            'orders' => $orders,
        ]);
    }

    public function updateOrder(Request $request, $id)
    {
        $status = $request->status;

        $orderUpdated = Order::where('checkout_id', $id)
            ->update(['status' => $status]);

        if (!$orderUpdated) {
            return response()->json(['error' => 'Failed to update order status.'], 500);
        }

        $checkoutUpdated = Checkout::where('id', $id)
            ->update(['status' => $status]);

        if (!$checkoutUpdated) {
            return response()->json(['error' => 'Failed to update checkout status.'], 500);
        }

        if ($status === 'completed') {
            $orderIds = Order::where('checkout_id', $id)->pluck('id');
            foreach ($orderIds as $orderId) {
                $orderDetails = DetailOrder::where('order_id', $orderId)->get();
                foreach ($orderDetails as $detail) {
                    $product = Product::find($detail->product_id);

                    if ($product) {
                        $product->stock -= $detail->quantity;
                        $product->save();
                    } else {
                        return response()->json(['error' => 'Product not found.'], 500);
                    }
                }
            }
        }

        return response()->json(['message' => 'Order and Checkout status updated successfully.']);
    }
}