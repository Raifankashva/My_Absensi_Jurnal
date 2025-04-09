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
    
    // Helper method to get authenticated school
    private function getAuthenticatedSchool()
    {
        return Sekolah::where('user_id', Auth::id())->first();
    }
    
    public function index(Request $request)
    {
        // Get authenticated school
        $authSchool = $this->getAuthenticatedSchool();
        
        if (!$authSchool) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Force sekolah_id to be the authenticated school's ID
        $sekolah_id = $authSchool->id;
        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        
        // Only get classes from the authenticated school
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

    public function exportPDF(Request $request)
    {
        // Get authenticated school
        $authSchool = $this->getAuthenticatedSchool();
        
        if (!$authSchool) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Force sekolah_id to be the authenticated school's ID
        $sekolah_id = $authSchool->id;
        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        
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
            ->get();
            
        $sekolahName = $authSchool->nama;
        $kelasName = $kelas_id ? Kelas::find($kelas_id)->nama : 'Semua Kelas';
        
        $pdf = PDF::loadView('absensi.pdf', compact('absensi', 'tanggal', 'sekolahName', 'kelasName'));
        return $pdf->download('absensi-'.$tanggal.'.pdf');
    }
    
    public function exportExcel(Request $request)
    {
        // Get authenticated school
        $authSchool = $this->getAuthenticatedSchool();
        
        if (!$authSchool) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Force sekolah_id to be the authenticated school's ID
        $sekolah_id = $authSchool->id;
        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        
        return Excel::download(new AbsensiExport($sekolah_id, $kelas_id, $tanggal), 'absensi-'.$tanggal.'.xlsx');
    }
    public function exportPeriodePDF(Request $request)
{
    // Get authenticated school
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    // Force sekolah_id to be the authenticated school's ID
    $sekolah_id = $authSchool->id;
    $kelas_id = $request->kelas_id;
    $periode = $request->periode ?? 'today';
    $tanggal_mulai = $request->tanggal_mulai;
    $tanggal_akhir = $request->tanggal_akhir;
    
    // Set date range based on selected period
    list($startDate, $endDate, $periodeLabel) = $this->calculateDateRange($periode, $tanggal_mulai, $tanggal_akhir);
    
    $absensi = Absensi::with('siswa.sekolah', 'siswa.kelas')
        ->whereBetween('waktu_scan', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
        ->whereHas('siswa', function($q) use ($sekolah_id) {
            $q->where('sekolah_id', $sekolah_id);
        })
        ->when($kelas_id, function($query) use ($kelas_id) {
            return $query->whereHas('siswa', function($q) use ($kelas_id) {
                $q->where('kelas_id', $kelas_id);
            });
        })
        ->latest()
        ->get();
        
    $sekolahName = $authSchool->nama;
    $kelasName = $kelas_id ? Kelas::find($kelas_id)->nama_kelas : 'Semua Kelas';
    
    $pdf = PDF::loadView('absensi.periode_pdf', compact('absensi', 'startDate', 'endDate', 'sekolahName', 'kelasName', 'periodeLabel'));
    return $pdf->download('absensi-'.$periodeLabel.'.pdf');
}

public function exportPeriodeExcel(Request $request)
{
    // Get authenticated school
    $authSchool = $this->getAuthenticatedSchool();
    
    if (!$authSchool) {
        return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke data sekolah');
    }
    
    // Force sekolah_id to be the authenticated school's ID
    $sekolah_id = $authSchool->id;
    $kelas_id = $request->kelas_id;
    $periode = $request->periode ?? 'today';
    $tanggal_mulai = $request->tanggal_mulai;
    $tanggal_akhir = $request->tanggal_akhir;
    
    // Set date range based on selected period
    list($startDate, $endDate, $periodeLabel) = $this->calculateDateRange($periode, $tanggal_mulai, $tanggal_akhir);
    
    return Excel::download(new AbsensiPeriodeExport($sekolah_id, $kelas_id, $startDate, $endDate), 'absensi-'.$periodeLabel.'.xlsx');
}

/**
 * Calculate date range based on selected period
 * 
 * @param string $periode
 * @param string|null $tanggal_mulai
 * @param string|null $tanggal_akhir
 * @return array
 */
private function calculateDateRange($periode, $tanggal_mulai = null, $tanggal_akhir = null)
{
    $today = Carbon::now()->format('Y-m-d');
    $label = '';
    
    switch ($periode) {
        case 'today':
            $startDate = $today;
            $endDate = $today;
            $label = 'hari-ini-'.Carbon::now()->format('d-m-Y');
            break;
            
        case 'this_week':
            $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
            $endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
            $label = 'minggu-ini-'.Carbon::now()->startOfWeek()->format('d-m-Y').'-sampai-'.Carbon::now()->endOfWeek()->format('d-m-Y');
            break;
            
        case 'last_week':
            $startDate = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
            $endDate = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');
            $label = 'minggu-lalu-'.Carbon::now()->subWeek()->startOfWeek()->format('d-m-Y').'-sampai-'.Carbon::now()->subWeek()->endOfWeek()->format('d-m-Y');
            break;
            
        case 'this_month':
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
            $label = 'bulan-ini-'.Carbon::now()->format('M-Y');
            break;
            
        case 'last_month':
            $startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
            $label = 'bulan-lalu-'.Carbon::now()->subMonth()->format('M-Y');
            break;
            
        case 'last_2_months':
            $startDate = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
            $label = '2-bulan-terakhir-'.Carbon::now()->subMonths(2)->format('M-Y').'-sampai-'.Carbon::now()->format('M-Y');
            break;
            
        case 'custom':
            $startDate = $tanggal_mulai;
            $endDate = $tanggal_akhir;
            $label = 'kustom-'.Carbon::parse($tanggal_mulai)->format('d-m-Y').'-sampai-'.Carbon::parse($tanggal_akhir)->format('d-m-Y');
            break;
            
        default:
            $startDate = $today;
            $endDate = $today;
            $label = 'hari-ini-'.Carbon::now()->format('d-m-Y');
    }
    
    return [$startDate, $endDate, $label];
}
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
        return redirect()->route('welcome')
            ->with('success', 'Berhasil keluar dari fitur scan.');
    }
}