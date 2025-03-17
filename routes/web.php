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
use App\Http\Controllers\AbsensiController;
use App\Models\DataSiswa;
use App\Http\Controllers\JurnalGuruController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SchoolDashboardController;
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
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

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

    Route::prefix('adminguru')->name('adminguru.')->group(function () {
        Route::get('/', [DataGuruController::class, 'index'])->name('index');
        Route::get('/create', [DataGuruController::class, 'create'])->name('create');
        Route::post('/store', [DataGuruController::class, 'store'])->name('store');
        Route::get('/{guru}', [DataGuruController::class, 'show'])->name('show');
        Route::get('/{guru}/edit', [DataGuruController::class, 'edit'])->name('edit');
        Route::put('/{guru}', [DataGuruController::class, 'update'])->name('update');
        Route::delete('/{guru}', [DataGuruController::class, 'destroy'])->name('destroy');
    });
        Route::get('adminguru/{guru}/detail', [DataGuruController::class, 'show'])->name('adminguru.detail');

    Route::resource('adminsiswa', DataSiswaController::class);
    Route::get('/siswa/{id}/download-qr', [DataSiswaController::class, 'downloadQrCode'])->name('siswa.download-qr');
    Route::get('adminsiswa/{id}/download-qr', [DataSiswaController::class, 'downloadQRCode'])->name('adminsiswa.download-qr');
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
    Route::post('adminsiswa/download-qrcodes', [DataSiswaController::class, 'downloadQRCodes'])->name('adminsiswa.download-qrcodes');

    Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])->name('jadwal-pelajaran.index');
    Route::get('/jadwal-pelajaran/create', [JadwalPelajaranController::class, 'create'])->name('jadwal-pelajaran.create');
    Route::post('/jadwal-pelajaran', [JadwalPelajaranController::class, 'store'])->name('jadwal-pelajaran.store');
    Route::get('/jadwal-pelajaran/{id}/edit', [JadwalPelajaranController::class, 'edit'])->name('jadwal-pelajaran.edit');
    Route::put('/jadwal-pelajaran/{id}', [JadwalPelajaranController::class, 'update'])->name('jadwal-pelajaran.update');
    Route::delete('/jadwal-pelajaran/{id}', [JadwalPelajaranController::class, 'destroy'])->name('jadwal-pelajaran.destroy');

    // API routes for fetching schedule data
    Route::get('/jadwal-pelajaran/guru/{guruId}', [JadwalPelajaranController::class, 'getJadwalByGuru'])->name('jadwal-pelajaran.by-guru');
    Route::get('/jadwal-pelajaran/hari-ini/{guruId}', [JadwalPelajaranController::class, 'getJadwalHariIni'])->name('jadwal-pelajaran.hari-ini');
    Route::post('/check-jadwal-bentrok', [JadwalPelajaranController::class, 'checkJadwalBentrok']);
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
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index'); // Menampilkan halaman riwayat absensi
    Route::get('/siswa/jadwal', [SiswaController::class, 'jadwal'])->name('siswa.jadwal');
    Route::get('/siswa/kartu-pelajar', [SiswaController::class, 'generateStudentCard'])->name('siswa.kartu-pelajar');

});

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance/settings', [AttendanceController::class, 'settings'])->name('attendance.settings');
    Route::put('/attendance/settings/{setting}', [AttendanceController::class, 'updateSettings'])->name('attendance.settings.update');
    Route::get('/attendance/qrcode/{siswa}', [AttendanceController::class, 'generateQrCode'])->name('attendance.qrcode');
    Route::post('/attendance/scan', [AttendanceController::class, 'scanQrCode'])->name('attendance.scan');
});

use App\Http\Controllers\SettingController;

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');



// Data Siswa routes
Route::get('/siswa/{id}/qr', [DataSiswaController::class, 'showQR'])->name('siswa.qr');

// Absensi routes
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::get('/absensi/scan', [AbsensiController::class, 'scanQR'])->name('absensi.scan');
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

Route::post('/admin/siswa/import', [DataSiswaController::class, 'storeFromExcel'])->name('adminsiswa.import');

Route::prefix('admin/siswa')->name('adminsiswa.')->group(function () {
    Route::get('/', [DataSiswaController::class, 'index'])->name('index');
    Route::get('/import', [DataSiswaController::class, 'showImportForm'])->name('import');
    Route::post('/import', [DataSiswaController::class, 'import'])->name('import.process');
    Route::get('/import/results', [DataSiswaController::class, 'showImportResults'])->name('import.results');
    Route::get('/download-template', [DataSiswaController::class, 'downloadTemplate'])->name('template');
    Route::get('/export-credentials', [DataSiswaController::class, 'exportCredentials'])->name('export.credentials');
});

// Absensi token routes
Route::get('/absensi/scan/auth', [AbsensiController::class, 'scanAuth'])->name('absensi.scan.auth');
Route::get('/absensi/token/management', [AbsensiController::class, 'tokenManagement'])->name('absensi.token.management');
Route::post('/absensi/token/create', [AbsensiController::class, 'createToken'])->name('absensi.token.create');
Route::post('/absensi/token/update', [AbsensiController::class, 'updateToken'])->name('absensi.token.update');
Route::get('/absensi/select-school', [AbsensiController::class, 'selectSchool'])->name('absensi.select.school');
Route::get('/absensi/scan/logout', [AbsensiController::class, 'logoutScan'])->name('absensi.scan.logout');
Route::get('/absensi/token/logout', [AbsensiController::class, 'logoutTokenManagement'])->name('absensi.token.logout');

Route::middleware(['auth', 'role:sekolah'])->prefix('sekolah')->group(function () {

// Dashboard
Route::get('/dashboard', [SchoolDashboardController::class, 'index'])->name('school.dashboard');
        
// Class routes
Route::get('/classes', [SchoolDashboardController::class, 'indexClasses'])->name('school.classes');
Route::get('/classes/capacity', [SchoolDashboardController::class, 'classCapacity'])->name('school.classes.capacity');
Route::get('/class/{id}', [SchoolDashboardController::class, 'showClass'])->name('class.show');

// Student routes
Route::get('/students', [SchoolDashboardController::class, 'indexStudents'])->name('school.students');
Route::get('/student/{id}', [SchoolDashboardController::class, 'showStudent'])->name('school.student.show');

// Teacher routes
Route::get('/teachers', [SchoolDashboardController::class, 'indexTeachers'])->name('school.teachers');
Route::get('/teacher/{id}', [SchoolDashboardController::class, 'showTeacher'])->name('school.teacher.show');

Route::get('/kelass', [KelasController::class, 'indexBySchool'])->name('school.kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'createBySchool'])->name('school.kelas.create');
    Route::post('/kelas', [KelasController::class, 'storeBySchool'])->name('school.kelas.store');
    Route::get('/kelas/{kelas}', [KelasController::class, 'showBySchool'])->name('school.kelas.show');
    Route::get('/kelas/{kelas}/edit', [KelasController::class, 'editBySchool'])->name('school.kelas.edit');
    Route::put('/kelas/{kelas}', [KelasController::class, 'updateBySchool'])->name('school.kelas.update');
    Route::delete('/kelas/{kelas}', [KelasController::class, 'destroyBySchool'])->name('school.kelas.destroy');
});