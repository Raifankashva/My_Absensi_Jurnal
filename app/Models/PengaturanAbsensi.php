<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanAbsensi extends Model
{
    protected $table = 'pengaturan_absensi';
    
    protected $fillable = [
        'sekolah_id', 'jam_masuk', 'jam_pulang', 'batas_terlambat', 'status'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}