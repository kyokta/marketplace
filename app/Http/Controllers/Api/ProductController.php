<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function dashboard()
    {
        try {
            $sellerId = auth()->user()->id;

            $salesData = DetailOrder::join('orders', 'detail_orders.order_id', '=', 'orders.id')
                ->join('products', 'detail_orders.product_id', '=', 'products.id')
                ->where('orders.seller_id', $sellerId)
                ->where('orders.status', 'completed')
                ->select(
                    DB::raw('SUM(detail_orders.quantity) as total_sales'),
                    DB::raw('SUM(detail_orders.quantity * products.price) as total_revenue')
                )
                ->first();

            $product = DetailOrder::join('orders', 'detail_orders.order_id', '=', 'orders.id')
                ->join('products', 'detail_orders.product_id', '=', 'products.id')
                ->where('orders.seller_id', $sellerId)
                ->select(
                    'detail_orders.product_id',
                    DB::raw('SUM(detail_orders.quantity) as total_quantity')
                )
                ->groupBy('detail_orders.product_id')
                ->orderBy('total_quantity', 'desc')
                ->first();

            $pendingOrders = Order::where('seller_id', $sellerId)
                ->where('status', 'pending')
                ->select('checkout_id')
                ->distinct()
                ->count('checkout_id');

            $data = [
                'totalSales' => $salesData->total_sales ?? 0,
                'totalRevenue' => $salesData->total_revenue ?? 0,
                'productListed' => Product::where('store', $sellerId)->count() ?? 0,
                'topProduct' => $product ? Product::find($product->product_id)->name ?? '-' : '-',
                'pendingOrders' => $pendingOrders ?? 0,
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Dashboard data retrieved successfully!',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve dashboard data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllProduct(Request $request)
    {
        try {
            $keyword = $request->input('keyword');

            $query = Product::query();

            if ($keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%");
                });
            }

            $products = $query->get()->map(function ($product) {
                $product->image = asset('storage/' . $product->image);
                return $product;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Products have been successfully retrieved.',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve products.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductByUser(Request $request)
    {
        try {
            $userId = auth()->id();
            $keyword = $request->input('keyword');

            $query = Product::where('store', $userId);

            if ($keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%");
                });
            }

            $products = $query->get()->map(function ($product) {
                $product->image = asset('storage/' . $product->image);
                return $product;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Products have been successfully retrieved.',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve products.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductById($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product not found'
            ], 404);
        }

        $product->image = asset('storage/' . $product->image);

        return response()->json([
            'status' => 'success',
            'message' => 'Product found',
            'data' => $product
        ]);
    }

    public function storeProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'category' => 'required|integer|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validatedData = $validator->validated();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            $product = Product::create([
                'name' => $validatedData['name'],
                'store' => auth()->id(),
                'category_id' => $validatedData['category'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'image' => $imagePath,
                'description' => $validatedData['description'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added successfully!',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to add product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product not found.'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'category' => 'nullable|integer|exists:categories,id',
                'price' => 'nullable|numeric|min:0',
                'stock' => 'nullable|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->image = $request->file('image')->store('products', 'public');
            }

            $product->name = $request->input('name', $product->name);
            $product->category_id = $request->input('category', $product->category_id);
            $product->price = $request->input('price', $product->price);
            $product->stock = $request->input('stock', $product->stock);
            $product->description = $request->input('description', $product->description);
            $product->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully!',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to update product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product not found.'
            ], 404);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product successfully deleted.'
        ]);
    }
}