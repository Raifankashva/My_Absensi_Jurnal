<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SettingDaily;
use Illuminate\Http\Request;

class SettingDailyApiController extends Controller
{
    /**
     * Ambil pengaturan jadwal harian berdasarkan sekolah
     */
    public function getSettingsBySchool($sekolahId)
    {
        $settings = SettingDaily::where('sekolah_id', $sekolahId)->get();
        
        return response()->json($settings);
    }
}