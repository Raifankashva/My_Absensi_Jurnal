<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolahs';
    
    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'jenjang',
        'status',
        'alamat',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'kode_pos',
        'no_telp',
        'email',
        'website',
        'akreditasi',
        'kepala_sekolah',
        'nip_kepala_sekolah'
    ];

    // Relationships with IndoRegion
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(Regency::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}