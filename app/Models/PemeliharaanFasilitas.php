<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeliharaanFasilitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'fasilitas_sekolah_id',
        'tanggal_pemeliharaan',
        'jenis_pemeliharaan',
        'status',
        'deskripsi',
    ];

    // Relasi ke tabel fasilitas_sekolah
    public function fasilitasSekolah()
    {
        return $this->belongsTo(FasilitasSekolah::class);
    }
}
