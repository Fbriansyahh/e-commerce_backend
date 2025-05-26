<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'type' => 'required|in:cart,buy_now',
            'product_id' => 'required_if:type,buy_now|exists:products,id',
            'quantity' => 'required_if:type,buy_now|integer|min:1'
        ]);

        $user = auth()->user();

        DB::beginTransaction();

        try {
            $items = [];
            $total = 0;

            if ($request->type === 'cart') {
                $carts = Cart::where('user_id', $user->id)->get();
                if ($carts->isEmpty()) return response()->json(['message' => 'Cart kosong'], 400);

                foreach ($carts as $cart) {
                    $items[] = [
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity,
                        'price' => $cart->product->price,
                    ];
                    $total += $cart->quantity * $cart->product->price;
                }

                // Hapus cart setelah checkout
                Cart::where('user_id', $user->id)->delete();

            } else {
                $product = Product::findOrFail($request->product_id);
                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price' => $product->price,
                ];
                $total = $product->price * $request->quantity;
            }

            // Simpan order
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'total_amount' => $total,
            ]);

            // Simpan item
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Checkout berhasil', 'order' => $order], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Checkout gagal', 'error' => $e->getMessage()], 500);
        }
    }
}
