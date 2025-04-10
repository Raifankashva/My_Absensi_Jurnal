<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'no_hp',
        'role',
        'is_active',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Get the sekolah associated with the user.
     */
    public function sekolah()
    {
        return $this->hasOne(Sekolah::class);
    }

    /**
     * Get OTP verifications for the user.
     */
    public function otpVerifications()
    {
        return $this->hasMany(OtpVerification::class);
    }

 

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }
    public function dataSiswa()
    {
        return $this->hasOne(DataSiswa::class);
    }
    public function tasks()
{
    return $this->hasMany(Task::class);
}
public function guru()
    {
        return $this->hasOne(DataGuru::class, 'user_id');
    }
}