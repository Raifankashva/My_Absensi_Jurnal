<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleTemplate extends Model
{
    protected $fillable = [
        'sekolah_id',
        'nama_template',
        'senin',
        'selasa',
        'rabu',
        'kamis',
        'jumat',
        'sabtu',
        'minggu'
    ];

    protected $casts = [
        'senin' => 'boolean',
        'selasa' => 'boolean',
        'rabu' => 'boolean',
        'kamis' => 'boolean',
        'jumat' => 'boolean',
        'sabtu' => 'boolean',
        'minggu' => 'boolean',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
