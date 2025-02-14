<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalGuru extends Model
{
    use HasFactory;

    protected $table = 'jurnal_guru';
    
    protected $fillable = [
        'guru_id',
        'kelas_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'mata_pelajaran',
        'materi_pembelajaran',
        'catatan_kegiatan',
        'capaian_pembelajaran',
        'jumlah_siswa_hadir',
        'jumlah_siswa_tidak_hadir',
        'keterangan_ketidakhadiran',
        'rencana_pembelajaran_selanjutnya',
        'tanda_tangan',
        'status',
        'waktu_submit'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'waktu_submit' => 'datetime'
    ];

    // Relasi ke guru
    public function guru()
    {
        return $this->belongsTo(DataGuru::class, 'guru_id');
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Scope untuk mencari jurnal berdasarkan range tanggal
    public function scopeDateBetween($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }

    // Scope untuk mencari jurnal yang belum diverifikasi
    public function scopeUnverified($query)
    {
        return $query->where('status', 'submitted');
    }
}