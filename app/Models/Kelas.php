<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'sekolah_id',
        'nama_kelas',
        'tingkat',
        'jurusan',
        'kapasitas',
        'sisa_kapasitas',
        'tahun_ajaran',
        'semester',
        'wali_kelas',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function siswa()
    {
        return $this->hasMany(DataSiswa::class);
    }

    // Method to update remaining capacity
    public function updateRemainingCapacity()
    {
        $this->sisa_kapasitas = $this->kapasitas - $this->siswa()->count();
        $this->save();
    }
    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'kelas_id', 'id');
    }
}