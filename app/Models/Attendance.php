<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'siswa_id', 
        'sekolah_id', 
        'kelas_id',
        'attendance_date', 
        'check_in_time', 
        'check_out_time',
        'status', 
        'check_in_photo', 
        'check_out_photo',
        'keterangan',
        'is_validated'
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Scope to check if attendance is already recorded for the day
    public function scopeToday($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId)
                     ->whereDate('attendance_date', today());
    }

    // Method to determine attendance status
    public function determineStatus($checkInTime, $attendanceSetting)
    {
        $startTime = Carbon::parse($attendanceSetting->start_time);
        $lateThreshold = Carbon::parse($attendanceSetting->late_threshold);
        $checkIn = Carbon::parse($checkInTime);

        if ($checkIn->gt($lateThreshold)) {
            return 'terlambat';
        }

        return 'hadir';
    }
}