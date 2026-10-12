<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create(['category_id' => 1, 'name' => 'Beras Pandan Wangi 5kg', 'slug' => 'beras-pandan-wangi-5kg', 'price' => 72000, 'stock' => 45, 'description' => 'Beras wangi pulen kualitas premium.', 'image' => 'beras-pandan.png']);
        Product::create(['category_id' => 1, 'name' => 'Minyak Goreng Pouch 1L', 'slug' => 'minyak-goreng-pouch-1l', 'price' => 18500, 'stock' => 80, 'description' => 'Minyak goreng kelapa sawit jernih.', 'image' => 'minyak-1l.png']);
        Product::create(['category_id' => 1, 'name' => 'Gula Pasir Kuning 1kg', 'slug' => 'gula-pasir-kuning-1kg', 'price' => 15000, 'stock' => 70, 'description' => 'Gula tebu alami berkualitas.', 'image' => 'gula-kuning.png']);
        Product::create(['category_id' => 1, 'name' => 'Tepung Terigu Segitiga 1kg', 'slug' => 'tepung-terigu-segitiga-1kg', 'price' => 13500, 'stock' => 50, 'description' => 'Tepung terigu serbaguna untuk aneka makanan.', 'image' => 'terigu.png']);
        Product::create(['category_id' => 1, 'name' => 'Garam Beryodium 500g', 'slug' => 'garam-beryodium-500g', 'price' => 4500, 'stock' => 100, 'description' => 'Garam dapur beryodium sehat.', 'image' => 'garam.jpg']);
        Product::create(['category_id' => 1, 'name' => 'Kecap Manis Botol 520ml', 'slug' => 'kecap-manis-botol-520ml', 'price' => 21000, 'stock' => 40, 'description' => 'Kecap manis kental dari kedelai pilihan.', 'image' => 'kecap.jpg']);
        Product::create(['category_id' => 1, 'name' => 'Saus Sambal Botol 335ml', 'slug' => 'saus-sambal-botol-335ml', 'price' => 16500, 'stock' => 45, 'description' => 'Saus cabai pedas nikmat.', 'image' => 'sambal.jpg']);
        Product::create(['category_id' => 1, 'name' => 'Saus Tomat Botol 335ml', 'slug' => 'saus-tomat-botol-335ml', 'price' => 15500, 'stock' => 35, 'description' => 'Saus tomat segar berkualitas.', 'image' => 'tomat.jpg']);
        
        Product::create(['category_id' => 2, 'name' => 'Susu Pertumbuhan Anak 3+', 'slug' => 'susu-pertumbuhan-anak-3', 'price' => 85000, 'stock' => 25, 'description' => 'Susu tinggi kalsium untuk usia 3 tahun ke atas.', 'image' => 'susu-3.jpg']);
        Product::create(['category_id' => 2, 'name' => 'Susu Bayi Tahap 1 (0-6 bln)', 'slug' => 'susu-bayi-tahap-1', 'price' => 98000, 'stock' => 20, 'description' => 'Formula khusus bayi baru lahir.', 'image' => 'susu-bayi1.jpg']);
        Product::create(['category_id' => 2, 'name' => 'Bubur Bayi Instant Sereal', 'slug' => 'bubur-bayi-instant-sereal', 'price' => 18000, 'stock' => 40, 'description' => 'Bubur bernutrisi pendamping ASI.', 'image' => 'bubur-bayi.jpg']);
        Product::create(['category_id' => 2, 'name' => 'Biskuit Bayi Lumer', 'slug' => 'biskuit-bayi-lumer', 'price' => 16000, 'stock' => 35, 'description' => 'Biskuit sehat mudah lumer di mulut bayi.', 'image' => 'biskuit-bayi.jpg']);
        Product::create(['category_id' => 2, 'name' => 'Popok Bayi Tipe Celana S36', 'slug' => 'popok-bayi-tipe-celana-s36', 'price' => 48000, 'stock' => 30, 'description' => 'Popok celana ukuran S nyaman anti iritasi.', 'image' => 'popok-s.jpg']);
        Product::create(['category_id' => 2, 'name' => 'Popok Bayi Tipe Celana L30', 'slug' => 'popok-bayi-tipe-celana-l30', 'price' => 58000, 'stock' => 30, 'description' => 'Popok celana ukuran L daya serap tinggi.', 'image' => 'popok-l.jpg']);
        Product::create(['category_id' => 2, 'name' => 'Popok Bayi Tipe Celana XL26', 'slug' => 'popok-bayi-tipe-celana-xl26', 'price' => 62000, 'stock' => 25, 'description' => 'Popok celana ukuran XL ekstra kering.', 'image' => 'popok-xl.jpg']);
        Product::create(['category_id' => 2, 'name' => 'Tisu Basah Bayi Anti Bakteri', 'slug' => 'tisu-basah-bayi-anti-bakteri', 'price' => 14000, 'stock' => 50, 'description' => 'Tisu basah lembut aman untuk kulit sensitif.', 'image' => 'tisu-basah.jpg']);
        
        Product::create(['category_id' => 3, 'name' => 'Keripik Singkong Original', 'slug' => 'keripik-singkong-original', 'price' => 11000, 'stock' => 50, 'description' => 'Keripik singkong renyah gurih.', 'image' => 'keripik-singkong.jpg']);
        Product::create(['category_id' => 3, 'name' => 'Keripik Tempe Sagu Renyah', 'slug' => 'keripik-tempe-sagu-renyah', 'price' => 13000, 'stock' => 45, 'description' => 'Tempe diiris tipis digoreng kriuk.', 'image' => 'keripik-tempe.jpg']);
        Product::create(['category_id' => 3, 'name' => 'Kacang Garuda Pilus Gurih', 'slug' => 'kacang-garuda-pilus-gurih', 'price' => 8000, 'stock' => 60, 'description' => 'Pilus renyah teman santai.', 'image' => 'pilus.jpg']);
        Product::create(['category_id' => 3, 'name' => 'Kacang Polong Tepung Crispy', 'slug' => 'kacang-polong-tepung-crispy', 'price' => 10000, 'stock' => 50, 'description' => 'Kacang polong balut tepung gurih.', 'image' => 'kacang-polong.jpg']);
        Product::create(['category_id' => 3, 'name' => 'Biskuit Kelapa Kaleng Besar', 'slug' => 'biskuit-kelapa-kaleng-besar', 'price' => 45000, 'stock' => 25, 'description' => 'Biskuit kelapa renyah kemasan kaleng.', 'image' => 'biskuit-kelapa.jpg']);
        Product::create(['category_id' => 3, 'name' => 'Wafer Krim Cokelat Lezat', 'slug' => 'wafer-krim-cokelat-lezat', 'price' => 7500, 'stock' => 70, 'description' => 'Wafer renyah isi krim cokelat tebal.', 'image' => 'wafer-coklat.jpg']);
        Product::create(['category_id' => 3, 'name' => 'Wafer Krim Keju Gurih', 'slug' => 'wafer-krim-keju-gurih', 'price' => 7500, 'stock' => 70, 'description' => 'Wafer renyah isi krim keju.', 'image' => 'wafer-keju.jpg']);
        Product::create(['category_id' => 3, 'name' => 'Biskuit Sandwich Cokelat', 'slug' => 'biskuit-sandwich-cokelat', 'price' => 9000, 'stock' => 60, 'description' => 'Biskuit hitam isi krim manis.', 'image' => 'biskuit-sandwich.jpg']);
        
        Product::create(['category_id' => 4, 'name' => 'Sabun Mandi Batang Antibakteri', 'slug' => 'sabun-mandi-batang-antibakteri', 'price' => 4500, 'stock' => 120, 'description' => 'Sabun batang perlindungan total kuman.', 'image' => 'sabun-batang.jpg']);
        Product::create(['category_id' => 4, 'name' => 'Sabun Mandi Cair Pouch 400ml', 'slug' => 'sabun-mandi-cair-pouch-400ml', 'price' => 22000, 'stock' => 60, 'description' => 'Sabun mandi cair aromaterapi wangi tahan lama.', 'image' => 'sabun-cair.jpg']);
        Product::create(['category_id' => 4, 'name' => 'Shampoo Anti Ketombe 340ml', 'slug' => 'shampoo-anti-ketombe-340ml', 'price' => 38000, 'stock' => 45, 'description' => 'Shampoo pembersih kulit kepala gatal.', 'image' => 'shampoo.jpg']);
        Product::create(['category_id' => 4, 'name' => 'Conditioner Rambut Lembut 170ml', 'slug' => 'conditioner-rambut-lembut-170ml', 'price' => 29000, 'stock' => 30, 'description' => 'Kondisioner pelurus rambut mudah diatur.', 'image' => 'conditioner.jpg']);
        Product::create(['category_id' => 4, 'name' => 'Pasta Gigi Pemutih 190g', 'slug' => 'pasta-gigi-pemutih-190g', 'price' => 14500, 'stock' => 70, 'description' => 'Pasta gigi perlindungan gigi berlubang.', 'image' => 'odol.jpg']);
        Product::create(['category_id' => 4, 'name' => 'Sikat Gigi Dewasa Isi 3', 'slug' => 'sikat-gigi-dewasa-isi-3', 'price' => 18000, 'stock' => 50, 'description' => 'Sikat gigi bulu lembut paket hemat.', 'image' => 'sikat-gigi.jpg']);
        Product::create(['category_id' => 4, 'name' => 'Obat Kumur Antiseptik 250ml', 'slug' => 'obat-kumur-antiseptik-250ml', 'price' => 26000, 'stock' => 35, 'description' => 'Pembersih mulut penyegar napas.', 'image' => 'mouthwash.jpg']);
        Product::create(['category_id' => 4, 'name' => 'Deodorant Roll On Pria 50ml', 'slug' => 'deodorant-roll-on-pria-50ml', 'price' => 19000, 'stock' => 40, 'description' => 'Pewangi ketiak tahan keringat seharian.', 'image' => 'deo-pria.jpg']);
        
        Product::create(['category_id' => 5, 'name' => 'Deterjen Bubuk Cuci Baju 1kg', 'slug' => 'deterjen-bubuk-cuci-baju-1kg', 'price' => 22000, 'stock' => 80, 'description' => 'Deterjen angkat noda berat dalam sekali kucek.', 'image' => 'deterjen-bubuk.jpg']);
        Product::create(['category_id' => 5, 'name' => 'Deterjen Cair Laundry 800ml', 'slug' => 'deterjen-cair-laundry-800ml', 'price' => 26000, 'stock' => 60, 'description' => 'Deterjen cair mudah larut wangi tahan lama.', 'image' => 'deterjen-cair.jpg']);
        Product::create(['category_id' => 5, 'name' => 'Pewangi Pakaian Pewarna Pelicin 1L', 'slug' => 'pewangi-pakaian-pewarna-pelicin-1l', 'price' => 16000, 'stock' => 70, 'description' => 'Pelicin pakaian setrika wangi semerbak.', 'image' => 'pewangi-pakaian.jpg']);
        Product::create(['category_id' => 5, 'name' => 'Pembersih Lantai Karbol Wangi 800ml', 'slug' => 'pembersih-lantai-karbol-wangi-800ml', 'price' => 15000, 'stock' => 65, 'description' => 'Cairan pembersih lantai bunuh kuman dan bau.', 'image' => 'karbol.jpg']);
        Product::create(['category_id' => 5, 'name' => 'Pembersih Porselen & Kamar Mandi 500ml', 'slug' => 'pembersih-porselen-kamar-mandi-500ml', 'price' => 17000, 'stock' => 50, 'description' => 'Ampuh rontokkan kerak kuning kamar mandi.', 'image' => 'pembersih-porselen.jpg']);
        Product::create(['category_id' => 5, 'name' => 'Sabun Cuci Piring Jeruk Nipis 750ml', 'slug' => 'sabun-cuci-piring-jeruk-nipis-750ml', 'price' => 18500, 'stock' => 90, 'description' => 'Pembersih lemak piring ampuh wangi jeruk.', 'image' => 'sunlight.jpg']);
        Product::create(['category_id' => 5, 'name' => 'Spons Cuci Piring Serbaguna Isi 3', 'slug' => 'spons-cuci-piring-serbaguna-isi-3', 'price' => 6500, 'stock' => 100, 'description' => 'Spons sabut cuci piring dua sisi.', 'image' => 'spons.jpg']);
        Product::create(['category_id' => 5, 'name' => 'Tisu Toilet Gulung Roll Isi 4', 'slug' => 'tisu-toilet-gulung-roll-isi-4', 'price' => 19000, 'stock' => 50, 'description' => 'Tisu gulung toilet lembut kuat.', 'image' => 'tisu-toilet.jpg']);
        
        Product::create(['category_id' => 6, 'name' => 'Sosis Sapi Siap Saji 350g', 'slug' => 'sosis-sapi-siap-saji-350g', 'price' => 28000, 'stock' => 30, 'description' => 'Sosis daging sapi lezat gurih.', 'image' => 'sosis-sapi.jpg']);
        Product::create(['category_id' => 6, 'name' => 'Bakso Sapi Beku Pack 50pcs', 'slug' => 'bakso-sapi-beku-pack-50pcs', 'price' => 45000, 'stock' => 25, 'description' => 'Bakso daging sapi asli kenyal sedap.', 'image' => 'bakso-sapi.jpg']);
        Product::create(['category_id' => 6, 'name' => 'Kentang Fries Beku 1kg', 'slug' => 'kentang-fries-beku-1kg', 'price' => 32000, 'stock' => 35, 'description' => 'Kentang goreng potong beku siap goring.', 'image' => 'kentang-beku.jpg']);
        Product::create(['category_id' => 6, 'name' => 'Burger Bun Roti Rangkaian Isi 6', 'slug' => 'burger-bun-roti-rangkaian-isi-6', 'price' => 15000, 'stock' => 20, 'description' => 'Roti burger empuk bertabur wijen.', 'image' => 'burger-bun.jpg']);
        Product::create(['category_id' => 6, 'name' => 'Daging Burger Sapi Patties 5pcs', 'slug' => 'daging-burger-sapi-patties-5pcs', 'price' => 30000, 'stock' => 25, 'description' => 'Oalahan daging burger sapi gurih.', 'image' => 'patties.jpg']);
        Product::create(['category_id' => 6, 'name' => 'Buah Apel Fuji Segar 1kg', 'slug' => 'buah-apel-fuji-segar-1kg', 'price' => 35000, 'stock' => 30, 'description' => 'Apel manis renyah penuh nutrisi.', 'image' => 'apel-fuji.jpg']);
        Product::create(['category_id' => 6, 'name' => 'Buah Jeruk Mandarin 1kg', 'slug' => 'buah-jeruk-mandarin-1kg', 'price' => 38000, 'stock' => 25, 'description' => 'Jeruk segar manis banyak air.', 'image' => 'jeruk-mandarin.jpg']);
        Product::create(['category_id' => 6, 'name' => 'Pisang Cavendish Manis 1 Sisir', 'slug' => 'pisang-cavendish-manis-1-sisir', 'price' => 25000, 'stock' => 20, 'description' => 'Pisang cavendish segar matang pohon.', 'image' => 'pisang.jpg']);
    }
}