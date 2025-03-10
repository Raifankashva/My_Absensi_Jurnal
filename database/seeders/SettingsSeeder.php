<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettingAbsensi;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all schools
        $sekolahList = Sekolah::all();
        
        // Create global admin password
        SettingAbsensi::create([
            'sekolah_id' => $sekolahList->first()->id, // Assign to first school for management
            'key' => 'admin_password',
            'value' => Hash::make('admin123'), // Default password, should be changed immediately
            'description' => 'Password for administrative functions like token management'
        ]);
        
        // Create a unique token for each school
        foreach ($sekolahList as $sekolah) {
            // Create scan token for each school
            SettingAbsensi::create([
                'sekolah_id' => $sekolah->id,
                'key' => 'scan_access_token',
                'value' => 'absensi_' . $sekolah->id . '_' . Str::random(8),
                'description' => 'Token untuk akses fitur scan QR absensi sekolah ' . $sekolah->nama
            ]);
            
            // Set jam masuk and batas_terlambat for each school if not exists
            if (!SettingAbsensi::where('sekolah_id', $sekolah->id)->where('key', 'jam_masuk')->exists()) {
                SettingAbsensi::create([
                    'sekolah_id' => $sekolah->id,
                    'key' => 'jam_masuk',
                    'value' => '07:30:00',
                    'description' => 'Jam masuk sekolah'
                ]);
            }
            
            if (!SettingAbsensi::where('sekolah_id', $sekolah->id)->where('key', 'batas_terlambat')->exists()) {
                SettingAbsensi::create([
                    'sekolah_id' => $sekolah->id,
                    'key' => 'batas_terlambat',
                    'value' => '08:00:00',
                    'description' => 'Batas waktu terlambat'
                ]);
            }
        }
    }
}