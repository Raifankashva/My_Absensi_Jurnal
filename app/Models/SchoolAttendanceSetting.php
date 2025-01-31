<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAttendanceSetting extends Model
{
    protected $fillable = [
        'sekolah_id',
        'token',
        'jam_masuk',
        'batas_telat',
        'jam_pulang',
        'hari_aktif',
        'is_active'
    ];

    protected $casts = [
        'hari_aktif' => 'array',
        'is_active' => 'boolean'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}