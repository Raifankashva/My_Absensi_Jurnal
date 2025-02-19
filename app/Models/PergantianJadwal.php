<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PergantianJadwal extends Model
{
    protected $fillable = [
        'jadwal_id', 'guru_pengganti_id', 'tanggal_pengganti',
        'status', 'alasan', 'approved_at'
    ];

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'jadwal_id');
    }

    public function guruPengganti()
    {
        return $this->belongsTo(DataGuru::class, 'guru_pengganti_id');
    }
}
