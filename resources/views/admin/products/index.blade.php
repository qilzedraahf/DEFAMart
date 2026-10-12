<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - DEFAMart</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        
        <!-- Header & Tombol Tambah -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Daftar Produk DEFAMart</h1>
                <p class="text-xs text-gray-500 mt-1">Kelola data produk dan gambar di sini.</p>
            </div>
            <a href="{{ route('products.create') }}" class="px-4 py-2 bg-[#134e32] text-white rounded-lg text-sm font-semibold hover:bg-[#0f3e28] transition">
                + Tambah Produk Baru
            </a>
        </div>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Daftar Produk -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider border-b">
                        <th class="p-3">Gambar</th>
                        <th class="p-3">Nama Produk</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Stok</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Kolom Gambar -->
                            <td class="p-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-[10px] text-gray-400 text-center">No Image</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kolom Nama & Slug -->
                            <td class="p-3">
                                <p class="font-bold text-gray-800">{{ $product->name }}</p>
                                <span class="text-xs text-gray-400">{{ $product->slug }}</span>
                            </td>

                            <!-- Kolom Kategori -->
                            <td class="p-3">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold">
                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>

                            <!-- Kolom Harga -->
                            <td class="p-3 font-semibold text-emerald-700">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <!-- Kolom Stok -->
                            <td class="p-3">
                                <span class="{{ $product->stock > 0 ? 'text-gray-700' : 'text-red-500 font-bold' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>

                            <!-- Kolom Aksi (Edit & Hapus) -->
                            <td class="p-3 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="px-3 py-1.5 bg-amber-500 text-white rounded-lg text-xs font-semibold hover:bg-amber-600 transition">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded-lg text-xs font-semibold hover:bg-red-600 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400">
                                Belum ada produk yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>