<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceEncoding extends Model
{
    protected $fillable = [
        'data_siswa_id',
        'encoding_data',
        'foto_referensi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'data_siswa_id');
    }
}