<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    protected $fillable = [
        'sekolah_id',
        'jam_masuk',
        'batas_telat',
        'jam_pulang'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'setting_id');
    }
}
