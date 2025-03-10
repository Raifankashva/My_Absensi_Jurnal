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

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $sekolah_id = $request->sekolah_id;
        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        
        $sekolah = Sekolah::all();
        $kelas = Kelas::when($sekolah_id, function($query) use ($sekolah_id) {
            return $query->where('sekolah_id', $sekolah_id);
        })->get();
        
        $absensi = Absensi::with('siswa.sekolah', 'siswa.kelas')
            ->whereDate('waktu_scan', $tanggal)
            ->when($sekolah_id, function($query) use ($sekolah_id) {
                return $query->whereHas('siswa', function($q) use ($sekolah_id) {
                    $q->where('sekolah_id', $sekolah_id);
                });
            })
            ->when($kelas_id, function($query) use ($kelas_id) {
                return $query->whereHas('siswa', function($q) use ($kelas_id) {
                    $q->where('kelas_id', $kelas_id);
                });
            })
            ->latest()
            ->paginate(10);
        
        return view('absensi.index', compact('absensi', 'sekolah', 'kelas', 'sekolah_id', 'kelas_id', 'tanggal'));
    }

    public function store(Request $request)
{
    $siswa = DataSiswa::where('nisn', $request->nisn)->first();
    if (!$siswa) {
        return redirect()->back()->with('error', 'Siswa tidak ditemukan');
    }

    $setting = Setting::where('sekolah_id', $siswa->sekolah_id)->first();
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
    $status = 'Tidak Hadir';

    if ($waktu_scan->format('H:i:s') <= $setting->jam_masuk) {
        $status = 'Hadir';
    } elseif ($waktu_scan->format('H:i:s') <= $setting->batas_terlambat) {
        $status = 'Terlambat';
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
        // If no sekolah_id is provided, show the school selection page
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
        
        // If no token or invalid token, redirect to auth page
        return redirect()->route('absensi.scan.auth');
    }

    public function scanAuth()
    {
        $sekolah_id = session('scan_sekolah_id');
        if (!$sekolah_id) {
            return redirect()->route('absensi.scan')->with('error', 'Silakan pilih sekolah terlebih dahulu');
        }
        
        $sekolah = Sekolah::findOrFail($sekolah_id);
        return view('absensi.scan_auth', compact('sekolah'));
    }

    public function tokenManagement(Request $request)
    {
        // Admin should select a school first if not already in session
        if (!$request->has('sekolah_id') && !session()->has('token_sekolah_id')) {
            $sekolah = Sekolah::all();
            return view('absensi.select_school_token', compact('sekolah'));
        }
        
        $sekolah_id = $request->sekolah_id ?? session('token_sekolah_id');
        session(['token_sekolah_id' => $sekolah_id]);
        
        $sekolah = Sekolah::findOrFail($sekolah_id);
        $tokenExists = SettingAbsensi::where('sekolah_id', $sekolah_id)
                                    ->where('key', 'scan_access_token')
                                    ->exists();
        
        return view('absensi.token_management', compact('sekolah', 'tokenExists'));
    }

    public function createToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|min:8',
            'admin_password' => 'required',
            'sekolah_id' => 'required|exists:sekolah,id'
        ]);
        
        // Get admin password from settings
        $adminPasswordSetting = SettingAbsensi::where('key', 'admin_password')->first();
        
        if (!$adminPasswordSetting || !Hash::check($request->admin_password, $adminPasswordSetting->value)) {
            return redirect()->back()->with('error', 'Password admin tidak valid');
        }
        
        // Check if token already exists for this school
        if (SettingAbsensi::where('sekolah_id', $request->sekolah_id)
                        ->where('key', 'scan_access_token')
                        ->exists()) {
            return redirect()->back()->with('error', 'Token sudah ada untuk sekolah ini. Gunakan fungsi update token.');
        }
        
        // Create new token
        SettingAbsensi::create([
            'sekolah_id' => $request->sekolah_id,
            'key' => 'scan_access_token',
            'value' => $request->token,
            'description' => 'Token untuk akses fitur scan QR'
        ]);
        
        return redirect()->back()->with('success', 'Token berhasil dibuat');
    }

    public function updateToken(Request $request)
    {
        $request->validate([
            'current_token' => 'required|string',
            'new_token' => 'required|string|min:8|different:current_token',
            'sekolah_id' => 'required|exists:sekolah,id'
        ]);
        
        // Get current token from database
        $tokenSetting = SettingAbsensi::where('sekolah_id', $request->sekolah_id)
                                    ->where('key', 'scan_access_token')
                                    ->first();
        
        if (!$tokenSetting) {
            return redirect()->back()->with('error', 'Token belum dibuat untuk sekolah ini. Gunakan fungsi create token.');
        }
        
        // Verify current token
        if ($request->current_token !== $tokenSetting->value) {
            return redirect()->back()->with('error', 'Token saat ini tidak valid');
        }
        
        // Update token
        $tokenSetting->value = $request->new_token;
        $tokenSetting->save();
        
        // Update session if user is using this token
        if (session('scan_access_token_' . $request->sekolah_id) === $request->current_token) {
            session(['scan_access_token_' . $request->sekolah_id => $request->new_token]);
        }
        
        return redirect()->back()->with('success', 'Token berhasil diperbarui');
    }
    
    public function selectSchool()
    {
        $sekolah = Sekolah::all();
        return view('absensi.select_school', compact('sekolah'));
    }

    public function exportPDF(Request $request)
    {
        $sekolah_id = $request->sekolah_id;
        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        
        $absensi = Absensi::with('siswa.sekolah', 'siswa.kelas')
            ->whereDate('waktu_scan', $tanggal)
            ->when($sekolah_id, function($query) use ($sekolah_id) {
                return $query->whereHas('siswa', function($q) use ($sekolah_id) {
                    $q->where('sekolah_id', $sekolah_id);
                });
            })
            ->when($kelas_id, function($query) use ($kelas_id) {
                return $query->whereHas('siswa', function($q) use ($kelas_id) {
                    $q->where('kelas_id', $kelas_id);
                });
            })
            ->latest()
            ->get();
            
        $sekolahName = $sekolah_id ? Sekolah::find($sekolah_id)->nama : 'Semua Sekolah';
        $kelasName = $kelas_id ? Kelas::find($kelas_id)->nama : 'Semua Kelas';
        
        $pdf = PDF::loadView('absensi.pdf', compact('absensi', 'tanggal', 'sekolahName', 'kelasName'));
        return $pdf->download('absensi-'.$tanggal.'.pdf');
    }
    
    public function exportExcel(Request $request)
    {
        $sekolah_id = $request->sekolah_id;
        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        
        return Excel::download(new AbsensiExport($sekolah_id, $kelas_id, $tanggal), 'absensi-'.$tanggal.'.xlsx');
    }
}