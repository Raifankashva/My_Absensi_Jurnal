<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            // Membuat User dengan role siswa
            $user = User::create([
                'name' => 'Siswa ' . $i,
                'email' => 'siswa' . $i . Str::random(5) . '@example.com', // Gunakan Str::random(5) untuk email unik
                'password' => Hash::make('password'),
                'alamat' => 'Alamat Siswa ' . $i,
                'no_hp' => '0812345678' . $i,
                'role' => 'siswa',
            ]);

            // Membuat Data Siswa terkait User
            DB::table('data_siswa')->insert([
                'user_id' => $user->id,
                'sekolah_id' => 17,
                'kelas_id' => 16, // Misalnya kelas 1, bisa disesuaikan
                'nisn' => 'NISN' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'nis' => 'NIS' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'nik' => '123456' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'nama_lengkap' => 'Nama Lengkap Siswa ' . $i,
                'jenis_kelamin' => ($i % 2 == 0) ? 'Perempuan' : 'Laki-laki',
                'tmp_lahir' => 'Kota ' . $i,
                'tgl_lahir' => now()->subYears(rand(15, 18)),
                'agama' => 'Islam',
                'province_id' => '32',
                'city_id' => '3276',
                'district_id' => '3276061',
                'village_id' => '3276061002',
                'kode_pos' => '12345',
                'tinggal' => 'Ortu',
                'transport' => 'Jalan Kaki',
                'hp' => '0812345678' . $i,
                'ayah' => 'Bapak ' . $i,
                'email_ayah' => 'ayah' . $i . '@example.com',
                'kerja_ayah' => 'PNS',
                'ibu' => 'Ibu ' . $i,
                'email_ibu' => 'ibu' . $i . '@example.com',
                'kerja_ibu' => 'Ibu Rumah Tangga',
                'wali' => 'Wali ' . $i,
                'email_wali' => 'wali' . $i . '@example.com',
                'kerja_wali' => 'Wiraswasta',
                'tb' => rand(150, 170), // Tinggi badan acak
                'bb' => rand(40, 60), // Berat badan acak
                'kks' => 'KKS12345' . $i,
                'kph' => 'KPH12345' . $i,
                'kip' => 'KIP12345' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
