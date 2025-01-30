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
use App\Http\Controllers\AttendanceSettingController;
use App\Http\Controllers\ScheduleTemplateController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiSiswaController;

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

Route::get('api/get-kelas/{sekolah_id}', [DataSiswaController::class, 'getKelasBySekolah'])->name('api.kelas.by.sekolah');
    Route::resource('kelas', KelasController::class);

    Route::prefix('pengaturan-absensi')->name('pengaturan-absensi.')->group(function () {
        Route::get('/', [PengaturanAbsensiController::class, 'index'])->name('index');
        Route::get('/create', [PengaturanAbsensiController::class, 'create'])->name('create');
        Route::post('/', [PengaturanAbsensiController::class, 'store'])->name('store');
        Route::get('/{sekolahId}', [PengaturanAbsensiController::class, 'show'])->name('show');
        Route::get('/{sekolahId}/edit', [PengaturanAbsensiController::class, 'edit'])->name('edit');
        Route::put('/{sekolahId}', [PengaturanAbsensiController::class, 'update'])->name('update');
        Route::delete('/{sekolahId}', [PengaturanAbsensiController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('attendance')->name('attendance.')->group(function () {
        // Dashboard & Scan Routes
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/scan', [AttendanceController::class, 'scan'])->name('scan');
        Route::post('/process', [AttendanceController::class, 'process'])->name('process');
        Route::get('/report', [AttendanceController::class, 'report'])->name('report');
        
        // Settings Routes
        Route::get('/settings', [AttendanceSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AttendanceSettingController::class, 'store'])->name('settings.store');
    });

    // Face Data Routes
    Route::prefix('face')->name('face.')->group(function () {
        Route::get('/', [FaceDataController::class, 'index'])->name('index');
        Route::get('/create/{student}', [FaceDataController::class, 'create'])->name('create');
        Route::post('/store/{student}', [FaceDataController::class, 'store'])->name('store');
        Route::delete('/{faceData}', [FaceDataController::class, 'destroy'])->name('destroy');
    });

    // Schedule Template Routes
    Route::prefix('schedule')->name('schedule.')->group(function () {
        Route::get('/', [ScheduleTemplateController::class, 'index'])->name('index');
        Route::get('/create', [ScheduleTemplateController::class, 'create'])->name('create');
        Route::post('/', [ScheduleTemplateController::class, 'store'])->name('store');
        Route::get('/{template}/edit', [ScheduleTemplateController::class, 'edit'])->name('edit');
        Route::put('/{template}', [ScheduleTemplateController::class, 'update'])->name('update');
        Route::delete('/{template}', [ScheduleTemplateController::class, 'destroy'])->name('destroy');
    });

    // Holiday Routes
    Route::prefix('holiday')->name('holiday.')->group(function () {
        Route::get('/', [HolidayController::class, 'index'])->name('index');
        Route::get('/create', [HolidayController::class, 'create'])->name('create');
        Route::post('/', [HolidayController::class, 'store'])->name('store');
        Route::get('/{holiday}/edit', [HolidayController::class, 'edit'])->name('edit');
        Route::put('/{holiday}', [HolidayController::class, 'update'])->name('update');
        Route::delete('/{holiday}', [HolidayController::class, 'destroy'])->name('destroy');
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
