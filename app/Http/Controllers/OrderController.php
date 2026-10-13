<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
        ]);

        $userId = Auth::id() ?? 1;

        $cart = Cart::with('items.product')
            ->where('user_id', $userId)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
    return redirect('/')
        ->with('error', 'Keranjang kosong untuk user ID: ' . $userId);
}

        try {
            DB::beginTransaction();

            $totalPrice = 0;

            foreach ($cart->items as $item) {
                if (!$item->product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                if ($item->quantity > $item->product->stock) {
                    throw new \Exception(
                        'Stok produk tidak mencukupi.'
                    );
                }

                $totalPrice +=
                    $item->product->price * $item->quantity;
            }

            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $product = Product::findOrFail($item->product_id);
                $product->stock -= $item->quantity;
                $product->save();
            }

            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route(
                'order.payment',
                $order->id
            );

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect('/')
                ->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function payment(Order $order)
    {
        $order->load('items.product');

        return view('orders.payment', compact('order'));
    }
}