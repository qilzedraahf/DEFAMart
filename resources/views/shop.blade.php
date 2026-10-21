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
                       
<span id="cartCount" class="bg-yellow-400 text-gray-900 font-bold px-2 py-0.5 rounded-full text-xs">
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

         

        </header>

        <!-- Konten Utama -->
        <main class="max-w-6xl mx-auto px-4 py-6">
            
            <!-- Banner Promo Slider ala Alfagift (7 Variasi Unik) -->
            <div class="mb-6 relative">
                
                <!-- Kontainer Geser (Horizontal Scroll) -->
                <div id="promoSlider" class="flex space-x-4 overflow-x-auto scroll-smooth pb-3 no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
                    
                <!-- PEMBUNGKUS UTAMA PROMO -->
<section class="w-full flex flex-col">

    <!-- AREA SLIDER -->
    <div class="w-full overflow-hidden">

        <div id="promoSlider"
             class="flex gap-4 overflow-x-auto scroll-smooth scrollbar-hide w-full">

            <!-- Banner 1 sampai Banner 7 -->
             
            
<!-- Banner 1: Voucher & Potongan Harga -->
<div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-red-600 via-red-500 to-amber-600 text-white rounded-2xl p-6 shadow-md flex flex-col justify-between min-h-[270px]">

    <div class="relative z-10">
        <span class="inline-block bg-white/20 text-xs px-3 py-1.5 rounded-full font-semibold">
            Voucher Spesial
        </span>

        <h2 class="text-2xl md:text-3xl font-extrabold mt-3 tracking-wide">
            POTONGAN HINGGA
            <span class="text-yellow-300">15K</span>
            MENANTI!
        </h2>
    </div>

    <div class="relative z-10 flex flex-col gap-4 mt-6">
        <span class="text-xs bg-black/20 px-3 py-2 rounded-lg font-medium w-fit">
            Voucher tersedia untuk member
        </span>

        <div class="flex flex-wrap items-center gap-3">
            <form method="POST" action="{{ route('vouchers.claim', 'voucher-spesial') }}">
                @csrf

                <button
                    type="submit"
                    {{ session()->has('claimed_vouchers.voucher-spesial') ? 'disabled' : '' }}
                    class="bg-yellow-400 text-black font-bold text-sm px-4 py-3 rounded-xl hover:bg-yellow-300 disabled:opacity-90 transition">
                    {{ session()->has('claimed_vouchers.voucher-spesial') ? '✓ SUDAH DIKLAIM' : 'KLIK DI SINI' }}
                </button>
            </form>

            <a href="{{ route('vouchers.show', 'voucher-spesial') }}"
               class="inline-flex items-center justify-center border-2 border-white text-white font-bold text-xs md:text-sm px-4 py-3 rounded-xl hover:bg-white/15 transition">
                SYARAT & KETENTUAN
            </a>
        </div>
    </div>

</div>

                    
<!-- Banner 2: Mega Sale Diskon 50% -->
<div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-purple-700 via-purple-600 to-indigo-700 text-white rounded-2xl p-6 shadow-md flex flex-col justify-between min-h-[270px]">

    <div class="relative z-10">
        <span class="inline-block bg-white/20 text-xs px-3 py-1.5 rounded-full font-semibold">
            Mega Sale
        </span>

        <h2 class="text-2xl md:text-3xl font-extrabold mt-3">
            LOWEST PRICE EVER!
        </h2>

        <p class="text-lg md:text-xl font-bold text-yellow-300 mt-1">
            Diskon Spesial hingga 50%
        </p>
    </div>

    <div class="relative z-10 flex flex-col gap-4 mt-6">
        <span class="text-xs bg-black/20 px-3 py-2 rounded-lg font-medium w-fit">
            Periode 20–25 September
        </span>

        <div class="flex flex-wrap items-center gap-3">
            <form method="POST" action="{{ route('vouchers.claim', 'mega-sale') }}">
                @csrf

                <button
                    type="submit"
                    {{ session()->has('claimed_vouchers.mega-sale') ? 'disabled' : '' }}
                    class="bg-yellow-400 text-purple-900 font-bold text-sm px-4 py-3 rounded-xl hover:bg-yellow-300 disabled:opacity-90 transition">
                    {{ session()->has('claimed_vouchers.mega-sale') ? '✓ SUDAH DIKLAIM' : 'AMBIL PROMO' }}
                </button>
            </form>

            <a href="{{ route('vouchers.show', 'mega-sale') }}"
               class="inline-flex items-center justify-center border-2 border-white text-white font-bold text-xs md:text-sm px-4 py-3 rounded-xl hover:bg-white/15 transition">
                SYARAT & KETENTUAN
            </a>
        </div>
    </div>

</div>


<!-- Banner 3: Gratis Ongkir Sepuasnya -->
<div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-emerald-700 via-teal-600 to-cyan-700 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
    <div>
        <span class="inline-block bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Gratis Ongkir</span>
        <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">BEBAS ONGKIR SEPUASNYA!</h2>
        <p class="text-xs md:text-sm text-teal-100 mt-1">Belanja kebutuhan harian tanpa batas biaya kirim.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 mt-4">
        <span class="text-xs bg-teal-900/40 px-3 py-2 rounded-lg font-medium">Tanpa Minimum Belanja</span>
        <form method="POST" action="{{ route('vouchers.claim', 'gratis-ongkir') }}">
            @csrf
            <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-300 text-black font-bold text-xs px-4 py-3 rounded-xl whitespace-nowrap transition">
                KLAIM VOUCHER
            </button>
        </form>
        <a href="{{ route('vouchers.show', 'gratis-ongkir') }}"
   class="inline-flex items-center justify-center border-2 border-white text-white font-bold text-sm px-5 py-3 rounded-xl whitespace-nowrap hover:bg-white/15 transition">
    SYARAT & KETENTUAN
</a>
    </div>
</div>

<!-- Banner 4: Flash Sale Kilat -->
<div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-orange-600 via-amber-600 to-yellow-600 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
    <div>
        <span class="inline-block bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Flash Sale</span>
        <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">DISKON KILAT HARI INI!</h2>
        <p class="text-xs md:text-sm text-orange-100 mt-1">Sikat produk pilihan sebelum kehabisan!</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 mt-4">
        <span class="text-xs bg-orange-950/40 px-3 py-2 rounded-lg font-medium">Berakhir Pukul 23:59</span>
        <form method="POST" action="{{ route('vouchers.claim', 'flash-sale') }}">
            @csrf
            <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-300 text-black font-bold text-xs px-4 py-3 rounded-xl whitespace-nowrap transition">
                KLAIM VOUCHER
            </button>
        </form>
        <a href="{{ route('vouchers.show', 'flash-sale') }}"
   class="inline-flex items-center justify-center border-2 border-white text-white font-bold text-sm px-5 py-3 rounded-xl whitespace-nowrap hover:bg-white/15 transition">
    SYARAT & KETENTUAN
</a>
    </div>
</div>

<!-- Banner 5: Cashback Spesial Member -->
<div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-blue-700 via-indigo-600 to-violet-700 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
    <div>
        <span class="inline-block bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Cashback & Poin</span>
        <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">CASHBACK HINGGA 30%</h2>
        <p class="text-xs md:text-sm text-blue-100 mt-1">Kumpulkan poin ekstra dari setiap transaksi harianmu.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 mt-4">
        <span class="text-xs bg-blue-950/40 px-3 py-2 rounded-lg font-medium">Khusus Member DEFAMart</span>
        <form method="POST" action="{{ route('vouchers.claim', 'cashback-member') }}">
            @csrf
            <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-300 text-black font-bold text-xs px-4 py-3 rounded-xl whitespace-nowrap transition">
                KLAIM VOUCHER
            </button>
        </form>
        <a href="{{ route('vouchers.show', 'cashback-member') }}"
   class="inline-flex items-center justify-center border-2 border-white text-white font-bold text-sm px-5 py-3 rounded-xl whitespace-nowrap hover:bg-white/15 transition">
    SYARAT & KETENTUAN
</a>
    </div>
</div>

<!-- Banner 6: Kebutuhan Rumah Tangga Murah -->
<div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-pink-700 via-rose-600 to-red-700 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
    <div>
        <span class="inline-block bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Rumah Tangga</span>
        <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">GROSIR SEMBAKO HEMAT</h2>
        <p class="text-xs md:text-sm text-pink-100 mt-1">Belanja kebutuhan bulanan jadi makin hemat dan praktis.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 mt-4">
        <span class="text-xs bg-rose-950/40 px-3 py-2 rounded-lg font-medium">Kebutuhan Sehari-hari</span>
        <form method="POST" action="{{ route('vouchers.claim', 'rumah-tangga') }}">
            @csrf
            <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-300 text-black font-bold text-xs px-4 py-3 rounded-xl whitespace-nowrap transition">
                KLAIM VOUCHER
            </button>
        </form>
        <a href="{{ route('vouchers.show', 'rumah-tangga') }}"
   class="inline-flex items-center justify-center border-2 border-white text-white font-bold text-sm px-5 py-3 rounded-xl whitespace-nowrap hover:bg-white/15 transition">
    SYARAT & KETENTUAN
</a>
    </div>
</div>

<!-- Banner 7: Produk Perawatan & Kecantikan -->
<div class="w-full md:w-[calc(50%-8px)] flex-shrink-0 relative bg-gradient-to-r from-teal-800 via-emerald-700 to-green-800 text-white rounded-2xl p-6 shadow-md overflow-hidden flex flex-col justify-between h-48 md:h-52">
    <div>
        <span class="inline-block bg-white/20 text-xs px-2.5 py-1 rounded-full font-semibold">Beauty & Care</span>
        <h2 class="text-xl md:text-2xl font-extrabold mt-2 tracking-wide">GLOW UP SETIAP HARI!</h2>
        <p class="text-xs md:text-sm text-emerald-100 mt-1">Temukan produk perawatan tubuh terbaik untukmu.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 mt-4">
        <span class="text-xs bg-emerald-950/40 px-3 py-2 rounded-lg font-medium">Perawatan & Kecantikan</span>
        <form method="POST" action="{{ route('vouchers.claim', 'beauty-care') }}">
            @csrf
            <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-300 text-black font-bold text-xs px-4 py-3 rounded-xl whitespace-nowrap transition">
                KLAIM VOUCHER
            </button>
        </form>
        <a href="{{ route('vouchers.show', 'beauty-care') }}"
   class="inline-flex items-center justify-center border-2 border-white text-white font-bold text-sm px-5 py-3 rounded-xl whitespace-nowrap hover:bg-white/15 transition">
    SYARAT & KETENTUAN
</a>
    </div>
</div>

                </div>
        <!-- PENUTUP promoSlider -->

    </div>
    <!-- PENUTUP AREA SLIDER -->  
                


<!-- NAVIGASI PROMO -->
<div class="w-full mt-6 px-4">

    <div class="flex flex-wrap items-center justify-between gap-4 w-full">

        <!-- SEBELUMNYA -->
        <button
            type="button"
            onclick="scrollSlider(-1)"
            class="flex-shrink-0 text-sm font-semibold text-gray-500 hover:text-green-800 cursor-pointer transition"
        >
            &rarr; Lihat Promo Sebelumnya
        </button>

        <!-- INDIKATOR -->
        <div class="flex items-center justify-center gap-2">

            @for ($i = 0; $i < 7; $i++)
                <span
                    class="dot w-2.5 h-2.5 rounded-full bg-gray-300 transition-all duration-300"
                    data-index="{{ $i }}">
                </span>
            @endfor

        </div>

        <!-- SELANJUTNYA -->
        <button
            type="button"
            onclick="scrollSlider(1)"
            class="flex-shrink-0 text-sm font-semibold text-gray-500 hover:text-green-800 cursor-pointer transition"
        >
            Lihat Promo Selanjutnya &rarr;
        </button>

    </div>

</div>
<!-- AKHIR NAVIGASI -->


    </div>
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
                                    <div class="w-full aspect-[4/3] bg-gray-100 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
                                        <!-- Otomatis membuat gambar berlatar warna dengan inisial nama produk -->
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($product->name) }}&background=random&color=fff&size=250&bold=true" 
                                            alt="{{ $product->name }}" 
                                            class="w-full h-full object-cover">
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

        if (searchInput && searchForm) {
            searchInput.addEventListener('input', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function () {
                    searchForm.submit();
                }, doneTypingInterval);
            });
        }
    </script>

    <!-- Overlay di Belakang Panel -->
<div id="cartOverlay" class="fixed inset-0 z-40 hidden bg-black/40 transition-opacity" onclick="toggleCart()"></div>

    <!-- Panel Samping Keranjang Belanja -->
    <div id="cartDrawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        
        <!-- Bagian Atas: Header dan Daftar Barang -->
        <div class="flex flex-col flex-1 min-h-0">
            <div class="flex items-center justify-between p-5 border-b border-gray-200 flex-shrink-0">
                <h2 class="text-lg font-bold text-gray-800">Keranjang Belanja Anda</h2>
                <button onclick="toggleCart()" class="text-gray-400 hover:text-gray-600 text-xl font-bold px-2">&times;</button>
            </div>

            <!-- Daftar Item di Keranjang -->
            <div id="cartItemsList" class="flex-1 min-h-0 overflow-y-auto p-5 space-y-4">
                @php
                    $userId = Auth::id() ?? 1;
                    $userCart = \App\Models\Cart::with('items.product')->where('user_id', $userId)->first();
                    $totalPrice = 0;
                @endphp

                @if(!$userCart || $userCart->items->isEmpty())
                    <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-emerald-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                <path d="M9 10h10M10 13h8"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-emerald-900 mb-2">Keranjang Anda Saat Ini Masih Kosong</h3>
                        <p class="text-sm text-gray-600 leading-relaxed max-w-xs">Yuk belanja dan temukan produk favoritmu di DEFAMart!</p>
                    </div>
                @else
                    @foreach($userCart->items as $item)
                        @php 
                            $subtotal = $item->product->price * $item->quantity;
                            $totalPrice += $subtotal;
                        @endphp
                        <div class="flex items-center justify-between border-b pb-3">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" class="cart-item-checkbox w-4 h-4 accent-emerald-700 cursor-pointer" data-cart-item-id="{{ $item->id }}" checked aria-label="Pilih {{ $item->product->name }}">
                                <div class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-[10px] text-gray-400">No Image</span>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $item->product->name }}</h4>
                                    

<div class="flex items-center gap-2 mt-1">
    <button
        type="button"
        onclick="updateCartQuantity({{ $item->id }}, 'decrease', this)"
        class="w-7 h-7 border rounded-md text-gray-700 hover:bg-gray-100">
        −
    </button>

    <input
        type="number"
        min="1"
        value="{{ $item->quantity }}"
        data-cart-item-id="{{ $item->id }}"
        class="cart-quantity w-12 h-7 border rounded-md text-center text-sm"
        onchange="updateCartQuantity({{ $item->id }}, 'set', this)">

    <button
        type="button"
        onclick="updateCartQuantity({{ $item->id }}, 'increase', this)"
        class="w-7 h-7 border rounded-md text-gray-700 hover:bg-gray-100">
        +
    </button>

    <span class="text-xs text-gray-500">
        Rp {{ number_format($item->product->price, 0, ',', '.') }}/produk
    </span>
</div>


                                </div>
                            </div>
                            <p
    class="text-sm font-bold text-emerald-700 cart-subtotal"
    data-cart-item-id="{{ $item->id }}" data-subtotal="{{ $subtotal }}">
    Rp {{ number_format($subtotal, 0, ',', '.') }}
</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Popup Konfirmasi Hapus Barang -->
        <div id="removeCartModal"
            class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

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

        <!-- Bagian Bawah: Total Harga & Tombol Checkout -->
        <div class="flex-shrink-0 p-5 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between mb-4">
                <span class="text-base font-semibold text-gray-700">Total Harga:</span>
                <span id="cartTotal" class="text-xl font-extrabold text-emerald-700">
    Rp {{ number_format(isset($totalPrice) ? $totalPrice : 0, 0, ',', '.') }}
</span>
            </div>
        <div id="cartCheckoutSection">
            @if($userCart && $userCart->items->isNotEmpty())
                <form action="{{ route('order.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shipping_address" value="Alamat pengiriman untuk testing">
                    <button type="submit" class="w-full bg-[#134e32] hover:bg-[#0f3e28] text-white font-bold py-3 rounded-xl shadow transition">
                        Lanjut ke Pembayaran
                    </button>
                </form>
            @else
                <button type="button" disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3 rounded-xl cursor-not-allowed">
                    Keranjang Kosong
                </button>
            @endif
        </div>
        </div>

    </div>

    <!-- Skrip JavaScript untuk Buka/Tutup Panel Samping -->
    <script>
    function toggleCart(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    const drawer = document.getElementById('cartDrawer');
    const overlay = document.getElementById('cartOverlay');

    if (!drawer || !overlay) return;

    // Cek status apakah drawer sedang tertutup (memiliki kelas translate-x-full)
    const isClosed = drawer.classList.contains('translate-x-full');

    if (isClosed) {
        drawer.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
    } else {
        drawer.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    }
}

    </script>

    <script>
    
    // Menangkap semua form tambah ke keranjang
    function updateCartCheckout(items) {
        const section = document.getElementById('cartCheckoutSection');
        if (!section) return;

        if (items && items.length > 0) {
            section.innerHTML = `
                <form action="{{ route('order.checkout') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="shipping_address" value="Alamat pengiriman untuk testing">
                    <button type="submit" class="w-full bg-[#134e32] hover:bg-[#0f3e28] text-white font-bold py-3 rounded-xl shadow transition">
                        Lanjut ke Pembayaran
                    </button>
                </form>
            `;
            updateSelectedCartSummary();
        } else {
            section.innerHTML = `
                <button type="button" disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3 rounded-xl cursor-not-allowed">
                    Keranjang Kosong
                </button>
            `;
        }
    }

    function updateSelectedCartSummary() {
        const checkboxes = Array.from(
            document.querySelectorAll('.cart-item-checkbox:checked')
        );

        let total = 0;

        checkboxes.forEach(checkbox => {
            const id = checkbox.dataset.cartItemId;
            const subtotal = document.querySelector(
                `.cart-subtotal[data-cart-item-id="${id}"]`
            );

            if (subtotal) {
                const value = subtotal.dataset.subtotal !== undefined
                    ? Number(subtotal.dataset.subtotal)
                    : Number(subtotal.textContent.replace(/[^\d]/g, ''));

                if (Number.isFinite(value)) {
                    total += value;
                }
            }
        });

        const totalElement = document.getElementById('cartTotal');
        if (totalElement) {
            totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        const section = document.getElementById('cartCheckoutSection');
        const form = section ? section.querySelector('form') : null;

        if (form) {
            form.querySelectorAll('input[name="selected_items[]"]').forEach(input => {
                input.remove();
            });

            checkboxes.forEach(checkbox => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'selected_items[]';
                hidden.value = checkbox.dataset.cartItemId;
                form.appendChild(hidden);
            });

            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = checkboxes.length === 0;
                button.classList.toggle('opacity-50', checkboxes.length === 0);
                button.classList.toggle('cursor-not-allowed', checkboxes.length === 0);
            }
        }
    }

    document.addEventListener('change', function (event) {
        if (event.target.matches('.cart-item-checkbox')) {
            updateSelectedCartSummary();
        }
    });

    updateSelectedCartSummary();

    function renderCartItems(items) {
        const list = document.getElementById('cartItemsList');
        if (!list) return;

        list.replaceChildren();
        updateCartCheckout(items);

        if (!items || items.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'flex flex-col items-center justify-center py-8 px-4 text-center';
            empty.innerHTML = `
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-emerald-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        <path d="M9 10h10M10 13h8"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-emerald-900 mb-2">Keranjang Anda Saat Ini Masih Kosong</h3>
                <p class="text-sm text-gray-600 leading-relaxed max-w-xs">Yuk belanja dan temukan produk favoritmu di DEFAMart!</p>
            `;
            list.appendChild(empty);
            updateSelectedCartSummary();
            return;
        }

        items.forEach(item => {
            const row = document.createElement('div');
            row.className = 'cart-item-row flex items-center justify-between border-b pb-3';
            row.dataset.cartItemId = item.id;

            const left = document.createElement('div');
            left.className = 'flex items-center space-x-3';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'cart-item-checkbox w-4 h-4 accent-emerald-700 cursor-pointer';
            checkbox.dataset.cartItemId = item.id;
            checkbox.checked = true;
            checkbox.setAttribute('aria-label', 'Pilih ' + (item.name || 'Produk'));

            checkbox.addEventListener('change', updateSelectedCartSummary);

            const imageBox = document.createElement('div');
            imageBox.className = 'w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden flex-shrink-0';

            const img = document.createElement('img');
            img.src = 'https://ui-avatars.com/api/?name='
                + encodeURIComponent(item.name || 'Produk')
                + '&background=random&color=fff&size=250&bold=true';
            img.alt = item.name || 'Produk';
            img.className = 'w-full h-full object-cover';
            imageBox.appendChild(img);

            const details = document.createElement('div');
            const name = document.createElement('h4');
            name.className = 'text-sm font-semibold text-gray-800 line-clamp-1';
            name.textContent = item.name || 'Produk';
            details.appendChild(name);

            const controls = document.createElement('div');
            controls.className = 'flex items-center gap-2 mt-1';

            const decrease = document.createElement('button');
            decrease.type = 'button';
            decrease.className = 'w-7 h-7 border rounded-md text-sm';
            decrease.textContent = '−';
            decrease.addEventListener('click', function () {
                updateCartQuantity(item.id, 'decrease', this);
            });

            const quantity = document.createElement('input');
            quantity.type = 'number';
            quantity.min = '1';
            quantity.value = item.quantity;
            quantity.dataset.cartItemId = item.id;
            quantity.className = 'cart-quantity w-12 h-7 border rounded-md text-center text-sm';
            quantity.addEventListener('change', function () {
                updateCartQuantity(item.id, 'set', this);
            });

            const increase = document.createElement('button');
            increase.type = 'button';
            increase.className = 'w-7 h-7 border rounded-md text-sm';
            increase.textContent = '+';
            increase.addEventListener('click', function () {
                updateCartQuantity(item.id, 'increase', this);
            });

            const price = document.createElement('span');
            price.className = 'text-xs text-gray-500';
            price.textContent = 'Rp ' + Number(item.price).toLocaleString('id-ID') + '/produk';

            controls.append(decrease, quantity, increase, price);
            details.appendChild(controls);
            left.append(checkbox, imageBox, details);

            const subtotal = document.createElement('p');
            subtotal.className = 'text-sm font-bold text-emerald-700 cart-subtotal';
            subtotal.dataset.cartItemId = item.id;
            subtotal.textContent = 'Rp ' + Number(item.subtotal).toLocaleString('id-ID');

            row.append(left, subtotal);
            list.appendChild(row);
        });

        updateSelectedCartSummary();
    }

    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            button.disabled = true;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Gagal menambahkan barang.');
                }

                const countElement = document.getElementById('cartCount');
                if (countElement) {
                    countElement.textContent = data.cart_count;
                }

                const totalElement = document.getElementById('cartTotal');
                if (totalElement) {
                    totalElement.textContent = 'Rp ' +
                        Number(data.total).toLocaleString('id-ID');
                }

                renderCartItems(data.items);
            } catch (error) {
                alert('Gagal menambahkan barang: ' + error.message);
                console.error(error);
            } finally {
                button.disabled = false;
                button.textContent = originalText;
            }
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

    <script>
        

window.scrollSlider = function(direction) {
    const slider = document.getElementById('promoSlider');

    if (!slider) {
        alert('Slider tidak ditemukan!');
        return;
    }

    const banner = slider.firstElementChild;

    if (!banner) {
        alert('Banner tidak ditemukan!');
        return;
    }

    const gap = parseFloat(getComputedStyle(slider).gap) || 16;

    const jarak = banner.getBoundingClientRect().width + gap;

    slider.scrollBy({
        left: direction * jarak,
        behavior: 'smooth'
    });
};


// INDIKATOR TITIK PROMO
const promoSlider = document.getElementById('promoSlider');
const dots = document.querySelectorAll('.dot');

if (promoSlider) {

    function updateDots() {
        const banner = promoSlider.firstElementChild;
        if (!banner) return;

        const gap = parseFloat(getComputedStyle(promoSlider).gap) || 16;
        const bannerWidth = banner.getBoundingClientRect().width + gap;

        let index = Math.round(promoSlider.scrollLeft / bannerWidth);

        index = Math.max(0, Math.min(index, dots.length - 1));

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('w-2', 'h-2', 'bg-gray-300');
                dot.classList.add('w-3', 'h-3', 'bg-red-600');
            } else {
                dot.classList.remove('w-3', 'h-3', 'bg-red-600');
                dot.classList.add('w-2', 'h-2', 'bg-gray-300');
            }
        });
    }

    promoSlider.addEventListener('scroll', updateDots);
    updateDots();
}

    </script>


<script>
let pendingRemoveCartItemId = null;

function showRemoveCartModal(itemId) {
    pendingRemoveCartItemId = itemId;

    const modal = document.getElementById('removeCartModal');

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

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


        const remainingInputs = document.querySelectorAll(
            '.cart-quantity[data-cart-item-id]'
        );

        const cartCount = document.getElementById('cartCount');

        if (cartCount) {
            let quantityCount = 0;

            remainingInputs.forEach(input => {
                quantityCount += parseInt(input.value, 10) || 0;
            });

            cartCount.textContent = quantityCount;
        }

        if (remainingInputs.length === 0) {
            renderCartItems([]);
            closeRemoveCartModal();
            return;
        }

        updateCartCheckout(Array.from(remainingInputs).filter(input => parseInt(input.value, 10) > 0));
        updateSelectedCartSummary();

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
            subtotal.dataset.subtotal = Number(data.subtotal);
        }

        updateSelectedCartSummary();

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

</body>
</html>
