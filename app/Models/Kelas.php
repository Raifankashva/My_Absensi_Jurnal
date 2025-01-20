<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kelas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sekolah_id',
        'nama_kelas',
        'tingkat',
        'jurusan',
        'kapasitas',
        'tahun_ajaran',
        'semester',
        'wali_kelas',
    ];

    /**
     * Get the associated Sekolah.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    
}
