<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Admin No.1',
                'no_hp' => '081234567890',
                'role' => 'admin',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru User',
                'email' => 'guru@example.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Guru No.2',
                'no_hp' => '082234567890',
                'role' => 'guru',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siswa User',
                'email' => 'siswa@example.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Siswa No.3',
                'no_hp' => '083234567890',
                'role' => 'siswa',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);    }
}
