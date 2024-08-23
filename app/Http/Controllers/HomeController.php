<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
    
        if ($query) {
            $products = Product::with(['category', 'seller'])
                ->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();
        } else {
            $products = Product::with(['category', 'seller'])->get();
        }
        
        return view('user.home', compact('products'));
    }
    

    public function detail($id)
    {
        $product = [
            'id' => $id,
            'name' => 'Product ' . $id,
            'price' => '$' . (10 + ($id - 1) * 5) . '.00',
            'image' => 'https://via.placeholder.com/600',
            'description' => 'This is a detailed description of Product ' . $id . '. It provides more information about the product features and specifications.',
            'stock' => rand(1, 100) 
        ];

        return view('user.detail', compact('product'));
    }
}