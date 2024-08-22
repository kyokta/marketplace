<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('seller.dashboard');
    }
    public function getProduct()
    {
        return view('seller.product');
    }
}