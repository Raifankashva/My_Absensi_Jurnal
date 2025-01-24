<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAbsensi extends Model
{
    protected $table = 'jadwal_absensi';
    
    protected $fillable = [
        'sekolah_id', 'hari', 'status', 'keterangan'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}