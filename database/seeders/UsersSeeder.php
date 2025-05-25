<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Demo',
                'email' => 'admin@demo.com',
                'password' => Hash::make('admin123'),
                'birth_date' => '1990-01-01',
                'gender' => 'male', // <-- WAJIB ADA
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Demo',
                'email' => 'user@demo.com',
                'password' => Hash::make('user123'),
                'birth_date' => '1995-03-27',
                'gender' => 'female', // <-- WAJIB ADA
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
