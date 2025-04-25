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
    
        $setting = Setting::where('sekolah_id', $authSchool->id)->first();
        if (!$setting) {
            return redirect()->back()->with('error', 'Pengaturan sekolah tidak ditemukan');
        }
    
        // Check if student already has attendance for today
        $today = Carbon::now()->format('Y-m-d');
        $alreadyPresent = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('waktu_scan', $today)
            ->exists();
            
        if ($alreadyPresent) {
            return redirect()->back()->with('error', 'Siswa sudah melakukan absensi hari ini');
        }
    
        $waktu_scan = Carbon::now();
        $jam_scan = $waktu_scan->format('H:i:s');
        $status = 'Tidak Hadir';
        
        // Convert times to Carbon for easier comparison
        $jam_masuk = Carbon::createFromFormat('H:i:s', $setting->jam_masuk);
        $batas_terlambat = Carbon::createFromFormat('H:i:s', $setting->batas_terlambat);
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
    
        // Kirim Email ke Ayah, Ibu, dan Wali (jika ada emailnya)
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
    
    public function scanQR(Request $request)
    {
        
        if (!$request->has('sekolah_id') && !session()->has('scan_sekolah_id')) {
            $sekolah = Sekolah::all();
            return view('absensi.select_school', compact('sekolah'));
        }
        
        // Get sekolah_id from request or session
        $sekolah_id = $request->sekolah_id ?? session('scan_sekolah_id');
        
        // Store sekolah_id in session
        session(['scan_sekolah_id' => $sekolah_id]);
        
        // Get token from database for this school
        $tokenSetting = SettingAbsensi::where('sekolah_id', $sekolah_id)
                                    ->where('key', 'scan_access_token')
                                    ->first();
        
        if (!$tokenSetting) {
            return redirect()->route('absensi.token.management')
                ->with('error', 'Token akses belum dibuat untuk sekolah ini.');
        }
        
        $validToken = $tokenSetting->value;
        $sekolah = Sekolah::findOrFail($sekolah_id);
        
        // Check if token is provided in the request
        if ($request->has('token')) {
            $providedToken = $request->token;
            
            // Validate the token
            if ($providedToken !== $validToken) {
                return redirect()->route('absensi.scan.auth')
                    ->with('error', 'Token akses tidak valid');
            }
            
            // If token is valid, store it in session to maintain access
            session(['scan_access_token_' . $sekolah_id => $providedToken]);
            
            return view('absensi.scan', compact('sekolah'));
        }
        
        // Check if token is already in session
        if (session()->has('scan_access_token_' . $sekolah_id)) {
            $sessionToken = session('scan_access_token_' . $sekolah_id);
            
            if ($sessionToken === $validToken) {
                return view('absensi.scan', compact('sekolah'));
            }
        }
        
        return redirect()->route('absensi.scan.auth');
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
        return redirect()->route('welcome')
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
        return redirect()->route('/')
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
    
    $kelas = Kelas::where('sekolah_id', $sekolah_id)->get();
    
    // Get all students from the school/class
    $siswas = DataSiswa::where('sekolah_id', $sekolah_id)
        ->when($kelas_id, function($query) use ($kelas_id) {
            return $query->where('kelas_id', $kelas_id);
        })
        ->get();
    
    $statistics = [];
    
    foreach ($siswas as $siswa) {
        // Get all attendance records for this student in the selected month/year
        $absensiData = Absensi::where('siswa_id', $siswa->id)
            ->whereYear('waktu_scan', $tahun)
            ->whereMonth('waktu_scan', $bulan)
            ->get();
        
        $hadir = $absensiData->where('status', 'Hadir')->count();
        $terlambat = $absensiData->where('status', 'Terlambat')->count();
        $sakit = $absensiData->where('status', 'Sakit')->count();
        $izin = $absensiData->where('status', 'Izin')->count();
        $alpa = $absensiData->where('status', 'Alpa')->count();
        
        // Calculate total days in the month
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        
        // Count weekdays (assuming school days are Monday-Friday)
        $totalSchoolDays = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($tahun, $bulan, $day);
            $dayOfWeek = $date->dayOfWeek;
            
            // If day is not Saturday (6) or Sunday (0)
            if ($dayOfWeek !== 0 && $dayOfWeek !== 6) {
                $totalSchoolDays++;
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
    
    // Get years from current year minus 5 to current year plus 1
    $tahunList = range(Carbon::now()->year - 5, Carbon::now()->year + 1);
    
    return view('absensi.statistics', compact(
        'statistics', 'kelas', 'bulanList', 'tahunList', 
        'sekolah_id', 'kelas_id', 'bulan', 'tahun', 'authSchool'
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
    
    $bulanName = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ][$bulan];
    
    $kelas = $kelas_id ? Kelas::find($kelas_id)->nama_kelas : 'Semua Kelas';
    
    $filename = "Absensi_{$authSchool->nama_sekolah}_{$kelas}_{$bulanName}_{$tahun}.xlsx";
    
    return Excel::download(new AbsensiExport($sekolah_id, $kelas_id, $bulan, $tahun), $filename);
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
    
    // Get statistics data (same logic as statistics method)
    $siswas = DataSiswa::where('sekolah_id', $sekolah_id)
        ->when($kelas_id, function($query) use ($kelas_id) {
            return $query->where('kelas_id', $kelas_id);
        })
        ->get();
    
    $statistics = [];
    
    foreach ($siswas as $siswa) {
        // Get all attendance records for this student in the selected month/year
        $absensiData = Absensi::where('siswa_id', $siswa->id)
            ->whereYear('waktu_scan', $tahun)
            ->whereMonth('waktu_scan', $bulan)
            ->get();
        
        $hadir = $absensiData->where('status', 'Hadir')->count();
        $terlambat = $absensiData->where('status', 'Terlambat')->count();
        $sakit = $absensiData->where('status', 'Sakit')->count();
        $izin = $absensiData->where('status', 'Izin')->count();
        $alpa = $absensiData->where('status', 'Alpa')->count();
        
        // Calculate total days in the month
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        
        // Count weekdays (assuming school days are Monday-Friday)
        $totalSchoolDays = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($tahun, $bulan, $day);
            $dayOfWeek = $date->dayOfWeek;
            
            // If day is not Saturday (6) or Sunday (0)
            if ($dayOfWeek !== 0 && $dayOfWeek !== 6) {
                $totalSchoolDays++;
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
    
    $bulanName = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ][$bulan];
    
    $kelas = $kelas_id ? Kelas::find($kelas_id)->nama_kelas : 'Semua Kelas';
    
    $data = [
        'statistics' => $statistics,
        'sekolah' => $authSchool,
        'kelas' => $kelas,
        'bulan' => $bulanName,
        'tahun' => $tahun
    ];
    
    $pdf = PDF::loadView('absensi.pdf', $data);
    
    return $pdf->download("Laporan_Absensi_{$authSchool->nama_sekolah}_{$kelas}_{$bulanName}_{$tahun}.pdf");
}
}