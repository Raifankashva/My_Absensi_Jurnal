<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPelajaran extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'absensi_pelajaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'siswa_id',
        'jadwal_pelajaran_id',
        'tanggal',
        'status',
        'keterangan',
        'created_by'
    ];

    /**
     * Get the student associated with this attendance record.
     */
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    /**
     * Get the class schedule associated with this attendance record.
     */
    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'jadwal_pelajaran_id');
    }

    /**
     * Get the user who created this attendance record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}