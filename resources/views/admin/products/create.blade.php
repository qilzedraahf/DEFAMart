<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - DEFAMart</title>
    <!-- Masukkan CDN Tailwind CSS jika belum ada -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-sm border">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h1>

        <!-- PENTING: enctype="multipart/form-data" wajib ada agar file terkirim -->
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Produk -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="name" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-emerald-500" required>
            </div>

            <!-- Kategori (Opsional, sesuaikan relasi) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" class="w-full border rounded-lg p-2" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Harga -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" name="price" class="w-full border rounded-lg p-2" required>
            </div>

            <!-- Input File Gambar -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                <input type="file" name="image" accept="image/*" class="w-full border rounded-lg p-2 bg-gray-50">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, JPEG (Maks. 2MB)</p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">Batal</a>
                <button type="submit" class="px-4 py-2 bg-[#134e32] text-white rounded-lg text-sm font-semibold hover:bg-[#0f3e28]">Simpan Produk</button>
            </div>
        </form>
    </div>
</body>
</html>