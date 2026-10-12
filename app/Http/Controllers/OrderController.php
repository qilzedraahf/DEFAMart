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
    // Menampilkan riwayat pesanan user
    public function index()
    {
        $orders = Order::with('items.product')->where('user_id', Auth::id())->latest()->get();
        return response()->json($orders); // Sementara testing pakai JSON
    }

    // Proses Checkout (Membuat Pesanan dari Keranjang)
    public function checkout(Request $request)
    {
        // 1. Validasi alamat pengiriman
        $request->validate([
            'shipping_address' => 'required|string',
        ]);

        $userId = Auth::id();

        // 2. Ambil keranjang user beserta item dan produknya
        $cart = Cart::with('items.product')->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja DEFAMart Anda masih kosong!');
        }

        // Menggunakan Database Transaction agar aman (jika ada error, semua dibatalkan)
        DB::beginTransaction();

        try {
            $totalPrice = 0;

            // Hitung total harga sekaligus cek ketersediaan stok
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk '{$item->product->name}' tidak mencukupi!");
                }
                $totalPrice += $item->product->price * $item->quantity;
            }

            // 3. Buat data pesanan utama di tabel 'orders'
            $order = Order::create([
                'user_id'          => $userId,
                'total_price'      => $totalPrice,
                'status'           => 'pending', // Status awal pesanan
                'shipping_address' => $request->shipping_address,
            ]);

            // 4. Pindahkan item keranjang ke 'order_items' dan kurangi stok produk
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price, // Simpan harga saat dibeli
                ]);

                // Kurangi stok produk
                $product = Product::find($item->product_id);
                $product->stock -= $item->quantity;
                $product->save();
            }

            // 5. Hapus isi keranjang karena sudah di-checkout
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Pesanan DEFAMart berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
