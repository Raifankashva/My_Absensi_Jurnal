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

        return redirect()->back()->with('success', 'Absensi berhasil dicatat');
    }
    
    public function scanQR()
    {
        return view('absensi.scan');
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