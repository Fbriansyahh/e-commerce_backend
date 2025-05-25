<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan semua item keranjang user.
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($cartItems);
    }


    /**
     * Simpan produk ke keranjang.
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_item' => $cartItem->load('product'), // pastikan relasi product diikutkan
        ], 200);
    }

    /**
     * Update jumlah produk di keranjang.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cartItem) {
            return response()->json([
                'message' => 'Item keranjang tidak ditemukan atau bukan milik user.'
            ], 404);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'message' => 'Jumlah produk diperbarui!',
            'cart_item' => $cartItem->load('product'),
        ], 200);
    }

    /**
     * Hapus item dari keranjang.
     */
    public function destroy($id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cartItem) {
            return response()->json([
                'message' => 'Item keranjang tidak ditemukan atau bukan milik user.'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'message' => 'Produk dihapus dari keranjang!'
        ], 200);
    }
}
