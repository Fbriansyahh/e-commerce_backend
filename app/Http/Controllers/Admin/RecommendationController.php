<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        return Product::where('is_recommended', true)->get();
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $product->update(['is_recommended' => true]);
        return response()->json(['message' => 'Added to recommendations']);
    }

    public function destroy(Product $product)
    {
        $product->update(['is_recommended' => false]);
        return response()->json(['message' => 'Removed from recommendations']);
    }
}
