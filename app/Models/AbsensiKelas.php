<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiKelas extends Model
{
    protected $table = 'absensi_kelas';

    protected $fillable = [
        'kelas_id',
        'jadwal_pelajaran_id',
        'guru_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'total_siswa',
        'siswa_hadir',
        'siswa_tidak_hadir',
        'siswa_terlambat',
        'status_kelas',
        'catatan'
    ];

    protected $dates = ['tanggal'];

    // Relationships
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'jadwal_pelajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(DataGuru::class, 'guru_id');
    }

    // Scope to get recent class attendances
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('tanggal', '>=', now()->subDays($days));
    }

    // Calculate attendance percentage
    public function getAttendancePercentageAttribute()
    {
        if ($this->total_siswa == 0) {
            return 0;
        }
        
        return round(($this->siswa_hadir / $this->total_siswa) * 100, 2);
    }
}