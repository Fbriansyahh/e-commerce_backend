<?php

namespace App\Http\Controllers\Public;


use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    public function homepage()
    {
        return response()->json([
            'banners' => Banner::latest()->get(),
            'categories' => Category::all(),
            'recommended' => Product::where('is_recommended', true)->take(6)->get(),
            //'popular' => Product::orderBy('sold', 'desc')->take(6)->get(),
            'products' => Product::latest()->take(10)->get(),
        ]);
    }
}