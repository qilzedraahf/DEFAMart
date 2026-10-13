
<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEFAMart - Belanja Mudah & Cepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col justify-between">

@if (session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:15px;margin:15px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="background:#fee2e2;color:#991b1b;padding:15px;margin:15px;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div style="background:#fee2e2;color:#991b1b;padding:15px;margin:15px;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
    <div>
        <!-- Navbar Atas -->
        <!-- Ubah tag header dari yang lama menjadi seperti ini -->
        <header class="bg-[#134e32] text-white shadow-md py-3 px-6 md:px-16 flex items-center justify-between sticky top-0 z-30">
            <a href="{{ route('shop.index') }}" class="text-2xl font-bold tracking-wider">
                DEFA<span class="text-yellow-400">Mart</span>
            </a>

            <!-- Form Pencarian Real-Time (Tanpa Tombol Cari) -->
            <form id="searchForm" action="{{ route('shop.index') }}" method="GET" class="flex-1 max-w-lg mx-6 hidden md:block">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Cari produk kebutuhan harian..." 
                    class="w-full py-2 px-4 rounded-full text-gray-800 text-sm focus:outline-none shadow-inner" autocomplete="off">
            </form>

            <!-- Bagian Kanan Header: Keranjang & Profil -->
            <div class="flex items-center space-x-3">
                
                <!-- Tombol Keranjang -->
                <div>
                    <button type="button" onclick="toggleCart(event)" class="bg-[#0f3e28] hover:bg-[#0b2f1f] text-white px-4 py-2 rounded-full text-sm font-medium flex items-center space-x-2 border border-emerald-700 shadow transition">
                        <span>🛒 Keranjang</span>
                        <span class="bg-yellow-400 text-gray-900 font-bold px-2 py-0.5 rounded-full text-xs">
                            {{ isset($cartCount) ? $cartCount : 0 }}
                        </span>
                    </button>
                </div>

                <!-- IKON PROFIL & MENU DROPDOWN FLEKSIBEL -->
                <div class="relative">
                    <!-- Tombol Ikon / Foto Profil -->
                    <button type="button" onclick="toggleProfileMenu(event)" class="w-10 h-10 bg-[#0f3e28] hover:bg-[#0b2f1f] border border-emerald-700 text-white rounded-full flex items-center justify-center shadow transition cursor-pointer overflow-hidden" title="Menu Profil">
                        @auth
                            <!-- JIKA SUDAH LOGIN: Tampilkan gambar/avatar (bentuk kepala hingga dada atau foto user) -->
                            @if(isset(Auth::user()->avatar) && Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <!-- Fallback ikon siluet kepala hingga dada khas member -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        @else
                            <!-- JIKA BELUM LOGIN: Tampilkan ikon siluet default -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endauth
                    </button>

                    <!-- Kotak Dropdown Menu -->
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50">
                        @guest
                            <!-- KONDISI BELUM LOGIN -->
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-[11px] text-gray-400">Selamat datang di DEFAMart</p>
                            </div>
                            
                            <!-- Tombol Masuk -->
                            <a href="{{ route('login') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#134e32] transition">
                                <span class="mr-2">🔑</span> Masuk
                            </a>
                            
                            <!-- Tombol Daftar -->
                            <a href="{{ route('register') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold text-[#134e32] bg-emerald-50/50 hover:bg-emerald-50 transition">
                                <span class="mr-2">📝</span> Daftar Akun
                            </a>
                        @else
                            <!-- KONDISI SUDAH LOGIN -->
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#134e32] transition">
                                <span class="mr-2">⚙️</span> Pengaturan Profil
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition text-left cursor-pointer">
                                    <span class="mr-2">🚪</span> Keluar (Logout)
                                </button>
                            </form>
                        @endguest
                    </div>
                </div>

            </div>

            <!-- Panel Samping Keranjang Belanja (Nuansa Hijau) -->
            <div id="cartDrawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col justify-between">
                
                <div>
                    <div class="flex items-center justify-between p-5 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800">Keranjang Belanja Anda</h2>
                        <button onclick="toggleCart()" class="text-gray-400 hover:text-gray-600 text-xl font-bold px-2">&times;</button>
                    </div>

                    <div class="p-5 overflow-y-auto max-h-[calc(100vh-220px)] space-y-4">
                        @php
                            $userId = Auth::id() ?? 1;
                            $userCart = \App\Models\Cart::with('items.product')->where('user_id', $userId)->first();
                            $totalPrice = 0;
                        @endphp

                        @if(!$userCart || $userCart->items->isEmpty())
                            <div class="flex flex-col items-center justify-center py-20 text-gray-400 text-center">
                                <p class="text-sm">Keranjang Anda masih kosong.</p>
                            </div>
                        @else
                            @foreach($userCart->items as $item)
                                @php 
                                    $subtotal = $item->product->price * $item->quantity;
                                    $totalPrice += $subtotal;
                                @endphp
                                <div class="flex items-center justify-between border-b pb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-[10px] text-gray-400">No Image</span>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $item->product->name }}</h4>
                                           

<p class="text-xs text-gray-500 mb-2">
    Rp {{ number_format($item->product->price, 0, ',', '.') }} / item
</p>

<div class="flex items-center gap-2">
    <button type="button"
        onclick="updateCartQuantity({{ $item->id }}, 'decrease', this)"
        class="w-8 h-8 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
        −
    </button>

    <input type="number"
        min="1"
        value="{{ $item->quantity }}"
        data-cart-item-id="{{ $item->id }}"
        data-price="{{ $item->product->price }}"
        onchange="updateCartQuantity({{ $item->id }}, 'set', this)"
        class="cart-quantity w-14 h-8 text-center text-base font-bold text-gray-800 bg-white border border-gray-300 rounded-lg">

    <button type="button"
        onclick="updateCartQuantity({{ $item->id }}, 'increase', this)"
        class="w-8 h-8 rounded-lg bg-[#134e32] text-white hover:bg-[#0f3e28]">
        +
    </button>
</div>

<p class="cart-subtotal text-sm font-bold text-[#134e32] mt-2"
   data-cart-item-id="{{ $item->id }}">
    Rp {{ number_format($subtotal, 0, ',', '.') }}
</p>

                                        </div>
                                    </div>
                                  
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Bagian Bawah: Total Harga & Tombol Checkout Nuansa Hijau -->
                <div class="p-5 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-base font-semibold text-gray-700">Total Harga:</span>
                       
<span id="cartTotal" class="text-xl font-extrabold text-[#134e32]">Rp {{ number_format(isset($totalPrice) ? $totalPrice : 0, 0, ',', '.') }}</span>

                    </div>
                    
                    <form action="{{ route('order.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shipping_address" value="Alamat Default Uji Coba">
                        <!-- Tombol Pembayaran dengan Warna Hijau Utama DEFAMart -->
                        <button type="submit" class="w-full bg-[#134e32] hover:bg-[#0f3e28] text-white font-bold py-3 rounded-xl shadow transition text-center">
                            Lanjut ke Pembayaran
                        </button>
                    </form>
                </div>

            </div>
        </header>

        <!-- Konten Utama -->
        <main class="max-w-6xl mx-auto px-4 py-6">
            
            <!-- Banner Promo Slider ala Alfagift (7 Variasi Unik) -->
            <div class="mb-6 relative">
                
                <!-- Kontainer Geser (Horizontal Scroll) -->
                <div id="promoSlider" class="flex space-x-4 overflow-x-auto scroll-smooth pb-3 no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
                    
                    <!-- Banner 1: Voucher & Potongan Harga -->
                    <div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-red-600 via-red-500 to-amber-600 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Voucher Spesial</span>
                                <h2 class="text-2xl md:text-3xl font-extrabold mt-2 tracking-wide">POTONGAN HINGGA <span class="text-yellow-300">15K</span> MENANTI!</h2>
                            </div>
                        </div>
                        <!-- Bagian Bawah Banner 1 -->
                        <div class="flex justify-between items-end z-10 mt-4">
                            <span class="text-xs bg-black/20 px-3 py-1.5 rounded-lg font-medium">Voucher tersedia untuk member</span>
                            <a href="#" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold px-4 py-2 rounded-xl text-xs shadow transition">
                                KLIK DI SINI
                            </a>
                        </div>
                    </div>

                    <!-- Banner 2: Mega Sale Diskon 50% -->
                    <div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-purple-700 via-purple-600 to-indigo-700 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Mega Sale</span>
                                <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">LOWEST PRICE EVER!</h2>
                                <p class="text-lg font-bold text-yellow-300">Diskon Spesial hingga 50%</p>
                            </div>
                        </div>
                        <!-- Bagian Bawah Banner 2 -->
                        <div class="flex justify-between items-end z-10 mt-4">
                            <span class="text-xs bg-purple-900/40 px-3 py-1.5 rounded-lg font-medium text-purple-100">Periode 20–25 September</span>
                            <a href="#" class="bg-amber-300 hover:bg-amber-400 text-purple-950 font-bold px-4 py-2 rounded-xl text-xs shadow transition">
                                AMBIL PROMO
                            </a>
                        </div>
                    </div>

                    <!-- Banner 3: Gratis Ongkir Sepuasnya -->
                    <div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-emerald-700 via-teal-600 to-cyan-700 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Gratis Ongkir</span>
                                <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">BEBAS ONGKIR SEPUASNYA!</h2>
                                <p class="text-xs md:text-sm text-teal-100 mt-1">Belanja kebutuhan harian tanpa batas biaya kirim.</p>
                            </div>
                        </div>
                        <!-- Bagian Bawah Banner 3 -->
                        <div class="flex justify-between items-end z-10 mt-4">
                            <span class="text-xs bg-teal-900/40 px-3 py-1.5 rounded-lg font-medium text-teal-100">Tanpa Minimum Belanja</span>
                            <a href="#" class="bg-emerald-300 hover:bg-emerald-400 text-teal-950 font-bold px-4 py-2 rounded-xl text-xs shadow transition">
                                CEK VOUCHER
                            </a>
                        </div>
                    </div>

                    <!-- Banner 4: Flash Sale Kilat -->
                    <div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-orange-600 via-amber-600 to-yellow-600 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">⚡ Flash Sale</span>
                                <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">DISKON KILAT HARI INI</h2>
                                <p class="text-xs md:text-sm text-orange-100 mt-1">Sikat produk pilihan sebelum kehabisan!</p>
                            </div>
                        </div>
                        <!-- Bagian Bawah Banner 4 -->
                        <div class="flex justify-between items-end z-10 mt-4">
                            <span class="text-xs bg-orange-950/40 px-3 py-1.5 rounded-lg font-medium text-orange-100">Berakhir Pukul 23:59</span>
                            <a href="#" class="bg-white hover:bg-orange-50 text-orange-700 font-bold px-4 py-2 rounded-xl text-xs shadow transition">
                                BELI SEKARANG
                            </a>
                        </div>
                    </div>

                    <!-- Banner 5: Cashback Spesial Member -->
                    <div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-blue-700 via-indigo-600 to-violet-700 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">A-Point & Cashback</span>
                                <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">CASHBACK HINGGA 30%</h2>
                                <p class="text-xs md:text-sm text-blue-100 mt-1">Kumpulkan poin ekstra dari setiap transaksi harianmu.</p>
                            </div>
                        </div>
                        <!-- Bagian Bawah Banner 5 -->
                        <div class="flex justify-between items-end z-10 mt-4">
                            <span class="text-xs bg-blue-950/40 px-3 py-1.5 rounded-lg font-medium text-blue-100">Khusus Member DEFAMart</span>
                            <a href="#" class="bg-cyan-300 hover:bg-cyan-400 text-blue-950 font-bold px-4 py-2 rounded-xl text-xs shadow transition">
                                KUMPULKAN POIN
                            </a>
                        </div>
                    </div>

                    <!-- Banner 6: Kebutuhan Rumah Tangga Murah -->
                    <div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-pink-700 via-rose-600 to-red-700 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Rumah Tangga</span>
                                <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">GROSIR SEMBAKO HEMAT</h2>
                                <p class="text-xs md:text-sm text-pink-100 mt-1">Belanja kebutuhan bulanan jadi makin hemat dan praktis.</p>
                            </div>
                        </div>
                        <!-- Bagian Bawah Banner 6 -->
                        <div class="flex justify-between items-end z-10 mt-4">
                            <span class="text-xs bg-rose-950/40 px-3 py-1.5 rounded-lg font-medium text-rose-100">100% Dijamin Original</span>
                            <a href="#" class="bg-yellow-300 hover:bg-yellow-400 text-rose-950 font-bold px-4 py-2 rounded-xl text-xs shadow transition">
                                LIHAT KATALOG
                            </a>
                        </div>
                    </div>

                    <!-- Banner 7: Produk Perawatan & Kecantikan -->
                    <div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-teal-800 via-emerald-700 to-green-800 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <span class="bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Beauty & Care</span>
                                <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">GLOW UP SETIAP HARI</h2>
                                <p class="text-xs md:text-sm text-emerald-100 mt-1">Temukan produk perawatan tubuh terbaik impianmu.</p>
                            </div>
                        </div>
                        <!-- Bagian Bawah Banner 7 -->
                        <div class="flex justify-between items-end z-10 mt-4">
                            <span class="text-xs bg-emerald-950/40 px-3 py-1.5 rounded-lg font-medium text-emerald-100">Diskon Brand Pilihan</span>
                            <a href="#" class="bg-lime-300 hover:bg-lime-400 text-emerald-950 font-bold px-4 py-2 rounded-xl text-xs shadow transition">
                                JELAJAHI SEKARANG
                            </a>
                        </div>
                    </div>

                </div>

                
                <!-- Navigasi Slider & Indikator (Diatur Sejajar Rata Kiri-Kanan) -->
                <div class="flex items-center justify-between mt-4 px-2 w-full">
                    
                    <!-- Tombol Geser Kiri (Sebelumnya) di sebelah kiri -->
                    <button onclick="scrollSlider(-400)" class="text-xs font-semibold text-gray-500 hover:text-[#134e32] transition flex items-center space-x-1">
                        <span>&lt; Lihat Promo Sebelumnya</span>
                    </button>

                    <!-- Indikator Titik (Dots) di Tengah -->
                    <div class="flex items-center space-x-1.5">
                        <span class="dot w-3 h-3 bg-red-600 rounded-full transition-all duration-300" data-index="0"></span>
                        <span class="dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300" data-index="1"></span>
                        <span class="dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300" data-index="2"></span>
                        <span class="dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300" data-index="3"></span>
                        <span class="dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300" data-index="4"></span>
                        <span class="dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300" data-index="5"></span>
                        <span class="dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300" data-index="6"></span>
                    </div>

                    <!-- Tombol Geser Kanan (Selanjutnya) di sebelah kanan -->
                    <button onclick="scrollSlider(400)" class="text-xs font-semibold text-gray-500 hover:text-[#134e32] transition flex items-center space-x-1">
                        <span>Lihat Promo Selanjutnya &gt;</span>
                    </button>

                </div>
            </div>

        <!-- BAGIAN KATEGORI PILIHAN -->
            <section class="max-w-7xl mx-auto px-4 my-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center space-x-2">
                        <span class="w-1.5 h-5 bg-[#134e32] rounded-full inline-block"></span>
                        <span>Kategori Pilihan</span>
                    </h3>
                </div>

                <!-- Grid Kategori Utama (Total 7 Kolom: 1 Menu Semua Produk + 6 Kategori) -->
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-4">
                    
                    <!-- 1. Tombol Manual: Semua Produk (Tanpa ID / Mengarah ke semua produk) -->
                <a href="{{ route('shop.index') }}" class="bg-white hover:shadow-md border border-gray-100 rounded-2xl p-4 flex flex-col items-center text-center transition group">
                    <div class="w-14 h-14 bg-emerald-50 text-[#134e32] rounded-2xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition duration-300">
                        📦
                    </div>
                    <h4 class="text-xs font-bold text-gray-800 group-hover:text-[#134e32] transition">Semua Produk</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Tampilkan Semua</p>
                </a>

                <!-- 2. Kategori 1 (Sembako & Dapur) - Mengambil data berdasarkan index ke-0 atau slug spesifik -->
                @if(isset($categories[0]))
                <a href="{{ route('shop.index', ['category' => $categories[0]->slug]) }}" class="bg-white hover:shadow-md border border-gray-100 rounded-2xl p-4 flex flex-col items-center text-center transition group">
                    <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition duration-300">
                        🍚
                    </div>
                    <h4 class="text-xs font-bold text-gray-800 group-hover:text-red-600 transition">{{ $categories[0]->name }}</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Beras, Minyak, Gula</p>
                </a>
                @endif

                <!-- 3. Kategori 2 (Susu, Bayi & Anak) -->
                @if(isset($categories[1]))
                <a href="{{ route('shop.index', ['category' => $categories[1]->slug]) }}" class="bg-white hover:shadow-md border border-gray-100 rounded-2xl p-4 flex flex-col items-center text-center transition group">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition duration-300">
                        🍼
                    </div>
                    <h4 class="text-xs font-bold text-gray-800 group-hover:text-blue-600 transition">{{ $categories[1]->name }}</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Susu, Popok, Perlengkapan</p>
                </a>
                @endif

                <!-- 4. Kategori 3 (Makanan Ringan & Minuman) -->
                @if(isset($categories[2]))
                <a href="{{ route('shop.index', ['category' => $categories[2]->slug]) }}" class="bg-white hover:shadow-md border border-gray-100 rounded-2xl p-4 flex flex-col items-center text-center transition group">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition duration-300">
                        🍿
                    </div>
                    <h4 class="text-xs font-bold text-gray-800 group-hover:text-amber-600 transition">{{ $categories[2]->name }}</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Snack, Biskuit, Kopi</p>
                </a>
                @endif

                <!-- 5. Kategori 4 (Perawatan Tubuh & Kecantikan) -->
                @if(isset($categories[3]))
                <a href="{{ route('shop.index', ['category' => $categories[3]->slug]) }}" class="bg-white hover:shadow-md border border-gray-100 rounded-2xl p-4 flex flex-col items-center text-center transition group">
                    <div class="w-14 h-14 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition duration-300">
                        🧴
                    </div>
                    <h4 class="text-xs font-bold text-gray-800 group-hover:text-pink-600 transition">{{ $categories[3]->name }}</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Sabun, Shampoo, Skincare</p>
                </a>
                @endif

                <!-- 6. Kategori 5 (Kebersihan Rumah Tangga) -->
                @if(isset($categories[4]))
                <a href="{{ route('shop.index', ['category' => $categories[4]->slug]) }}" class="bg-white hover:shadow-md border border-gray-100 rounded-2xl p-4 flex flex-col items-center text-center transition group">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition duration-300">
                        🧹
                    </div>
                    <h4 class="text-xs font-bold text-gray-800 group-hover:text-emerald-600 transition">{{ $categories[4]->name }}</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Deterjen, Pembersih, Tisu</p>
                </a>
                @endif

                <!-- 7. Kategori 6 (Produk Segar & Beku) -->
                @if(isset($categories[5]))
                <a href="{{ route('shop.index', ['category' => $categories[5]->slug]) }}" class="bg-white hover:shadow-md border border-gray-100 rounded-2xl p-4 flex flex-col items-center text-center transition group">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition duration-300">
                        🥩
                    </div>
                    <h4 class="text-xs font-bold text-gray-800 group-hover:text-purple-600 transition">{{ $categories[5]->name }}</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Buah, Sayur, Frozen Food</p>
                </a>
                @endif

                </div>
            </section>

            <!-- Daftar Katalog Produk -->
            <section class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 min-h-[300px]">
                <div class="flex items-center space-x-2 border-b pb-4 mb-6">
                    <div class="w-1 h-5 bg-[#134e32] rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-800">Produk</h2>
                </div>

                @if($products->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                        <p class="text-sm">Produk tidak ditemukan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($products as $product)
                            <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between hover:shadow-md transition">
                                <div>
                                    <!-- Kotak Gambar Produk Disesuaikan ke Rasio 4:3 (800x600 px) -->
                                    <div class="w-full aspect-[4/3] bg-gray-100 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
                                        @if($product->image)
                                            <!-- Jika produk punya gambar di database -->
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <!-- Jika produk kosong/tidak ada gambar -->
                                            <span class="text-xs text-gray-400">Tidak ada gambar</span>
                                        @endif
                                    </div>

                                    <span class="text-xs text-emerald-600 font-semibold">{{ $product->category->name ?? 'Kategori' }}</span>
                                    <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">{{ $product->name }}</h3>
                                    <p class="text-emerald-700 font-extrabold text-base mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                                
                                <!-- Tombol Tambah ke Keranjang -->
                                <form class="add-to-cart-form" action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-[#134e32] hover:bg-[#0f3e28] text-white py-2 rounded-lg text-xs font-semibold shadow transition">
                                        + Keranjang
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

        </main>
    </div>

    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500 mt-12">
        &copy; 2026 DEFAMart - Proyek Pemrograman Web III
    </footer>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        
        let typingTimer;
        const doneTypingInterval = 300; // Jeda 300ms agar pencarian berjalan mulus saat diketik

        searchInput.addEventListener('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                searchForm.submit();
            }, doneTypingInterval);
        });
    </script>

    <!-- Overlay di Belakang Panel -->
<div id="cartOverlay" class="fixed inset-0 z-40 hidden transition-opacity" onclick="toggleCart()"></div>

    <!-- Panel Samping Keranjang Belanja -->
    <div id="cartDrawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col justify-between">
        
        <!-- Bagian Atas: Header Keranjang -->
        <div>
            <div class="flex items-center justify-between p-5 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800">Keranjang Belanja Anda</h2>
                <button onclick="toggleCart()" class="text-gray-400 hover:text-gray-600 text-xl font-bold px-2">&times;</button>
            </div>

            <!-- Daftar Item di Keranjang -->
            <div class="p-5 overflow-y-auto max-h-[calc(100vh-220px)] space-y-4">
                @php
                    $userId = Auth::id() ?? 1;
                    $userCart = \App\Models\Cart::with('items.product')->where('user_id', $userId)->first();
                    $totalPrice = 0;
                @endphp

                @if(!$userCart || $userCart->items->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-gray-400 text-center">
                        <p class="text-sm">Keranjang Anda masih kosong.</p>
                    </div>
                @else
                    @foreach($userCart->items as $item)
                        @php 
                            $subtotal = $item->product->price * $item->quantity;
                            $totalPrice += $subtotal;
                        @endphp
                        <div class="flex items-center justify-between border-b pb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-[10px] text-gray-400">No Image</span>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $item->product->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-red-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Bagian Bawah: Total Harga & Tombol Checkout -->
        <div class="p-5 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between mb-4">
                <span class="text-base font-semibold text-gray-700">Total Harga:</span>
                <span class="text-xl font-extrabold text-red-600">Rp {{ number_format(isset($totalPrice) ? $totalPrice : 0, 0, ',', '.') }}</span>
            </div>
            
        php
@if (session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:15px;margin:10px;border-radius:8px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="background:#fee2e2;color:#991b1b;padding:15px;margin:10px;border-radius:8px;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div style="background:#fee2e2;color:#991b1b;padding:15px;margin:10px;border-radius:8px;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

            <form action="{{ route('order.checkout') }}" method="POST">
    @csrf
    <input type="hidden" name="shipping_address" value="Alamat pengiriman untuk testing">

    <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-4 rounded-xl">
        Lanjut ke Pembayaran
    </button>
</form>
        </div>

    </div>

    <!-- Skrip JavaScript untuk Buka/Tutup Panel Samping -->
    <script>
    function toggleCart(event) {
    if (event) event.preventDefault();

    const drawer = document.getElementById('cartDrawer');
    const overlay = document.getElementById('cartOverlay');

    if (!drawer || !overlay) return;

    const tertutup = drawer.classList.contains('translate-x-full');

    drawer.classList.toggle('translate-x-full', !tertutup);
    overlay.classList.toggle('hidden', tertutup);
}

    </script>

    <script>
    // Menangkap semua form tambah ke keranjang
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah halaman refresh bawaan form

            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                // Langsung muat ulang halaman dengan mulus setelah produk masuk database
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                // Fallback jika terjadi kendala, lakukan submit standar
                this.submit();
            });
        });
    });
    </script>

    <script>
        // Fungsi untuk membuka/menutup kotak dropdown profil
        function toggleProfileMenu(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Menutup dropdown secara otomatis jika pengguna mengklik area lain di luar kotak
        window.addEventListener('click', function() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    <!-- Skrip JavaScript Pendukung Dropdown -->
    <script>
        function toggleProfileMenu(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    <script>
        function scrollSlider(direction) {
            const slider = document.getElementById('promoSlider');
            slider.scrollBy({ left: direction, behavior: 'smooth' });
        }

        // Memantau posisi scroll untuk mengubah indikator titik secara otomatis
        const slider = document.getElementById('promoSlider');
        const dots = document.querySelectorAll('.dot');

        if (slider) {
            slider.addEventListener('scroll', function() {
                // Menghitung indeks banner yang sedang aktif berdasarkan posisi scroll
                let index = Math.round(slider.scrollLeft / (slider.offsetWidth / 2));
                
                // Batasi indeks agar sesuai dengan jumlah banner (0 sampai 6)
                if (index > 6) index = 6;
                if (index < 0) index = 0;

                // Perbarui tampilan setiap titik
                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.remove('w-2', 'h-2', 'bg-gray-300');
                        dot.classList.add('w-3', 'h-3', 'bg-red-600');
                    } else {
                        dot.classList.remove('w-3', 'h-3', 'bg-red-600');
                        dot.classList.add('w-2', 'h-2', 'bg-gray-300');
                    }
                });
            });
        }
    </script>


<script>
let pendingRemoveCartItemId = null;

function showRemoveCartModal(itemId) {
    pendingRemoveCartItemId = itemId;

    const modal = document.getElementById('removeCartModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeRemoveCartModal() {
    const modal = document.getElementById('removeCartModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');

    pendingRemoveCartItemId = null;
}

async function confirmRemoveCartItem() {
    if (!pendingRemoveCartItemId) return;

    const itemId = pendingRemoveCartItemId;
    const modal = document.getElementById('removeCartModal');
    const confirmButton = modal.querySelector(
        'button[onclick="confirmRemoveCartItem()"]'
    );

    confirmButton.disabled = true;
    confirmButton.textContent = 'Menghapus...';

    const formData = new FormData();
    formData.append('cart_item_id', itemId);
    formData.append('action', 'remove');
    formData.append(
        '_token',
        document.querySelector('meta[name="csrf-token"]')?.content || ''
    );

    try {
        const response = await fetch(
            "{{ route('cart.updateQuantity') }}",
            {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal menghapus barang.');
        }

        const input = document.querySelector(
            `.cart-quantity[data-cart-item-id="${itemId}"]`
        );

        if (input) {
            const itemElement = input.closest(
                '.flex.items-center.justify-between.border-b'
            );

            if (itemElement) {
                itemElement.remove();
            }
        }

        const total = document.getElementById('cartTotal');

        if (total) {
            total.textContent = 'Rp ' +
                Number(data.total).toLocaleString('id-ID');
        }

        closeRemoveCartModal();

    } catch (error) {
        alert('Gagal menghapus barang: ' + error.message);
        console.error(error);
    } finally {
        confirmButton.disabled = false;
        confirmButton.textContent = 'Ya, Hapus';
    }
}

async function updateCartQuantity(itemId, action, element) {
    const input = document.querySelector(
        `.cart-quantity[data-cart-item-id="${itemId}"]`
    );

    if (!input) return;

    const oldQuantity = parseInt(input.value) || 1;
    let newQuantity = oldQuantity;

    if (action === 'increase') {
        newQuantity++;
    } else if (action === 'decrease') {
        newQuantity--;
    } else if (action === 'set') {
        newQuantity = parseInt(input.value);
    }

    if (!Number.isInteger(newQuantity) || newQuantity < 1) {
        input.value = oldQuantity;

        if (action === 'decrease' && oldQuantity === 1) {
            showRemoveCartModal(itemId);
        }

        return;
    }

    const buttons = input.parentElement.querySelectorAll('button');
    buttons.forEach(button => button.disabled = true);
    input.disabled = true;

    const formData = new FormData();
    formData.append('cart_item_id', itemId);
    formData.append('quantity', newQuantity);
    formData.append('action', action);
    formData.append(
        '_token',
        document.querySelector('meta[name="csrf-token"]')?.content || ''
    );

    try {
        const response = await fetch(
            "{{ route('cart.updateQuantity') }}",
            {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal memperbarui keranjang.');
        }

        input.value = data.quantity;

        const subtotal = document.querySelector(
            `.cart-subtotal[data-cart-item-id="${itemId}"]`
        );

        if (subtotal) {
            subtotal.textContent = 'Rp ' +
                Number(data.subtotal).toLocaleString('id-ID');
        }

        const total = document.getElementById('cartTotal');

        if (total) {
            total.textContent = 'Rp ' +
                Number(data.total).toLocaleString('id-ID');
        }

    } catch (error) {
        input.value = oldQuantity;
        alert('Gagal memperbarui keranjang: ' + error.message);
        console.error(error);
    } finally {
        buttons.forEach(button => button.disabled = false);
        input.disabled = false;
    }
}
</script>


<!-- Popup Konfirmasi Hapus Barang -->
<div id="removeCartModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-2xl">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-2xl text-red-600">
            !
        </div>

        <h3 class="mb-2 text-lg font-bold text-gray-800">
            Hapus Barang?
        </h3>

        <p class="mb-6 text-sm text-gray-500">
            Kamu yakin ingin menghapus barang ini dari keranjang?
        </p>

        <div class="flex gap-3">
            <button type="button"
                onclick="closeRemoveCartModal()"
                class="flex-1 rounded-xl border border-gray-300 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                Batal
            </button>

            <button type="button"
                onclick="confirmRemoveCartItem()"
                class="flex-1 rounded-xl bg-red-600 px-4 py-3 font-semibold text-white hover:bg-red-700">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

</body>
</html>