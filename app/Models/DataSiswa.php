<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    use HasFactory;

    protected $table = 'data_siswa';
    
    protected $fillable = [
        'user_id',
        'sekolah_id',
        'kelas_id',
        'nisn',
        'nis',
        'nik',
        'nama',
        'foto',
        'jenis_kelamin',
        'tmp_lahir',
        'tgl_lahir',
        'agama',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'kode_pos',
        'tinggal',
        'transport',
        'hp',
        'ayah',
        'kerja_ayah',
        'ibu',
        'kerja_ibu',
        'wali',
        'kerja_wali',
        'tb',
        'bb',
        'kks',
        'kph',
        'kip'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(Regency::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}