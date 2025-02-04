<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\DataGuruController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\KelasController;
use App\Models\DataSiswa;
use App\Http\Controllers\PengaturanAbsensiController;
use App\Http\Controllers\JadwalAbsensiController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\FaceDataController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceSettingsController;
use App\Http\Controllers\ScheduleTemplateController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiSiswaController;
use App\Http\Controllers\SchoolAttendanceSettingController;
use App\Http\Controllers\SchoolHolidayController;
use Dflydev\DotAccessData\Data;


Route::get('getcities/{province}', [SekolahController::class, 'getCities']);
Route::get('getdistricts/{city}', [SekolahController::class, 'getDistricts']);
Route::get('getvillages/{district}', [SekolahController::class, 'getVillages']);
Route::get('get-kelas/{sekolahId}', [DataSiswaController::class, 'getKelas']);
Route::get('get-cities/{provinceId}', [DataSiswaController::class, 'getCities']);
Route::get('get-districts/{cityId}', [DataSiswaController::class, 'getDistricts']);
Route::get('get-villages/{districtId}', [DataSiswaController::class, 'getVillages']);
// Route untuk dropdown dinamis wilayah
Route::get('/get-cities', [SekolahController::class, 'getCities'])->name('get.cities');
Route::get('/get-districts', [SekolahController::class, 'getDistricts'])->name('get.districts');
Route::get('/get-villages', [SekolahController::class, 'getVillages'])->name('get.villages');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('sekolahs', SekolahController::class);

    Route::resource('adminguru', DataGuruController::class);
    Route::resource('adminsiswa', DataSiswaController::class);
    Route::get('/siswa/{id}/download-qr', [DataSiswaController::class, 'downloadQrCode'])->name('siswa.download-qr');
    Route::get('adminsiswa/{id}/download-qr', [DataSiswaController::class, 'downloadQRCode'])
    ->name('adminsiswa.download-qr');
Route::get('api/get-kelas/{sekolah_id}', [DataSiswaController::class, 'getKelasBySekolah'])->name('api.kelas.by.sekolah');
    Route::resource('kelas', KelasController::class);

Route::get('/siswa/export', [DataSiswaController::class, 'export'])->name('siswa.export');
Route::post('/admin/siswa/download-qrcodes', [DataSiswaController::class, 'downloadSelectedQRCodes'])
    ->name('adminsiswa.download-qrcodes');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/attendance/manual-check-in', [AttendanceController::class, 'manualCheckIn'])->name('attendance.manual-check-in');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
    Route::get('/attendance/{id}/detail', [AttendanceController::class, 'getAttendanceDetail']);
    Route::post('/attendance/{id}/validate', [AttendanceController::class, 'validateAttendance']);
    Route::get('/attendance/summary', [AttendanceController::class, 'getSummary']);
    Route::get('/attendance/export/pdf', [AttendanceController::class, 'exportPdf'])->name('attendance.export.pdf');
    Route::get('/attendance/export/excel', [AttendanceController::class, 'exportExcel'])->name('attendance.export.excel');
    Route::prefix('attendance/settings')->name('attendance.settings.')->middleware(['web', 'auth'])->group(function () {
        // Display attendance settings form
        Route::get('/', [AttendanceSettingsController::class, 'index'])
            ->name('index');
    
        // Update attendance settings
        Route::put('/update', [AttendanceSettingsController::class, 'update'])
            ->name('update');
    
        // Generate new attendance token (can be a POST or GET route depending on your preference)
        Route::post('/generate-token', [AttendanceSettingsController::class, 'generateToken'])
            ->name('generate.token');
    
        // Deactivate attendance settings
        Route::post('/deactivate', [AttendanceSettingsController::class, 'deactivate'])
            ->name('deactivate');
            
    });
    Route::prefix('attendance')->name('attendance.')->middleware(['web', 'auth'])->group(function () {
        // Token entry routes
        Route::get('/token', [AttendanceController::class, 'showTokenForm'])
            ->name('token');
        
        Route::post('/validate-token', [AttendanceController::class, 'validateToken'])
            ->name('validate.token');
        
        // Scanning route
        Route::get('/scan', [AttendanceController::class, 'scanAttendance'])
            ->name('scan');
    });
});

// Routes untuk Guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('guru.dashboard');
});

// Routes untuk Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});

// Routes untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Routes untuk Guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
});

// Routes untuk Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
