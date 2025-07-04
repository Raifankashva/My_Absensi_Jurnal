<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataGuruController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaturanAbsensiController;
use App\Http\Controllers\JadwalAbsensiController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\API\RegionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\API\SettingDailyApiController;

Route::get('settings/daily/{sekolahId}', [SettingDailyApiController::class, 'getSettingsBySchool']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
use App\Http\Controllers\API\AbsensiController;

Route::middleware(['auth:sanctum', 'check.sekolah'])->group(function () {
    Route::post('/absensi/check-in', [AbsensiController::class, 'checkIn']);
    Route::post('/absensi/check-out', [AbsensiController::class, 'checkOut']);

    Route::get('/jadwal-pelajaran/guru/{guruId}', [JadwalPelajaranController::class, 'getJadwalByGuru']);
    Route::get('/jadwal-pelajaran/hari-ini/{guruId}', [JadwalPelajaranController::class, 'getJadwalHariIni']);
});
Route::get('/cities/{province}', [RegionController::class, 'getCities']);
Route::get('/districts/{city}', [RegionController::class, 'getDistricts']);
Route::get('/villages/{district}', [RegionController::class, 'getVillages']);