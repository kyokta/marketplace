<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrder()
    {
        return view('seller.order');
    }
}