<?php

namespace App\Models;

use Dflydev\DotAccessData\Data;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiSekolah extends Model
{
    use HasFactory;

    protected $table = 'prestasi_sekolah';

    protected $fillable = [
        'sekolah_id',
        'guru_id',
        'siswa_id',
        'nama_prestasi',
        'tingkat',
        'penyelenggara',
        'tahun',
        'deskripsi',
        'foto_prestasi',
    ];
    protected $casts = [
        'foto_prestasi' => 'array',
    ];
    
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function guru()
    {
        return $this->belongsTo(DataGuru::class);
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class);
    }
}
