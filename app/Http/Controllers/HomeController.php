<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(4)->get();
        $discountedProducts = Product::where(function ($query) {
            $query->whereNotNull('sale_price')
                  ->orWhereNotNull('discount_percent');
        })->latest()->take(4)->get();
        return view('client.home', compact('featuredProducts', 'discountedProducts'));
    }
}