<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\DataSiswa;
use App\Models\Setting;
use App\Models\Sekolah;
use App\Models\Kelas;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use App\Models\SettingAbsensi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbsensiNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\SettingDaily;

class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    private function getAuthenticatedSchool()
    {
        return Sekolah::where('user_id', Auth::id())->first();
    }
    
    public function index(Request $request)
    {
        $authSchool = $this->getAuthenticatedSchool();
        
        if (!$authSchool) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        
        $sekolah_id = $authSchool->id;
        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        
        
        $kelas = Kelas::where('sekolah_id', $sekolah_id)->get();
        
        // Get all attendance data for the selected date and school
        // We'll group by class in the view
        $absensi = Absensi::with('siswa.sekolah', 'siswa.kelas')
            ->whereDate('waktu_scan', $tanggal)
            ->whereHas('siswa', function($q) use ($sekolah_id) {
                $q->where('sekolah_id', $sekolah_id);
            })
            ->when($kelas_id, function($query) use ($kelas_id) {
                return $query->whereHas('siswa', function($q) use ($kelas_id) {
                    $q->where('kelas_id', $kelas_id);
                });
            })
            ->latest()
            ->get(); // Changed from paginate to get() since we're grouping by class
        
        return view('absensi.index', compact('absensi', 'kelas', 'sekolah_id', 'kelas_id', 'tanggal', 'authSchool'));
    }
    

    public function store(Request $request)
{
    // Get authenticated school
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    $siswa = DataSiswa::where('nisn', $request->nisn)
        ->where('sekolah_id', $authSchool->id)
        ->first();
        
    if (!$siswa) {
        return redirect()->back()->with('error', 'Siswa tidak ditemukan atau bukan dari sekolah Anda');
    }

    $today = Carbon::now();
    $dayName = $this->getDayNameIndonesian($today->dayOfWeek);
    
    // Ambil pengaturan untuk hari ini dari setting_daily
    $settingDaily = SettingDaily::where('sekolah_id', $authSchool->id)
        ->where('hari', $dayName)
        ->first();
    
    if (!$settingDaily) {
        return redirect()->back()->with('error', 'Pengaturan jadwal untuk hari '.$dayName.' tidak ditemukan');
    }
    
    // Cek apakah jadwal hari ini aktif
    if (!$settingDaily->is_active) {
        return redirect()->back()->with('error', 'Jadwal untuk hari '.$dayName.' tidak aktif');
    }

    // Cek apakah siswa sudah absen hari ini
    $alreadyPresent = Absensi::where('siswa_id', $siswa->id)
        ->whereDate('waktu_scan', $today->format('Y-m-d'))
        ->exists();
        
    if ($alreadyPresent) {
        return redirect()->back()->with('error', 'Siswa sudah melakukan absensi hari ini');
    }

    $waktu_scan = Carbon::now();
    $jam_scan = $waktu_scan->format('H:i:s');
    $status = 'Tidak Hadir';
    
    // Format jam dari setting_daily
    $jam_masuk = Carbon::createFromFormat('H:i:s', $settingDaily->jam_masuk);
    $batas_terlambat = Carbon::createFromFormat('H:i:s', $settingDaily->batas_terlambat);
    $batas_tidak_hadir = (clone $batas_terlambat)->addHour(); // 1 jam setelah batas terlambat
    
    $jam_scan_carbon = Carbon::createFromFormat('H:i:s', $jam_scan);

    // Determine status based on time
    if ($jam_scan_carbon <= $jam_masuk) {
        $status = 'Hadir';
    } elseif ($jam_scan_carbon <= $batas_terlambat) {
        $status = 'Terlambat';
    } elseif ($jam_scan_carbon <= $batas_tidak_hadir) {
        $status = 'Terlambat';
    } else {
        $status = 'Tidak Hadir';
    }

    Absensi::create([
        'siswa_id' => $siswa->id,
        'waktu_scan' => $waktu_scan,
        'status' => $status
    ]);

    $emailRecipients = [];

    if (!empty($siswa->email_ayah)) {
        $emailRecipients[] = $siswa->email_ayah;
    }

    if (!empty($siswa->email_ibu)) {
        $emailRecipients[] = $siswa->email_ibu;
    }

    if (!empty($siswa->email_wali)) {
        $emailRecipients[] = $siswa->email_wali;
    }

    if (!empty($emailRecipients)) {
        Mail::to($emailRecipients)->send(new AbsensiNotification($siswa, $status, $waktu_scan));
    }

    return redirect()->back()->with('success', 'Absensi berhasil dicatat dan notifikasi telah dikirim ke email orang tua/wali.');
}

/**
 * Mendapatkan nama hari dalam bahasa Indonesia berdasarkan index hari
 *
 * @param int $dayOfWeek Carbon day of week (0 = Sunday, 6 = Saturday)
 * @return string Nama hari dalam bahasa Indonesia
 */
private function getDayNameIndonesian($dayOfWeek)
{
    $days = [
        0 => 'Minggu',
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
    ];
    
    return $days[$dayOfWeek];
}
public function scanqr()
{
    // Get current user's school
    $userSchool = Sekolah::where('user_id', Auth::id())->first();
    
    if (!$userSchool) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    // Store the school ID in session (this replaces the need for separate auth)
    session(['scan_sekolah_id' => $userSchool->id]);
    
    // Get current day name
    $today = Carbon::now();
    $dayName = $this->getDayNameIndonesian($today->dayOfWeek);
    
    // Get daily settings for today
    $settingDaily = SettingDaily::where('sekolah_id', $userSchool->id)
        ->where('hari', $dayName)
        ->first();
    
    // If no settings found for today, create a default
    if (!$settingDaily) {
        return redirect()->route('school.dashboard')
            ->with('error', 'Pengaturan jadwal untuk hari '.$dayName.' tidak ditemukan');
    }
    
    // Check if today's schedule is active
    if (!$settingDaily->is_active) {
        return redirect()->route('school.dashboard')
            ->with('error', 'Jadwal untuk hari '.$dayName.' tidak aktif. Tidak ada absensi hari ini.');
    }
    
    // Calculate current attendance status
    $currentStatus = $this->calculateAttendanceStatus($settingDaily);
    
    return view('absensi.scan', compact('userSchool', 'settingDaily', 'dayName', 'currentStatus'));
}

public function showScanPage(Request $request)
{
    // Get current user's school
    $userSchool = Sekolah::where('user_id', Auth::id())->first();
    
    if (!$userSchool) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    // Store school ID in session
    $sekolah_id = $userSchool->id;
    session(['scan_sekolah_id' => $sekolah_id]);
    
    // Get token from database for this school
    $tokenSetting = SettingAbsensi::where('sekolah_id', $sekolah_id)
                                ->where('key', 'scan_access_token')
                                ->first();
    
    if (!$tokenSetting) {
        return redirect()->route('absensi.token.management')
            ->with('error', 'Token akses belum dibuat untuk sekolah ini.');
    }
    
    // Set token in session to skip authentication
    session(['scan_access_token_' . $sekolah_id => $tokenSetting->value]);
    
    return view('absensi.scan', compact('userSchool'));
}

/**
 * Mendapatkan nama hari dalam bahasa Indonesia berdasarkan index hari
 *
 * @param int $dayOfWeek Carbon day of week (0 = Sunday, 6 = Saturday)
 * @return string Nama hari dalam bahasa Indonesia
 */

/**
 * Menghitung status kehadiran berdasarkan waktu saat ini
 *
 * @param SettingDaily $settingDaily
 * @return string Status kehadiran (Hadir/Terlambat/Tidak Hadir)
 */
private function calculateAttendanceStatus($settingDaily)
{
    $now = Carbon::now();
    $currentTime = $now->format('H:i:s');
    
    $jamMasuk = Carbon::createFromFormat('H:i:s', $settingDaily->jam_masuk);
    $batasTerlambat = Carbon::createFromFormat('H:i:s', $settingDaily->batas_terlambat);
    $batasTidakHadir = (clone $batasTerlambat)->addHour(); // 1 jam setelah batas terlambat
    
    $currentTimeCarbon = Carbon::createFromFormat('H:i:s', $currentTime);
    
    if ($currentTimeCarbon <= $jamMasuk) {
        return 'Hadir';
    } elseif ($currentTimeCarbon <= $batasTerlambat) {
        return 'Terlambat';
    } elseif ($currentTimeCarbon <= $batasTidakHadir) {
        return 'Terlambat';
    } else {
        return 'Tidak Hadir';
    }
}



    public function scanAuth()
    {
        // Get authenticated school
        $authSchool = $this->getAuthenticatedSchool();
        
        if (!$authSchool) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        return view('absensi.scan_auth', compact('authSchool'));
    }

    public function tokenManagement(Request $request)
    {
        // Get authenticated school
        $authSchool = $this->getAuthenticatedSchool();
        
        if (!$authSchool) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Force sekolah_id to be the authenticated school's ID
        $sekolah_id = $authSchool->id;
        session(['token_sekolah_id' => $sekolah_id]);
        
        $tokenExists = SettingAbsensi::where('sekolah_id', $sekolah_id)
                                    ->where('key', 'scan_access_token')
                                    ->exists();
        
        return view('absensi.token_management', compact('authSchool', 'tokenExists'));
    }
    
    public function logoutTokenManagement()
    {
        // Clear the school ID from the session for token management
        session()->forget('token_sekolah_id');
        
        // Redirect to the welcome page - we no longer need to select a school
        return redirect()->route('sekolah.dashboard')
            ->with('success', 'Berhasil keluar dari pengelolaan token.');
    }

    public function createToken(Request $request)
    {
        // Get authenticated school
        $authSchool = $this->getAuthenticatedSchool();
        
        if (!$authSchool) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        $request->validate([
            'token' => 'required|string|min:8',
            'admin_password' => 'required',
        ]);
        
        $adminPasswordSetting = SettingAbsensi::where('key', 'admin_password')->first();
        
        if (!$adminPasswordSetting || !Hash::check($request->admin_password, $adminPasswordSetting->value)) {
            return redirect()->back()->with('error', 'Password admin tidak valid');
        }
        
        // Force sekolah_id to be the authenticated school's ID
        $sekolah_id = $authSchool->id;
        
        if (SettingAbsensi::where('sekolah_id', $sekolah_id)
                        ->where('key', 'scan_access_token')
                        ->exists()) {
            return redirect()->back()->with('error', 'Token sudah ada untuk sekolah ini. Gunakan fungsi update token.');
        }
        
        SettingAbsensi::create([
            'sekolah_id' => $sekolah_id,
            'key' => 'scan_access_token',
            'value' => $request->token,
            'description' => 'Token untuk akses fitur scan QR'
        ]);
        
        return redirect()->back()->with('success', 'Token berhasil dibuat');
    }

    public function updateToken(Request $request)
    {
        // Get authenticated school
        $authSchool = $this->getAuthenticatedSchool();
        
        if (!$authSchool) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        $request->validate([
            'current_token' => 'required|string',
            'new_token' => 'required|string|min:8|different:current_token',
        ]);
        
        // Force sekolah_id to be the authenticated school's ID
        $sekolah_id = $authSchool->id;
        
        $tokenSetting = SettingAbsensi::where('sekolah_id', $sekolah_id)
                                    ->where('key', 'scan_access_token')
                                    ->first();
        
        if (!$tokenSetting) {
            return redirect()->back()->with('error', 'Token belum dibuat untuk sekolah ini. Gunakan fungsi create token.');
        }
        
        if ($request->current_token !== $tokenSetting->value) {
            return redirect()->back()->with('error', 'Token saat ini tidak valid');
        }
        
        $tokenSetting->value = $request->new_token;
        $tokenSetting->save();
        
        if (session('scan_access_token_' . $sekolah_id) === $request->current_token) {
            session(['scan_access_token_' . $sekolah_id => $request->new_token]);
        }
        
        return redirect()->back()->with('success', 'Token berhasil diperbarui');
    }
    
    // Remove selectSchool method as it's no longer needed - schools can only see their own data


    public function logoutScan(Request $request)
    {
        // Clear the token from the session
        if (session()->has('scan_sekolah_id')) {
            $sekolah_id = session('scan_sekolah_id');
            // Remove the specific school token
            session()->forget('scan_access_token_' . $sekolah_id);
            // Remove the selected school
            session()->forget('scan_sekolah_id');
        }
        
        // Redirect to the welcome page
        return redirect()->route('school.dashboard')
            ->with('success', 'Berhasil keluar dari fitur scan.');
    }


    public function manualForm()
{
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    return view('absensi.manual', compact('authSchool'));
}

public function checkStudent(Request $request)
{
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    $siswa = DataSiswa::where('nisn', $request->nisn)
        ->where('sekolah_id', $authSchool->id)
        ->first();
    
    if (!$siswa) {
        return response()->json(['found' => false]);
    }
    
    return response()->json([
        'found' => true,
        'siswa' => [
            'id' => $siswa->id,
            'nama_lengkap' => $siswa->nama_lengkap,
            'kelas' => $siswa->kelas->nama_kelas ?? 'Tidak ada kelas'
        ]
    ]);
}

public function manualStore(Request $request)
{
    $request->validate([
        'siswa_id' => 'required|exists:data_siswa,id',
        'tanggal' => 'required|date',
        'status' => 'required|in:Hadir,Terlambat,Sakit,Izin,Alpa'
    ]);
    
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    // Check if student belongs to this school
    $siswa = DataSiswa::where('id', $request->siswa_id)
        ->where('sekolah_id', $authSchool->id)
        ->first();
        
    if (!$siswa) {
        return redirect()->back()->with('error', 'Siswa tidak ditemukan atau bukan dari sekolah Anda');
    }
    
    // Check if student already has attendance for the selected date
    $existingAttendance = Absensi::where('siswa_id', $siswa->id)
        ->whereDate('waktu_scan', $request->tanggal)
        ->first();
        
    if ($existingAttendance) {
        // Update existing attendance
        $existingAttendance->status = $request->status;
        $existingAttendance->keterangan = $request->keterangan ?? null;
        $existingAttendance->save();
        
        return redirect()->back()->with('success', 'Absensi siswa berhasil diperbarui');
    }
    
    // Create new attendance record
    Absensi::create([
        'siswa_id' => $siswa->id,
        'waktu_scan' => Carbon::parse($request->tanggal . ' ' . Carbon::now()->format('H:i:s')),
        'status' => $request->status,
        'keterangan' => $request->keterangan ?? null,
        'manual_entry' => true
    ]);
    
    return redirect()->back()->with('success', 'Absensi manual berhasil dicatat');
}

public function statistics(Request $request)
{
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    $sekolah_id = $authSchool->id;
    $kelas_id = $request->kelas_id;
    $bulan = $request->bulan ?? Carbon::now()->format('m');
    $tahun = $request->tahun ?? Carbon::now()->format('Y');
    $semester = $request->semester ?? 'none';
    
    $kelas = Kelas::where('sekolah_id', $sekolah_id)->get();
    
    // Get all students from the school/class
    $siswas = DataSiswa::where('sekolah_id', $sekolah_id)
        ->when($kelas_id, function($query) use ($kelas_id) {
            return $query->where('kelas_id', $kelas_id);
        })
        ->get();
    
    $statistics = [];
    
    foreach ($siswas as $siswa) {
        // Check filter type
        $isAllMonths = $bulan === 'all';
        $isSemester = $semester !== 'none';
        
        // Get all attendance records based on filter
        $absensiQuery = Absensi::where('siswa_id', $siswa->id);
        
        if ($isSemester) {
            // Filter by semester (academic year, not calendar year)
            $absensiQuery->whereYear('waktu_scan', $tahun);
            
            if ($semester === 'semester1') {
                // Semester 1: July-December
                $absensiQuery->whereIn('waktu_scan', function($query) use ($tahun) {
                    $query->selectRaw('waktu_scan')
                          ->from('absensis')
                          ->whereMonth('waktu_scan', '>=', 7)
                          ->whereMonth('waktu_scan', '<=', 12)
                          ->whereYear('waktu_scan', $tahun);
                });
            } else if ($semester === 'semester2') {
                // Semester 2: January-June
                $absensiQuery->whereIn('waktu_scan', function($query) use ($tahun) {
                    $query->selectRaw('waktu_scan')
                          ->from('absensis')
                          ->whereMonth('waktu_scan', '>=', 1)
                          ->whereMonth('waktu_scan', '<=', 6)
                          ->whereYear('waktu_scan', $tahun);
                });
            }
        } else {
            // Filter by year
            $absensiQuery->whereYear('waktu_scan', $tahun);
            
            // Filter by month if not "all months"
            if (!$isAllMonths) {
                $absensiQuery->whereMonth('waktu_scan', $bulan);
            }
        }
        
        $absensiData = $absensiQuery->get();
        
        $hadir = $absensiData->where('status', 'Hadir')->count();
        $terlambat = $absensiData->where('status', 'Terlambat')->count();
        $sakit = $absensiData->where('status', 'Sakit')->count();
        $izin = $absensiData->where('status', 'Izin')->count();
        $alpa = $absensiData->where('status', 'Alpa')->count();
        
        // Calculate total school days based on filter
        $totalSchoolDays = 0;
        
        // Define months to process based on filter
        $monthsToProcess = [];
        
        if ($isSemester) {
            if ($semester === 'semester1') {
                // Semester 1: July-December
                $monthsToProcess = range(7, 12);
            } else if ($semester === 'semester2') {
                // Semester 2: January-June
                $monthsToProcess = range(1, 6);
            }
        } else if ($isAllMonths) {
            // All months
            $monthsToProcess = range(1, 12);
        } else {
            // Specific month
            $monthsToProcess = [(int)$bulan];
        }
        
        // Calculate school days for the selected months
        foreach ($monthsToProcess as $monthNum) {
            $daysInMonth = Carbon::createFromDate($tahun, $monthNum, 1)->daysInMonth;
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::createFromDate($tahun, $monthNum, $day);
                $dayOfWeek = $date->dayOfWeek;
                
                // If day is not Saturday (6) or Sunday (0)
                if ($dayOfWeek !== 0 && $dayOfWeek !== 6) {
                    $totalSchoolDays++;
                }
            }
        }
        
        // Count total recorded attendance
        $totalRecorded = $hadir + $terlambat + $sakit + $izin + $alpa;
        
        // Calculate missing attendance records
        $tidakAda = $totalSchoolDays - $totalRecorded;
        if ($tidakAda < 0) $tidakAda = 0;
        
        $statistics[] = [
            'siswa' => $siswa,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'sakit' => $sakit,
            'izin' => $izin,
            'alpa' => $alpa,
            'tidak_ada' => $tidakAda,
            'total_hari_sekolah' => $totalSchoolDays
        ];
    }
    
    // Get month names for dropdown
    $bulanList = [
        'all' => 'Semua Bulan',
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
    
    // Semester options
    $semesterList = [
        'none' => 'Pilih Semester',
        'semester1' => 'Semester 1 (Juli-Desember)',
        'semester2' => 'Semester 2 (Januari-Juni)'
    ];
    
    // Get years from current year minus 5 to current year plus 1
    $tahunList = range(Carbon::now()->year - 5, Carbon::now()->year + 1);
    
    return view('absensi.statistics', compact(
        'statistics', 'kelas', 'bulanList', 'tahunList', 'semesterList',
        'sekolah_id', 'kelas_id', 'bulan', 'tahun', 'semester', 'authSchool'
    ));
}
public function export(Request $request)
{
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    $sekolah_id = $authSchool->id;
    $kelas_id = $request->kelas_id;
    $bulan = $request->bulan ?? Carbon::now()->format('m');
    $tahun = $request->tahun ?? Carbon::now()->format('Y');
    $semester = $request->semester ?? 'none';
    
    // Determine filename based on filter
    $periodLabel = '';
    
    if ($semester !== 'none') {
        if ($semester === 'semester1') {
            $periodLabel = "Semester_1_{$tahun}";
        } else if ($semester === 'semester2') {
            $periodLabel = "Semester_2_{$tahun}";
        }
    } else if ($bulan === 'all') {
        $periodLabel = "Tahun_{$tahun}";
    } else {
        $bulanName = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ][$bulan];
        $periodLabel = "{$bulanName}_{$tahun}";
    }
    
    $kelas = $kelas_id ? Kelas::find($kelas_id)->nama_kelas : 'Semua_Kelas';
    
    $filename = "Absensi_{$authSchool->nama_sekolah}_{$kelas}_{$periodLabel}.xlsx";
    
    return Excel::download(new AbsensiExport($sekolah_id, $kelas_id, $bulan, $tahun, $semester), $filename);
}

public function generatePDF(Request $request)
{
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    $sekolah_id = $authSchool->id;
    $kelas_id = $request->kelas_id;
    $bulan = $request->bulan ?? Carbon::now()->format('m');
    $tahun = $request->tahun ?? Carbon::now()->format('Y');
    $semester = $request->semester ?? 'none';
    
    // Get statistics data
    $siswas = DataSiswa::where('sekolah_id', $sekolah_id)
        ->when($kelas_id, function($query) use ($kelas_id) {
            return $query->where('kelas_id', $kelas_id);
        })
        ->get();
    
    $statistics = [];
    
    foreach ($siswas as $siswa) {
        // Check filter type
        $isAllMonths = $bulan === 'all';
        $isSemester = $semester !== 'none';
        
        // Get all attendance records based on filter
        $absensiQuery = Absensi::where('siswa_id', $siswa->id);
        
        if ($isSemester) {
            // Filter by semester (academic year, not calendar year)
            $absensiQuery->whereYear('waktu_scan', $tahun);
            
            if ($semester === 'semester1') {
                // Semester 1: July-December
                $absensiQuery->whereIn('waktu_scan', function($query) use ($tahun) {
                    $query->selectRaw('waktu_scan')
                          ->from('absensi')
                          ->whereMonth('waktu_scan', '>=', 7)
                          ->whereMonth('waktu_scan', '<=', 12)
                          ->whereYear('waktu_scan', $tahun);
                });
            } else if ($semester === 'semester2') {
                // Semester 2: January-June
                $absensiQuery->whereIn('waktu_scan', function($query) use ($tahun) {
                    $query->selectRaw('waktu_scan')
                          ->from('absensi')
                          ->whereMonth('waktu_scan', '>=', 1)
                          ->whereMonth('waktu_scan', '<=', 6)
                          ->whereYear('waktu_scan', $tahun);
                });
            }
        } else {
            // Filter by year
            $absensiQuery->whereYear('waktu_scan', $tahun);
            
            // Filter by month if not "all months"
            if (!$isAllMonths) {
                $absensiQuery->whereMonth('waktu_scan', $bulan);
            }
        }
        
        $absensiData = $absensiQuery->get();
        
        $hadir = $absensiData->where('status', 'Hadir')->count();
        $terlambat = $absensiData->where('status', 'Terlambat')->count();
        $sakit = $absensiData->where('status', 'Sakit')->count();
        $izin = $absensiData->where('status', 'Izin')->count();
        $alpa = $absensiData->where('status', 'Alpa')->count();
        
        // Calculate total school days based on filter
        $totalSchoolDays = 0;
        
        // Define months to process based on filter
        $monthsToProcess = [];
        
        if ($isSemester) {
            if ($semester === 'semester1') {
                // Semester 1: July-December
                $monthsToProcess = range(7, 12);
            } else if ($semester === 'semester2') {
                // Semester 2: January-June
                $monthsToProcess = range(1, 6);
            }
        } else if ($isAllMonths) {
            // All months
            $monthsToProcess = range(1, 12);
        } else {
            // Specific month
            $monthsToProcess = [(int)$bulan];
        }
        
        // Calculate school days for the selected months
        foreach ($monthsToProcess as $monthNum) {
            $daysInMonth = Carbon::createFromDate($tahun, $monthNum, 1)->daysInMonth;
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::createFromDate($tahun, $monthNum, $day);
                $dayOfWeek = $date->dayOfWeek;
                
                // If day is not Saturday (6) or Sunday (0)
                if ($dayOfWeek !== 0 && $dayOfWeek !== 6) {
                    $totalSchoolDays++;
                }
            }
        }
        
        // Count total recorded attendance
        $totalRecorded = $hadir + $terlambat + $sakit + $izin + $alpa;
        
        // Calculate missing attendance records
        $tidakAda = $totalSchoolDays - $totalRecorded;
        if ($tidakAda < 0) $tidakAda = 0;
        
        $statistics[] = [
            'siswa' => $siswa,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'sakit' => $sakit,
            'izin' => $izin,
            'alpa' => $alpa,
            'tidak_ada' => $tidakAda,
            'total_hari_sekolah' => $totalSchoolDays
        ];
    }
    
    // Determine period label for PDF title
    $periodLabel = '';
    
    if ($semester !== 'none') {
        if ($semester === 'semester1') {
            $periodLabel = "Semester 1 ({$tahun})";
        } else if ($semester === 'semester2') {
            $periodLabel = "Semester 2 ({$tahun})";
        }
    } else if ($bulan === 'all') {
        $periodLabel = "Tahun {$tahun}";
    } else {
        $bulanName = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ][$bulan];
        $periodLabel = "{$bulanName} {$tahun}";
    }
    
    $kelas = $kelas_id ? Kelas::find($kelas_id)->nama_kelas : 'Semua Kelas';
    
    $data = [
        'statistics' => $statistics,
        'sekolah' => $authSchool,
        'kelas' => $kelas,
        'periodLabel' => $periodLabel,
    ];
    
    $pdf = PDF::loadView('absensi.pdf', $data);
    
    return $pdf->download("Laporan_Absensi_{$authSchool->nama_sekolah}_{$kelas}_{$periodLabel}.pdf");
}
}