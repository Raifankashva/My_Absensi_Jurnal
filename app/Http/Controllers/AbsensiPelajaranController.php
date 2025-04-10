<?php

namespace App\Http\Controllers;

use App\Models\AbsensiPelajaran;
use App\Models\DataSiswa;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiPelajaranController extends Controller
{
    /**
     * Display the attendance form for a specific class schedule
     */
    public function index(Request $request)
    {
        $jadwalId = $request->jadwal_id;
        $tanggal = $request->tanggal ?? date('Y-m-d');
        
        $jadwal = JadwalPelajaran::with('kelas', 'guru')
            ->findOrFail($jadwalId);
            
        // Get all students in this class
        $siswaList = DataSiswa::where('kelas_id', $jadwal->kelas_id)
            ->orderBy('nama_lengkap', 'asc')
            ->get();
            
        // Get existing attendance records for this schedule and date
        $existingAbsensi = AbsensiPelajaran::where('jadwal_pelajaran_id', $jadwalId)
            ->where('tanggal', $tanggal)
            ->pluck('status', 'siswa_id');
            
        return view('absensi.pelajaran.index', compact(
            'jadwal', 
            'tanggal', 
            'siswaList', 
            'existingAbsensi'
        ));
    }
    
    /**
     * Display the list of subjects for today for attendance taking
     */
    public function jadwalHariIni()
    {
        $hariIni = now()->format('l');
        $hariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        
        $hari = $hariIndonesia[$hariIni];
        $tanggal = date('Y-m-d');
        
        $jadwalList = JadwalPelajaran::with('kelas', 'guru')
            ->where('hari', $hari)
            ->orderBy('jam_mulai')
            ->get();
            
        return view('absensi.pelajaran.jadwal-hari-ini', compact('jadwalList', 'hari', 'tanggal'));
    }
    
    /**
     * Store attendance records for multiple students at once
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pelajaran,id',
            'tanggal' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'required|in:Hadir,Izin,Sakit,Alpa,Terlambat',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string'
        ]);
        
        DB::beginTransaction();
        
        try {
            $jadwalId = $request->jadwal_id;
            $tanggal = $request->tanggal;
            $userId = Auth::id();
            
            // Delete existing records for this schedule and date
            AbsensiPelajaran::where('jadwal_pelajaran_id', $jadwalId)
                ->where('tanggal', $tanggal)
                ->delete();
                
            // Create new attendance records
            foreach ($request->status as $siswaId => $status) {
                AbsensiPelajaran::create([
                    'siswa_id' => $siswaId,
                    'jadwal_pelajaran_id' => $jadwalId,
                    'tanggal' => $tanggal,
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswaId] ?? null,
                    'created_by' => $userId
                ]);
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Data absensi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data absensi: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Display attendance reports by subject, class, date range
     */
    public function report(Request $request)
    {
        $kelasId = $request->kelas_id;
        $jadwalId = $request->jadwal_id;
        $tanggalMulai = $request->tanggal_mulai ?? date('Y-m-d', strtotime('-1 month'));
        $tanggalSelesai = $request->tanggal_selesai ?? date('Y-m-d');
        
        $query = AbsensiPelajaran::with(['siswa', 'jadwalPelajaran', 'jadwalPelajaran.guru']);
        
        if ($jadwalId) {
            $query->where('jadwal_pelajaran_id', $jadwalId);
        } elseif ($kelasId) {
            $jadwalIds = JadwalPelajaran::where('kelas_id', $kelasId)->pluck('id');
            $query->whereIn('jadwal_pelajaran_id', $jadwalIds);
        }
        
        $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        $query->orderBy('tanggal', 'desc');
        
        $absensiList = $query->get();
        
        // Get statistics
        $statistik = [
            'total' => $absensiList->count(),
            'hadir' => $absensiList->where('status', 'Hadir')->count(),
            'terlambat' => $absensiList->where('status', 'Terlambat')->count(),
            'izin' => $absensiList->where('status', 'Izin')->count(),
            'sakit' => $absensiList->where('status', 'Sakit')->count(),
            'alpa' => $absensiList->where('status', 'Alpa')->count(),
        ];
        
        return view('absensi.pelajaran.report', compact(
            'absensiList', 
            'statistik', 
            'kelasId', 
            'jadwalId', 
            'tanggalMulai', 
            'tanggalSelesai'
        ));
    }
    
    /**
     * Display attendance list for a specific subject on a specific date
     */
    public function showBySubject(Request $request, $jadwalId, $tanggal = null)
    {
        $tanggal = $tanggal ?? date('Y-m-d');
        
        $jadwal = JadwalPelajaran::with('kelas', 'guru')->findOrFail($jadwalId);
        
        $absensiList = AbsensiPelajaran::with('siswa')
            ->where('jadwal_pelajaran_id', $jadwalId)
            ->where('tanggal', $tanggal)
            ->get();
            
        // Get students who are present
        $siswaHadir = $absensiList->where('status', 'Hadir');
        
        // Get students with other statuses
        $siswaLainnya = $absensiList->where('status', '!=', 'Hadir');
        
        return view('absensi.pelajaran.show', compact(
            'jadwal', 
            'tanggal', 
            'siswaHadir', 
            'siswaLainnya'
        ));
    }
}