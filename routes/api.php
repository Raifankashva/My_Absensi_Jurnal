<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaturanAbsensiController;
use App\Http\Controllers\JadwalAbsensiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('absensi')->group(function () {
    // Pengaturan Absensi
    Route::get('pengaturan/{sekolahId}', [PengaturanAbsensiController::class, 'show']);
    Route::post('pengaturan', [PengaturanAbsensiController::class, 'store']);
    Route::put('pengaturan/{sekolahId}', [PengaturanAbsensiController::class, 'update']);
    Route::delete('pengaturan/{sekolahId}', [PengaturanAbsensiController::class, 'destroy']);

    // Jadwal Absensi
    Route::get('jadwal/{sekolahId}', [JadwalAbsensiController::class, 'index']);
    Route::post('jadwal', [JadwalAbsensiController::class, 'store']);
    Route::put('jadwal/{id}', [JadwalAbsensiController::class, 'update']);
    Route::delete('jadwal/{id}', [JadwalAbsensiController::class, 'destroy']);
    Route::get('jadwal/libur/{sekolahId}', [JadwalAbsensiController::class, 'getHariLibur']);
});