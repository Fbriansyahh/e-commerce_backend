<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'T-Shirt', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jacket', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Celana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sepatu', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}


