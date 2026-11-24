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
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'required|integer|distinct',
        ]);

        $userId = Auth::id() ?? 1;

        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return redirect('/')
                ->with('error', 'Keranjang kosong.');
        }

        try {
            DB::beginTransaction();

            $selectedIds = $request->input('selected_items');

            $selectedItems = $cart->items()
                ->with('product')
                ->whereIn('id', $selectedIds)
                ->lockForUpdate()
                ->get();

            if ($selectedItems->isEmpty() ||
                $selectedItems->count() !== count($selectedIds)) {
                throw new \Exception('Pilihan barang tidak valid.');
            }

            $totalPrice = 0;

            foreach ($selectedItems as $item) {
                if (!$item->product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                if ($item->quantity > $item->product->stock) {
                    throw new \Exception(
                        'Stok produk ' . $item->product->name . ' tidak mencukupi.'
                    );
                }

                $totalPrice += $item->product->price * $item->quantity;
            }

            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($selectedItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $product->stock -= $item->quantity;
                $product->save();

                $item->delete();
            }

            DB::commit();

            return redirect()->route('order.payment', $order->id);

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