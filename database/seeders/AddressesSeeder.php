<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesSeeder extends Seeder
{
    public function run()
    {
        DB::table('addresses')->insert([
            [
                'user_id' => 2, // User Demo
                'name' => 'User Demo',
                'phone' => '081234567890',
                'province' => 'Jawa Barat',
                'city' => 'Karawang',
                'district' => 'Telukjambe',
                'postal_code' => '41361',
                'street_address' => 'Jl. Mawar No. 88',
                'detail' => 'Rumah cat biru, samping warung',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
