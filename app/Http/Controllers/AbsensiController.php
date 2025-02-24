<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\DataSiswa;
use App\Models\Setting;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with('siswa')->latest()->paginate(10);
        return view('absensi.index', compact('absensi'));
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

    public function exportPdf()
    {
        $absensi = Absensi::with('siswa')->get();
        $pdf = PDF::loadView('absensi.pdf', compact('absensi'));
        return $pdf->download('absensi.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new AbsensiExport, 'absensi.xlsx');
    }
}
