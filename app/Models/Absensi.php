<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'waktu_scan', 'status','key', 'value', 'description', 'sekolah_id'];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }
}
