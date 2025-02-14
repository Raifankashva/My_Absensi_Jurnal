<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamSekolah extends Model
{
    protected $fillable = [
        'sekolah_id',
        'jam_masuk',
        'jam_telat',
        'jam_pulang'
    ];

    protected $casts = [
        'jam_masuk' => 'datetime',
        'jam_telat' => 'datetime',
        'jam_pulang' => 'datetime'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}