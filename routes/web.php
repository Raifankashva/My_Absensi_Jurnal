<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolRegistrationController;
use App\Http\Controllers\SchoolManagementController;
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
use App\Http\Controllers\KelasSekolahController;
use App\Http\Controllers\AbsensiPelajaranController;
use App\Http\Controllers\SiswaImportController;
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

// Authentication routes

// School registration routes
Route::get('/school/register', [SchoolRegistrationController::class, 'showRegistrationForm'])->name('school.register');
Route::post('/school/register', [SchoolRegistrationController::class, 'register']);

// OTP verification routes
Route::get('/verify-otp', [SchoolRegistrationController::class, 'showOtpForm'])->name('verification.notice');
Route::post('/verify-otp', [SchoolRegistrationController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/resend-otp', [SchoolRegistrationController::class, 'resendOtp'])->name('resend.otp');

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

    Route::get('/schools', [SchoolManagementController::class, 'index'])->name('schools.index');
    Route::get('/schools/{school}', [SchoolManagementController::class, 'show'])->name('schools.show');
    Route::patch('/schools/{school}/toggle-activation', [SchoolManagementController::class, 'toggleActivation'])->name('schools.toggle-activation');

 
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
    Route::get('/profile', [App\Http\Controllers\GuruProfileController::class, 'show'])->name('guru.profile');
    Route::get('/profile/edit', [App\Http\Controllers\GuruProfileController::class, 'edit'])->name('guru.profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\GuruProfileController::class, 'update'])->name('guru.profile.update');
    // Rute untuk laporan jurnal
    Route::get('/jurnal-guru/laporan', [JurnalGuruController::class, 'laporanJurnal'])->name('jurnal-guru.laporan');

});

// Routes untuk Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index'); // Menampilkan halaman riwayat absensi
    Route::get('/siswa/jadwal', [SiswaController::class, 'jadwal'])->name('siswa.jadwal');
    Route::get('/siswa/kartu-pelajar', [SiswaController::class, 'generateStudentCard'])->name('siswa.kartu-pelajar');
    Route::get('/profile', [SiswaController::class, 'profile'])->name('siswa.profile');
    Route::post('/profile/update', [SiswaController::class, 'updateProfile'])->name('siswa.profile.update');

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

Route::get('/kelas', [KelasSekolahController::class, 'index'])->name('kelassekolah.index');
    Route::get('/kelas/create', [KelasSekolahController::class, 'create'])->name('kelassekolah.create');
    Route::post('/kelas', [KelasSekolahController::class, 'store'])->name('kelassekolah.store');
    Route::get('/kelas/{id}', [KelasSekolahController::class, 'show'])->name('kelassekolah.show');
    Route::get('/kelas/{id}/edit', [KelasSekolahController::class, 'edit'])->name('kelassekolah.edit');
    Route::put('/kelas/{id}', [KelasSekolahController::class, 'update'])->name('kelassekolah.update');
    Route::delete('/kelas/{id}', [KelasSekolahController::class, 'destroy'])->name('kelassekolah.destroy');

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

    Route::get('get-kelas/{sekolahId}', [DataSiswaController::class, 'getKelas'])->name('get.kelas');
    Route::get('get-cities/{provinceId}', [DataSiswaController::class, 'getCities'])->name('get.cities');
    Route::get('get-districts/{cityId}', [DataSiswaController::class, 'getDistricts'])->name('get.districts');
    Route::get('get-villages/{districtId}', [DataSiswaController::class, 'getVillages'])->name('get.villages');
    Route::post('download-qrcode', [DataSiswaController::class, 'downloadQRCodes'])->name('download.download');
    Route::get('download-qrcode/{id}', [DataSiswaController::class, 'downloadQRCode'])->name('adminsiswa.download-qrcode');

    Route::prefix('jadwal-pelajaran')->name('jadwal-pelajaran.')->group(function () {
        Route::get('/', [JadwalPelajaranController::class, 'index'])->name('index');
        Route::get('/create', [JadwalPelajaranController::class, 'create'])->name('create');
        Route::post('/', [JadwalPelajaranController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [JadwalPelajaranController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JadwalPelajaranController::class, 'update'])->name('update');
        Route::delete('/{id}', [JadwalPelajaranController::class, 'destroy'])->name('destroy');
        
        // Additional AJAX routes
        Route::get('/jadwal-guru/{guruId}', [JadwalPelajaranController::class, 'getJadwalByGuru'])->name('jadwal-guru');
        Route::get('/jadwal-hari-ini/{guruId}', [JadwalPelajaranController::class, 'getJadwalHariIni'])->name('jadwal-hari-ini');
        Route::post('/check-bentrok', [JadwalPelajaranController::class, 'checkJadwalBentrok'])->name('check-bentrok');
    });
    Route::get('/absensi/export-pdf', [AbsensiController::class, 'exportPDF'])->name('absensi.exportPDF');
    Route::get('/absensi/export-excel', [AbsensiController::class, 'exportExcel'])->name('absensi.exportExcel');
// Add these routes to your web.php routes file
Route::get('/absensi/export-periode-pdf', [AbsensiController::class, 'exportPeriodePDF'])->name('absensi.exportPeriodePDF');
Route::get('/absensi/export-periode-excel', [AbsensiController::class, 'exportPeriodeExcel'])->name('absensi.exportPeriodeExcel');
});
Route::get('/jurnal-guru/laporan-absensi', [JurnalGuruController::class, 'laporanAbsensi'])->name('absensi.laporan');


// Absensi Pelajaran Routes
Route::prefix('absensi-pelajaran')->name('absensi.pelajaran.')->middleware(['auth'])->group(function () {
    // View today's schedules
    Route::get('/jadwal-hari-ini', [App\Http\Controllers\AbsensiPelajaranController::class, 'jadwalHariIni'])
        ->name('jadwal-hari-ini');
        
    // Form to fill attendance
    Route::get('/isi', [App\Http\Controllers\AbsensiPelajaranController::class, 'index'])
        ->name('index');
        
    // Store attendance
    Route::post('/store', [App\Http\Controllers\AbsensiPelajaranController::class, 'store'])
        ->name('store');
        
    // View specific attendance
    Route::get('/show/{jadwal_id}/{tanggal?}', [App\Http\Controllers\AbsensiPelajaranController::class, 'showBySubject'])
        ->name('show');
        
    // Attendance reports
    Route::get('/laporan', [App\Http\Controllers\AbsensiPelajaranController::class, 'report'])
        ->name('report');
});

// API endpoint for filtering jadwal by kelas (used in the report page)
Route::get('/api/jadwal-by-kelas/{kelas_id}', function ($kelasId) {
    $jadwalList = App\Models\JadwalPelajaran::where('kelas_id', $kelasId)
        ->where('is_active', true)
        ->get();
        
    return response()->json($jadwalList);
});

Route::get('/siswa/import', [SiswaImportController::class, 'index'])->name('siswa.import');
    Route::post('/siswa/import', [SiswaImportController::class, 'import'])->name('siswa.import');
    Route::get('/siswa/download-template', [SiswaImportController::class, 'downloadTemplate'])->name('siswa.download-template');