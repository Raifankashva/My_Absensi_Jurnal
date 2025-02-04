<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    protected $fillable = [
        'sekolah_id', 
        'start_time', 
        'end_time', 
        'late_threshold',
        'is_active', 
        'attendance_token',
        'attendance_type'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}