<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalPelajaran;

class DataGuru extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_guru';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'sekolah_id',
        'nip',
        'nuptk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'status_kepegawaian',
        'pendidikan_terakhir',
        'jurusan_pendidikan',
        'alamat',
        'no_hp',
        'tmt_kerja',
        'mata_pelajaran',
        'foto', 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'mata_pelajaran' => 'array',
        'tanggal_lahir' => 'date',
        'tmt_kerja' => 'date',
    ];

    /**
     * Get the associated User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the associated Sekolah.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * Scope to get DataGuru by user with role 'guru'.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByGuruRole($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('role', 'guru');
        });
    }
    public function jadwalPelajaran()
{
    return $this->hasMany(JadwalPelajaran::class, 'guru_id');
}public function jurnalGuru()
{
    return $this->hasMany(JurnalGuru::class, 'guru_id');
}

}
