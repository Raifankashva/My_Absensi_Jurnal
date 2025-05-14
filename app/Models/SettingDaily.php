<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingDaily extends Model
{
    use HasFactory;
    protected $table = 'settings_daily'; // <- ini solusinya

    protected $fillable = [
        'sekolah_id',
        'hari',
        'jam_masuk',
        'batas_terlambat',
        'jam_pulang',
        'is_active'
    ];

    public static function getDaysOfWeek()
    {
        return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    // Cek apakah tanggal tertentu aktif untuk absensi
    public static function isDateActive($sekolah_id, $date)
    {
        $date = \Carbon\Carbon::parse($date);
        $dayName = self::getDayNameIndonesian($date->dayOfWeek);
        
        // Cek apakah tanggal termasuk hari libur
        $isHoliday = \App\Models\HariLibur::where('sekolah_id', $sekolah_id)
            ->where('tanggal', $date->format('Y-m-d'))
            ->exists();
        
        if ($isHoliday) {
            return false;
        }
        
        // Cek pengaturan hari
        $setting = self::where('sekolah_id', $sekolah_id)
            ->where('hari', $dayName)
            ->first();
            
        return $setting ? $setting->is_active : false;
    }

    // Helper untuk mendapatkan nama hari dalam bahasa Indonesia
    public static function getDayNameIndonesian($dayOfWeek)
    {
        $days = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
        
        return $days[$dayOfWeek];
    }
}