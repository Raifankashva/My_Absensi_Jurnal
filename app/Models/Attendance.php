<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'siswa_id',
        'setting_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function setting()
    {
        return $this->belongsTo(AttendanceSetting::class, 'setting_id');
    }
}