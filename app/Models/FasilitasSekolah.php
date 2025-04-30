<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasSekolah extends Model
{
    use HasFactory;

    protected $table = 'fasilitas_sekolah';

    protected $fillable = [
        'sekolah_id',
        'nama_fasilitas',
        'kategori',
        'jumlah',
        'kondisi',
        'deskripsi',
        'foto_fasilitas',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
    public function riwayatPemeliharaan()
{
    return $this->hasMany(PemeliharaanFasilitas::class);
}

}
