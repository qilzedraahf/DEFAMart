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
        $userId = Auth::id() ?? 1;

        $cart = Cart::with('items.product')
            ->where('user_id', $userId)
            ->first();

        return view('cart', compact('cart'));
    }

    // Menambahkan produk ke keranjang
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $userId = Auth::id() ?? 1;

        // Membuat keranjang jika belum tersedia
        $cart = Cart::firstOrCreate([
            'user_id' => $userId,
        ]);

        // Memeriksa apakah produk sudah ada di keranjang
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Produk berhasil dimasukkan ke keranjang DEFAMart!'
        );
    }

    // Mengubah jumlah atau menghapus produk dari keranjang
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|integer|exists:cart_items,id',
            'action'       => 'required|in:increase,decrease,set,remove',
            'quantity'     => 'nullable|integer|min:1',
        ]);

        $userId = Auth::id() ?? 1;

        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('product')
            ->firstOrFail();

        $cartId = $cartItem->cart_id;

        // Menghapus produk dari keranjang
        if ($request->action === 'remove') {
            $cartItem->delete();

            $cart = Cart::with('items.product')->find($cartId);

            $total = $cart
                ? $cart->items->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                })
                : 0;

            return response()->json([
                'removed' => true,
                'cart_item_id' => $request->cart_item_id,
                'total' => $total,
            ]);
        }

        // Menambah jumlah produk
        if ($request->action === 'increase') {
            $cartItem->quantity++;
        } elseif ($request->action === 'decrease') {
            // Jumlah tidak boleh kurang dari 1
            if ($cartItem->quantity <= 1) {
                return response()->json([
                    'message' => 'Jumlah minimal adalah 1.',
                ], 422);
            }

            $cartItem->quantity--;
        } else {
            $cartItem->quantity = $request->quantity;
        }

        $cartItem->save();

        $cart = Cart::with('items.product')->findOrFail($cartId);

        $subtotal = $cartItem->product->price * $cartItem->quantity;

        $total = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'quantity' => $cartItem->quantity,
            'subtotal' => $subtotal,
            'total'    => $total,
        ]);
    }

    // Menghapus item dari keranjang melalui form biasa
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with(
            'success',
            'Produk dihapus dari keranjang.'
        );
    }
}
