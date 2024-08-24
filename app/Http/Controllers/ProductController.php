<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $sellerId = auth()->user()->id;

        $salesData = DetailOrder::join('orders', 'detail_orders.order_id', '=', 'orders.id')
            ->join('products', 'detail_orders.product_id', '=', 'products.id')
            ->where('orders.seller_id', $sellerId)
            ->select(
                DB::raw('SUM(detail_orders.quantity) as total_sales'),
                DB::raw('SUM(detail_orders.quantity * products.price) as total_revenue')
            )
            ->where('orders.status', 'completed')
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

        return view('seller.dashboard', compact('data'));
    }

    public function getProduct()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('seller.product', compact('products', 'categories'));
    }

    public function detailProduct($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'productCategory' => 'required|integer|exists:categories,id',
            'productPrice' => 'required|numeric|min:0',
            'productStock' => 'required|integer|min:0',
            'productImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'productDescription' => 'required|string',
        ]);

        if ($request->hasFile('productImage')) {
            $imagePath = $request->file('productImage')->store('products', 'public');
        } else {
            $imagePath = null;
        }

        Product::create([
            'name' => $request->input('productName'),
            'store' => auth()->id(),
            'category_id' => $request->input('productCategory'),
            'price' => $request->input('productPrice'),
            'stock' => $request->input('productStock'),
            'image' => $imagePath,
            'description' => $request->input('productDescription'),
        ]);

        return redirect()->route('seller.product')->with('success', 'Product added successfully!');
    }

    public function editProduct($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'productName' => 'required|string|max:255',
            'productCategory' => 'required|exists:categories,id',
            'productPrice' => 'required|numeric',
            'productStock' => 'required|integer',
            'productImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'productDescription' => 'nullable|string',
        ]);

        $product->name = $validatedData['productName'];
        $product->category_id = $validatedData['productCategory'];
        $product->price = $validatedData['productPrice'];
        $product->stock = $validatedData['productStock'];
        $product->description = $validatedData['productDescription'];

        if ($request->input('removeImage') === 'true') {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = null;
        }

        if ($request->hasFile('productImage')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('productImage')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('seller.product')->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()->route('seller.product')->with('success', 'Product deleted successfully.');
    }
}
