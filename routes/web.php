<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\DataGuruController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceSettingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PublicAttendanceController;
use App\Http\Controllers\API\AbsensiController;
use App\Models\DataSiswa;
use App\Http\Controllers\JurnalGuruController;
use App\Http\Controllers\JadwalPelajaranController;

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

Route::get('/public/attendance', [PublicAttendanceController::class, 'view'])
    ->name('attendance.public.view');
Route::get('/public/attendance/export', [PublicAttendanceController::class, 'export'])
    ->middleware('verify.school.token')
    ->name('attendance.public.export');

// Routes untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
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
    Route::get('/attendance/settings', [AttendanceSettingController::class, 'index'])
    ->name('attendance.settings');
Route::post('/attendance/settings', [AttendanceSettingController::class, 'store'])
    ->name('attendance.settings.store');

Route::get('/attendance', [AttendanceController::class, 'index'])
    ->name('attendance.index');
Route::get('/attendance/scan', [AttendanceController::class, 'scanPage'])
    ->name('attendance.scan');
Route::post('/attendance/process-qr', [AttendanceController::class, 'processQr'])
    ->name('attendance.process-qr');
Route::post('/attendance/manual', [AttendanceController::class, 'manualAttendance'])
    ->name('attendance.manual');

    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index'); // Menampilkan halaman riwayat absensi
    Route::post('adminsiswa/download-qrcodes', [DataSiswa::class, 'downloadQRCodes'])->name('adminsiswa.download-qrcodes');

    Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])->name('jadwal-pelajaran.index');
    Route::get('/jadwal-pelajaran/create', [JadwalPelajaranController::class, 'create'])->name('jadwal-pelajaran.create');
    Route::post('/jadwal-pelajaran', [JadwalPelajaranController::class, 'store'])->name('jadwal-pelajaran.store');
    Route::get('/jadwal-pelajaran/{id}/edit', [JadwalPelajaranController::class, 'edit'])->name('jadwal-pelajaran.edit');
    Route::put('/jadwal-pelajaran/{id}', [JadwalPelajaranController::class, 'update'])->name('jadwal-pelajaran.update');
    Route::delete('/jadwal-pelajaran/{id}', [JadwalPelajaranController::class, 'destroy'])->name('jadwal-pelajaran.destroy');

    // API routes for fetching schedule data
    Route::get('/jadwal-pelajaran/guru/{guruId}', [JadwalPelajaranController::class, 'getJadwalByGuru'])->name('jadwal-pelajaran.by-guru');
    Route::get('/jadwal-pelajaran/hari-ini/{guruId}', [JadwalPelajaranController::class, 'getJadwalHariIni'])->name('jadwal-pelajaran.hari-ini');

});

// Routes untuk Guru

Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/jurnal-guru', [JurnalGuruController::class, 'index'])->name('jurnal-guru.index');
    Route::get('/jurnal-guru/create', [JurnalGuruController::class, 'create'])->name('jurnal-guru.create');
    Route::post('/jurnal-guru', [JurnalGuruController::class, 'store'])->name('jurnal-guru.store');
    Route::get('/jurnal-guru/{id}', [JurnalGuruController::class, 'show'])->name('jurnal-guru.show');
    Route::get('/jurnal-guru/{id}/edit', [JurnalGuruController::class, 'edit'])->name('jurnal-guru.edit');
    Route::put('/jurnal-guru/{id}', [JurnalGuruController::class, 'update'])->name('jurnal-guru.update');
    Route::delete('/jurnal-guru/{id}', [JurnalGuruController::class, 'destroy'])->name('jurnal-guru.destroy');
    
    // Rute untuk laporan jurnal
    Route::get('/jurnal-guru/laporan', [JurnalGuruController::class, 'laporanJurnal'])->name('jurnal-guru.laporan');

});

// Routes untuk Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index'); // Menampilkan halaman riwayat absensi

});

Route::get('/', function () {
    return view('welcome');
});
