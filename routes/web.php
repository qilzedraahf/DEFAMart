<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

// Halaman utama DEFAMart
Route::get('/', [ShopController::class, 'index'])->name('shop.index');


 // Rute untuk menambah ke keranjang (sementara middleware auth dilepas agar tidak error login)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

// Rute untuk memperbarui jumlah barang di keranjang
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])
    ->name('cart.updateQuantity');


Route::prefix('admin')->name('admin.products.')->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');


Route::get('/order/{order}/payment', [OrderController::class, 'payment'])
    ->name('order.payment');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
