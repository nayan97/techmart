<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){

        $products = Product::where('is_featured', 'Yes')
        ->orderBy('id', 'DESC')
        ->where('status', 1)
        ->take(8)->get();

        $latestProducts = Product::orderBy('id', 'DESC')
        ->where('status', 1)
        ->take(16)->get();

        $data['featuredProducts'] = $products;
        $data['latestProducts'] = $latestProducts;

        return view('front.home', $data);
    }
}
