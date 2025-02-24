<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['sekolah_id', 'jam_masuk', 'batas_terlambat'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
