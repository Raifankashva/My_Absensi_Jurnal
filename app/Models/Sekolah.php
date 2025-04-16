<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolahs';
    
    protected $fillable = [
        'user_id',
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
        'nip_kepala_sekolah',
        'foto',
        'total_siswa',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
    public function dataSiswa()
    {
        return $this->hasMany(DataSiswa::class);
    }

    // Method to update total student count
    public function updateTotalSiswa()
    {
        $this->total_siswa = $this->dataSiswa()->count();
        $this->save();
    }
}