<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

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
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function jadwalPelajaran()
    {
        return $this->hasManyThrough(
            JadwalPelajaran::class,
            Kelas::class,
            'id', // Foreign key on kelas table
            'kelas_id', // Foreign key on jadwal_pelajaran table
            'kelas_id', // Local key on data_siswa table
            'id' // Local key on kelas table
        );
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
    public function downloadQRCodes()
    {
        // Pastikan ID siswa tersedia
        if (!$this->id) {
            throw new \Exception("ID Siswa tidak ditemukan.");
        }
    
        // Generate QR code dengan ID siswa
        $qrCode = QrCode::format('png')->size(300)->generate((string) $this->id);
        $fileName = "qrcodes/siswa_{$this->id}.png";
    
        // Simpan QR Code ke dalam storage
        Storage::put($fileName, $qrCode);
    
        // Download file QR Code
        return response()->download(storage_path("app/$fileName"));
    }
    public function absensi()
{
    return $this->hasMany(Absensi::class, 'siswa_id');
}

}