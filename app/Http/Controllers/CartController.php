<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan isi keranjang
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
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id() ?? 1;

        $cart = Cart::firstOrCreate([
            'user_id' => $userId,
        ]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }


if ($request->expectsJson()) {
    $cart->load('items.product');

    $total = $cart->items->sum(function ($item) {
        return (float) $item->product->price * $item->quantity;
    });

    $items = $cart->items->map(function ($item) {
        return [
            'id' => $item->id,
            'product_id' => $item->product_id,
            'name' => $item->product->name,
            'price' => (float) $item->product->price,
            'image' => $item->product->image,
            'quantity' => $item->quantity,
            'subtotal' => (float) $item->product->price * $item->quantity,
        ];
    })->values();

    return response()->json([
        'success' => true,
        'total' => $total,
        'cart_count' => $cart->items->sum('quantity'),
        'items' => $items,
    ]);
}

return redirect()->back()->with(
    'success',
    'Produk berhasil dimasukkan ke keranjang DEFAMart!'
);

    }

    // Menghapus item dari keranjang
    public function remove($id)
    {
        $userId = Auth::id() ?? 1;

        $cart = Cart::where('user_id', $userId)->firstOrFail();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->back()->with(
            'success',
            'Produk dihapus dari keranjang.'
        );
    }

    // Memperbarui jumlah atau menghapus barang dari keranjang
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|integer|exists:cart_items,id',
            'action' => 'nullable|string|in:increase,decrease,set,remove',
        ]);

        $userId = Auth::id() ?? 1;
        $cart = Cart::where('user_id', $userId)->firstOrFail();

        $cartItem = CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->where('id', $request->cart_item_id)
            ->firstOrFail();

        if ($request->input('action') === 'remove') {
            $cartItem->delete();
            $message = 'Barang berhasil dihapus dari keranjang.';
            $quantity = null;
            $subtotal = 0;
        } else {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            $message = 'Jumlah barang berhasil diperbarui.';
            $quantity = $cartItem->quantity;
            $subtotal = (float) $cartItem->product->price * $quantity;
        }

        $items = CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->get();

        $total = $items->sum(function ($item) {
            return (float) $item->product->price * $item->quantity;
        });

        $cartCount = $items->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => $message,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'total' => $total,
            'cart_count' => $cartCount,
        ]);
    }


}
