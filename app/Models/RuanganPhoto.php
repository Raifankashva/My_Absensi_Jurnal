<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuanganPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruangan_id',
        'path',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
