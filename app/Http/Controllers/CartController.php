<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan isi keranjang belanja user yang sedang login
    public function index()
    {
        // Mengambil keranjang milik user (atau user ID 1 untuk testing)
        $userId = Auth::id() ?? 1;
        $cart = Cart::with('items.product')->where('user_id', $userId)->first();

        return view('cart', compact('cart'));
    }

    // Menambahkan produk ke keranjang
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $userId = Auth::id() ?? 1; // Mendapatkan ID user yang sedang login

        // 1. Cek apakah user sudah punya keranjang, jika belum buat baru
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        // 2. Cek apakah produk yang sama sudah ada di dalam keranjang
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan jumlahnya (quantity)
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Jika belum ada, buat item keranjang baru
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil dimasukkan ke keranjang DEFAMart!');
    }

    // Menghapus item dari keranjang
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
