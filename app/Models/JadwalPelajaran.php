<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;
    
    protected $table = 'jadwal_pelajaran';
    
    protected $fillable = [
        'kelas_id',
        'guru_id',
        'mata_pelajaran',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan_id'
    ];
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    
    public function guru()
    {
        return $this->belongsTo(DataGuru::class, 'guru_id');
    }
    
    public function jurnalGuru()
    {
        return $this->hasMany(JurnalGuru::class);
    }
    // Add this to your JadwalPelajaran model
public function ruangan()
{
    return $this->belongsTo(Ruangan::class);
}
}