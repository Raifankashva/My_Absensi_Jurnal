<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataSiswa extends Model
{
    protected $table = 'data_siswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'sekolah_id',
        'kelas_id',
        'nisn',
        'nis',
        'nik',
        'nama_lengkap',
        'foto',
        'jenis_kelamin',
        'tmp_lahir',
        'tgl_lahir',
        'agama',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'kode_pos',
        'tinggal',
        'transport',
        'hp',
        'ayah',
        'kerja_ayah',
        'ibu',
        'kerja_ibu',
        'wali',
        'kerja_wali',
        'tb',
        'bb',
        'kks',
        'kph',
        'kip',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tgl_lahir' => 'date',
        'tb' => 'integer',
        'bb' => 'integer',
    ];

    /**
     * Get the user that owns the student data.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the school that the student belongs to.
     */
    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * Get the class that the student belongs to.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get the province that the student belongs to.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the city that the student belongs to.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'city_id');
    }

    /**
     * Get the district that the student belongs to.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the village that the student belongs to.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the student's full address.
     */
    public function getAddressAttribute(): string
    {
        return $this->village->name . ', ' . $this->district->name . ', ' . $this->city->name . ', ' . $this->province->name;
    }

    /**
     * Get the student's age.
     */
    public function getAgeAttribute(): int
    {
        return $this->tgl_lahir->age;
    }

    /**
     * Get the student's photo URL.
     */
    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}