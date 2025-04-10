<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp',
        'expired_at',
        'verified_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the OTP verification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}