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
    // Checkout
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

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'total_amount' => $total,
                'status' => 'Menunggu Pembayaran'
            ]);

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

    // List Semua Order Customer (dengan filter status dan tanggal)
    public function index(Request $request)
    {
        $user = auth()->user();
        $status = $request->query('status');
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        $query = Order::with(['orderItems.product'])->where('user_id', $user->id);

        if ($status) {
            $query->where('status', $status);
        }

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        $orders = $query->orderByDesc('created_at')->get();

        return response()->json([
            'message' => 'Daftar pesanan ditemukan',
            'data' => $orders
        ]);
    }

    // Detail Order
    public function show($id)
    {
        $user = auth()->user();

        $order = Order::with(['orderItems.product'])
                      ->where('user_id', $user->id)
                      ->findOrFail($id);

        return response()->json([
            'message' => 'Detail pesanan ditemukan',
            'data' => $order
        ]);
    }

    // Update Status Pesanan (contoh: dikirim, selesai, dibatalkan)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Pembayaran,Diproses,Dikirim,Selesai,Dibatalkan'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Status pesanan diperbarui',
            'data' => $order
        ]);
    }

    // Cancel Order oleh customer
    public function cancel($id)
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)
                      ->where('status', 'Menunggu Pembayaran') // hanya bisa cancel jika belum diproses
                      ->findOrFail($id);

        $order->status = 'Dibatalkan';
        $order->save();

        return response()->json([
            'message' => 'Pesanan berhasil dibatalkan',
            'data' => $order
        ]);
    }
}
