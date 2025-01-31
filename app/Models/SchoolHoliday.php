<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolHoliday extends Model
{
    protected $fillable = [
        'sekolah_id',
        'tanggal',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}