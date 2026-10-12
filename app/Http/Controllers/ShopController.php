<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');

        // Jika tombol kategori diklik (mengirimkan slug), filter produk berdasarkan slug tersebut
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        // Jika tombol "Semua Produk" diklik, parameter 'category' tidak ada/kosong, 
        // sehingga blok if di atas dilewati dan SEMUA produk otomatis ditampilkan.

        // Filter pencarian nama produk (jika ada)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();

        // Hitung jumlah jenis produk unik di keranjang
        $userId = Auth::id() ?? 1;
        $cartCount = 0;
        $cart = Cart::with('items')->where('user_id', $userId)->first();
        if ($cart) {
            $cartCount = $cart->items->count(); 
        }

        return view('shop', compact('categories', 'products', 'cartCount'));
    }
}