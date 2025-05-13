<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart; // Pastikan model Cart sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(9);

        return view('users.home', compact('products', 'search'));
    }

    public function addToCart(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Menambahkan produk ke keranjang (atau update jika sudah ada)
        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => \DB::raw('quantity + ' . $request->quantity)
            ]
        );

        return redirect()->route('home')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}
