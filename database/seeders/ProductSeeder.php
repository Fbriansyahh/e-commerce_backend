<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Kaos Polos Hitam',
                'description' => 'Kaos polos bahan cotton combed 30s.',
                'price' => 65000,
                'stock' => 100,
                'category_id' => 1, // T-Shirt
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jaket Hoodie Abu',
                'description' => 'Jaket hoodie nyaman untuk dipakai harian.',
                'price' => 150000,
                'stock' => 50,
                'category_id' => 2, // Jacket
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Celana Jeans Slim Fit',
                'description' => 'Celana jeans model slim fit, cocok buat nongkrong.',
                'price' => 180000,
                'stock' => 40,
                'category_id' => 3, // Celana
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sepatu Sneakers Putih',
                'description' => 'Sneakers keren buat gaya kasual.',
                'price' => 275000,
                'stock' => 60,
                'category_id' => 4, // Sepatu
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tas Ransel Pria',
                'description' => 'Tas ransel muat laptop 15 inch, cocok buat kerja.',
                'price' => 120000,
                'stock' => 80,
                'category_id' => 5, // Tas
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
