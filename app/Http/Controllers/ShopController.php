<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.shop', compact('products'));
    }
}
