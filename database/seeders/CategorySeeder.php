<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['id' => 1, 'name' => 'Sembako & Dapur', 'slug' => 'sembako-dapur'],
            ['id' => 2, 'name' => 'Susu & Anak', 'slug' => 'susu-anak'],
            ['id' => 3, 'name' => 'Cemilan & Minuman', 'slug' => 'cemilan-minuman'],
            ['id' => 4, 'name' => 'Perawatan Tubuh', 'slug' => 'perawatan-tubuh'],
            ['id' => 5, 'name' => 'Rumah Tangga', 'slug' => 'rumah-tangga'],
            ['id' => 6, 'name' => 'Segar & Beku', 'slug' => 'segar-beku'],
        ]);
    }
}