<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return view('seller.dashboard');
    }

    public function getProduct()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('seller.product', compact('products', 'categories'));
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

        $product = Product::create([
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
        $product = Product::find($id);

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

        if ($request->hasFile('productImage')) {
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