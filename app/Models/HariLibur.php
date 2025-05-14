<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    use HasFactory;
    protected $table = 'hari_libur'; // <- ini solusinya

    protected $fillable = [
        'sekolah_id',
        'tanggal',
        'keterangan'
    ];

    protected $dates = ['tanggal'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}