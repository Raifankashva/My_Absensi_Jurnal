<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\DataGuru;
use App\Models\JadwalPelajaran;
use App\Models\JurnalGuru;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GuruController extends Controller
{
    public function dashboard()
    {
        // Get the logged-in guru's details
        $guru = DataGuru::where('user_id', Auth::id())->with(['jadwalPelajaran', 'jurnalGuru'])->firstOrFail();

        // Fetch students in the same school as the guru
        $totalSiswa = User::where('role', 'siswa')
            ->whereHas('dataSiswa', function ($query) use ($guru) {
                $query->where('sekolah_id', $guru->sekolah_id);
            })
            ->count();

        // Get today's day name in lowercase
        $today = strtolower(Carbon::now()->translatedFormat('l'));
        
        // Fetch today's schedule
        $jadwalHariIni = JadwalPelajaran::where('guru_id', $guru->id)
            ->where('hari', $today)
            ->with('kelas')
            ->orderBy('jam_mulai')
            ->get();
            
        // Fetch recent journals
        $jurnalTerbaru = JurnalGuru::where('guru_id', $guru->id)
            ->with(['kelas', 'jadwalPelajaran'])
            ->orderBy('tanggal', 'desc')
            ->take(3)
            ->get();
            
        // Count total classes taught by the guru
        $totalKelas = JadwalPelajaran::where('guru_id', $guru->id)
            ->distinct('kelas_id')
            ->count('kelas_id');
            
        // Count journals from current month
        $jurnalBulanIni = JurnalGuru::where('guru_id', $guru->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->count();
            
        // Count today's schedule
        $totalJadwalHariIni = $jadwalHariIni->count();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'jadwalHariIni',
            'jurnalTerbaru',
            'totalKelas',
            'jurnalBulanIni',
            'totalJadwalHariIni'
        ));
    }
}