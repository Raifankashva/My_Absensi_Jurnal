<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'sekolah_id',
        'nama',
        'kode',
        'kapasitas',
        'lokasi',
        'keterangan',
    ];

    /**
     * Relasi ke model Sekolah.
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * Relasi ke JadwalPelajaran.
     */
    public function jadwalPelajarans()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }
    public function photos()
    {
        return $this->hasMany(RuanganPhoto::class);
    }
}
