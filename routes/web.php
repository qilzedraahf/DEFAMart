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



/*
|--------------------------------------------------------------------------
| Halaman Syarat dan Ketentuan Voucher
|--------------------------------------------------------------------------
*/

Route::get('/voucher/{voucher}', function ($voucher) {

    $vouchers = [
        'voucher-spesial' => [
            'title' => 'Voucher Spesial',
            'discount' => 'Potongan hingga Rp15.000',
            'description' => 'Dapatkan potongan harga untuk belanja kebutuhan harian.',
            'minimum' => 'Minimum belanja Rp100.000',
            'period' => 'Sesuai periode promo yang berlaku.',
        ],

        'mega-sale' => [
            'title' => 'Mega Sale',
            'discount' => 'Diskon spesial hingga 50%',
            'description' => 'Nikmati diskon spesial untuk produk pilihan DEFAMart.',
            'minimum' => 'Minimum belanja mengikuti ketentuan promo.',
            'period' => '20–25 September.',
        ],

        'gratis-ongkir' => [
            'title' => 'Gratis Ongkir Sepuasnya',
            'discount' => 'Gratis biaya pengiriman',
            'description' => 'Belanja kebutuhan harian tanpa batas biaya kirim.',
            'minimum' => 'Tanpa minimum belanja.',
            'period' => 'Sesuai periode promo yang berlaku.',
        ],

        'flash-sale' => [
            'title' => 'Flash Sale Kilat',
            'discount' => 'Diskon kilat produk pilihan',
            'description' => 'Sikat produk pilihan sebelum kehabisan.',
            'minimum' => 'Mengikuti ketentuan masing-masing produk.',
            'period' => 'Promo berakhir pukul 23:59.',
        ],

        'cashback-member' => [
            'title' => 'Cashback Spesial Member',
            'discount' => 'Cashback hingga 30%',
            'description' => 'Kumpulkan poin ekstra dari setiap transaksi harian.',
            'minimum' => 'Khusus member DEFAMart.',
            'period' => 'Sesuai periode promo yang berlaku.',
        ],

        'rumah-tangga' => [
            'title' => 'Kebutuhan Rumah Tangga Murah',
            'discount' => 'Promo kebutuhan rumah tangga',
            'description' => 'Belanja kebutuhan bulanan dengan lebih hemat dan praktis.',
            'minimum' => 'Mengikuti ketentuan produk yang dipilih.',
            'period' => 'Sesuai periode promo yang berlaku.',
        ],

        'beauty-care' => [
            'title' => 'Produk Perawatan dan Kecantikan',
            'discount' => 'Diskon brand pilihan',
            'description' => 'Temukan produk perawatan tubuh dan kecantikan pilihan.',
            'minimum' => 'Mengikuti ketentuan produk yang dipilih.',
            'period' => 'Sesuai periode promo yang berlaku.',
        ],
    ];

    abort_unless(isset($vouchers[$voucher]), 404);

    return view('vouchers.show', [
        'voucher' => $vouchers[$voucher],
        'voucherCode' => $voucher,
        'claimed' => session()->has('claimed_vouchers.' . $voucher),
    ]);

})->name('vouchers.show');


/*
|--------------------------------------------------------------------------
| Klaim Voucher
|--------------------------------------------------------------------------
*/

Route::post('/vouchers/{voucher}/claim', function ($voucher) {

    $vouchers = [
        'voucher-spesial',
        'mega-sale',
        'gratis-ongkir',
        'flash-sale',
        'cashback-member',
        'rumah-tangga',
        'beauty-care',
    ];

    abort_unless(in_array($voucher, $vouchers, true), 404);

    $claimed = session('claimed_vouchers', []);

    // Pastikan status klaim disimpan berdasarkan kode voucher.
    if (!is_array($claimed)) {
        $claimed = [];
    }

    if (!empty($claimed[$voucher]) || in_array($voucher, $claimed, true)) {
        return redirect()
            ->route('shop.index')
            ->with('info', 'Voucher ini sudah diklaim.');
    }

    $claimed[$voucher] = true;

    session(['claimed_vouchers' => $claimed]);

    return redirect()
        ->route('shop.index')
        ->with('success', 'Voucher berhasil diklaim!');

})->name('vouchers.claim');
