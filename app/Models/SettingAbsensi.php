<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingAbsensi extends Model
{
    use HasFactory;

    protected $table = 'setting_absensi';
    
    protected $fillable = [
        'sekolah_id',
        'key',
        'value',
        'description'
    ];

    /**
     * Get the school that owns the setting.
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * Get a setting by key for a specific school
     *
     * @param int $sekolahId
     * @param string $key
     * @return mixed
     */
    public static function getBySchoolAndKey($sekolahId, $key)
    {
        $setting = self::where('sekolah_id', $sekolahId)
                      ->where('key', $key)
                      ->first();
        return $setting ? $setting->value : null;
    }

    /**
     * Set a setting by key for a specific school
     *
     * @param int $sekolahId
     * @param string $key
     * @param mixed $value
     * @param string|null $description
     * @return bool
     */
    public static function setForSchool($sekolahId, $key, $value, $description = null)
    {
        $setting = self::where('sekolah_id', $sekolahId)
                      ->where('key', $key)
                      ->first();
        
        if ($setting) {
            $setting->value = $value;
            if ($description) {
                $setting->description = $description;
            }
            return $setting->save();
        } else {
            return self::create([
                'sekolah_id' => $sekolahId,
                'key' => $key,
                'value' => $value,
                'description' => $description
            ]) ? true : false;
        }
    }
}