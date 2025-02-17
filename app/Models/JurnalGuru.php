<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalGuru extends Model
{
    use HasFactory;
    
    protected $table = 'jurnal_guru';
    
    protected $fillable = [
        'jadwal_pelajaran_id',
        'guru_id',
        'kelas_id',
        'tanggal',
        'materi_yang_disampaikan',
        'catatan_pembelajaran',
        'jumlah_siswa_hadir',
        'jumlah_siswa_tidak_hadir',
        'data_siswa_tidak_hadir',
        'status_pertemuan',
    ];
    
    protected $casts = [
        'data_siswa_tidak_hadir' => 'array',
        'tanggal' => 'date',
    ];
    
    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }
    
    public function guru()
    {
        return $this->belongsTo(DataGuru::class, 'guru_id');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}