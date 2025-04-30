<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'sekolah_id',
        'judul',
        'isi',
        'kategori',
        'tanggal_mulai',
        'tanggal_berakhir',
        'lampiran',
        'status',
    ];

    /**
     * Relasi ke model Sekolah
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
