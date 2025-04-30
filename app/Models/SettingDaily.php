<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingDaily extends Model
{
    use HasFactory;

    protected $table = 'settings_daily';
    
    protected $fillable = [
        'sekolah_id',
        'hari',
        'jam_masuk',
        'batas_terlambat',
        'jam_pulang',
        'is_active'
    ];

    /**
     * Get the sekolah that owns this setting.
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
    
    /**
     * Daftar hari dalam seminggu
     */
    public static function getDaysOfWeek()
    {
        return [
            'Senin', 
            'Selasa', 
            'Rabu', 
            'Kamis', 
            'Jumat', 
            'Sabtu', 
            'Minggu'
        ];
    }
}