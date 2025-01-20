<?php

// app/Models/Sekolah.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolahs';

    protected $fillable = [
        'npsn', 'nama_sekolah', 'jenjang', 'status', 'alamat', 
        'kelurahan_id', 'kecamatan_id', 'kota_id', 'provinsi_id', 
        'kode_pos', 'no_telp', 'email', 'website', 'akreditasi', 
        'kepala_sekolah', 'nip_kepala_sekolah',
    ];

    protected $casts = [
        'jenjang' => 'string',
        'status' => 'string',
        'akreditasi' => 'string',
    ];

    /**
     * Relasi dengan Provinsi.
     */
    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'provinsi_id'); // Sesuaikan dengan foreign key
    }

    /**
     * Relasi dengan Kota.
     */
    public function kota()
    {
        return $this->belongsTo(Regency::class, 'kota_id'); // Sesuaikan dengan foreign key
    }

    /**
     * Relasi dengan Kecamatan.
     */
    public function kecamatan()
    {
        return $this->belongsTo(District::class, 'kecamatan_id'); // Sesuaikan dengan foreign key
    }

    /**
     * Relasi dengan Kelurahan.
     */
    public function kelurahan()
    {
        return $this->belongsTo(Village::class, 'kelurahan_id'); // Sesuaikan dengan foreign key
    }
}
