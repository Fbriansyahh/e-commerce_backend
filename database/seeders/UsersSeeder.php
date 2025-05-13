<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Demo',
                'email' => 'admin@demo.com',
                'password' => Hash::make('password'), // password: password
                'birth_date' => '2024-02-28',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Demo',
                'email' => 'user@demo.com',
                'password' => Hash::make('password'), // password: password
                'birth_date' => '2024-03-27',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
