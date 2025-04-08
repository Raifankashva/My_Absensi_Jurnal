<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKelas;
use App\Models\JurnalGuru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\DataGuru;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JurnalGuruController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = DataGuru::where('user_id', $user->id)->first();
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }
        
        $jurnalGuru = JurnalGuru::where('guru_id', $guru->id)
            ->with(['jadwalPelajaran', 'kelas'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
            
        return view('jurnal_guru.index', compact('jurnalGuru', 'guru'));
    }
    
    public function create()
    {
        $user = Auth::user();
        $guru = DataGuru::where('user_id', $user->id)->first();
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }
        
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $jadwalHariIni = JadwalPelajaran::where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->with('kelas')
            ->orderBy('jam_mulai')
            ->get();
            
        return view('jurnal_guru.create', compact('jadwalHariIni', 'guru'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pelajaran_id' => 'required|exists:jadwal_pelajaran,id',
            'tanggal' => 'required|date',
            'materi_yang_disampaikan' => 'required|string',
            'siswa_hadir' => 'nullable|array',
            'siswa_tidak_hadir' => 'nullable|array',
            'keterangan_tidak_hadir' => 'nullable|array',
            'status_pertemuan' => 'required|in:Terlaksana,Diganti,Dibatalkan',
            'catatan_pembelajaran' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            $jadwalPelajaran = JadwalPelajaran::findOrFail($request->jadwal_pelajaran_id);
            $guru = Auth::user()->dataGuru;
            
            // Create Jurnal
            $jurnalGuru = new JurnalGuru();
            $jurnalGuru->jadwal_pelajaran_id = $request->jadwal_pelajaran_id;
            $jurnalGuru->guru_id = $guru->id;
            $jurnalGuru->kelas_id = $jadwalPelajaran->kelas_id;
            $jurnalGuru->tanggal = $request->tanggal;
            $jurnalGuru->materi_yang_disampaikan = $request->materi_yang_disampaikan;
            $jurnalGuru->catatan_pembelajaran = $request->catatan_pembelajaran;
            $jurnalGuru->status_pertemuan = $request->status_pertemuan;
            $jurnalGuru->save();
            
            // Get all students in the class
            $siswaKelas = DataSiswa::where('kelas_id', $jadwalPelajaran->kelas_id)->get();
            $totalSiswa = $siswaKelas->count();
            
            // Calculate attendance statistics
            $siswaTidakHadir = $request->input('siswa_tidak_hadir', []);
            $siswaHadir = $totalSiswa - count($siswaTidakHadir);
            
            // Create Class Attendance Record
            $absensiKelas = new AbsensiKelas();
            $absensiKelas->kelas_id = $jadwalPelajaran->kelas_id;
            $absensiKelas->jadwal_pelajaran_id = $jadwalPelajaran->id;
            $absensiKelas->guru_id = $guru->id;
            $absensiKelas->tanggal = $request->tanggal;
            $absensiKelas->jam_mulai = $jadwalPelajaran->jam_mulai;
            $absensiKelas->jam_selesai = $jadwalPelajaran->jam_selesai;
            $absensiKelas->total_siswa = $totalSiswa;
            $absensiKelas->siswa_hadir = $siswaHadir;
            $absensiKelas->siswa_tidak_hadir = count($siswaTidakHadir);
            $absensiKelas->status_kelas = $request->status_pertemuan;
            $absensiKelas->catatan = $request->catatan_pembelajaran;
            $absensiKelas->save();
            
            DB::commit();
            
            return redirect()->route('jurnal-guru.index')
                ->with('success', 'Jurnal pembelajaran berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan jurnal: ' . $e->getMessage());
        }
    }

    // Method to generate class attendance report
    public function laporanAbsensiKelas(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', now()->subMonth()->format('Y-m-d'));
        $tanggalSelesai = $request->input('tanggal_selesai', now()->format('Y-m-d'));
        $kelasId = $request->input('kelas_id');
        
        $query = AbsensiKelas::query();
        
        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }
        
        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }
        
        $absensiKelas = $query->with(['kelas', 'jadwalPelajaran', 'guru'])
                              ->orderBy('tanggal', 'desc')
                              ->paginate(15);
        
        $kelas = Kelas::all();
        
        // Calculate overall statistics
        $statistik = [
            'total_kelas' => $absensiKelas->count(),
            'total_siswa' => $absensiKelas->sum('total_siswa'),
            'total_hadir' => $absensiKelas->sum('siswa_hadir'),
            'total_tidak_hadir' => $absensiKelas->sum('siswa_tidak_hadir'),
            'persentase_kehadiran' => $absensiKelas->avg('attendance_percentage')
        ];
        
        return view('absensi-kelas.laporan', compact(
            'absensiKelas', 
            'kelas', 
            'statistik', 
            'tanggalMulai', 
            'tanggalSelesai', 
            'kelasId'
        ));
    }
    
    public function show($id)
    {
        $jurnal = JurnalGuru::with(['jadwalPelajaran', 'kelas', 'guru'])->findOrFail($id);
        return view('jurnal_guru.show', compact('jurnal'));
    }
    
    public function edit($id)
    {
        $user = Auth::user();
        $guru = DataGuru::where('user_id', $user->id)->first();
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }
        
        $jurnal = JurnalGuru::findOrFail($id);
        
        // Cek apakah jurnal ini milik guru yang sedang login
        if ($jurnal->guru_id != $guru->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit jurnal ini.');
        }
        
        $jadwalPelajaran = JadwalPelajaran::where('guru_id', $guru->id)
            ->with('kelas')
            ->get();
            
        return view('jurnal_guru.edit', compact('jurnal', 'jadwalPelajaran'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'jadwal_pelajaran_id' => 'required|exists:jadwal_pelajaran,id',
            'tanggal' => 'required|date',
            'materi_yang_disampaikan' => 'required|string',
            'siswa_hadir' => 'nullable|array',
            'siswa_tidak_hadir' => 'nullable|array',
            'keterangan_tidak_hadir' => 'nullable|array',
            'status_pertemuan' => 'required|in:Terlaksana,Diganti,Dibatalkan',
            'catatan_pembelajaran' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            $jadwalPelajaran = JadwalPelajaran::findOrFail($request->jadwal_pelajaran_id);
            
            // Update Jurnal
            $jurnalGuru = JurnalGuru::findOrFail($id);
            $jurnalGuru->jadwal_pelajaran_id = $request->jadwal_pelajaran_id;
            $jurnalGuru->kelas_id = $jadwalPelajaran->kelas_id;
            $jurnalGuru->tanggal = $request->tanggal;
            $jurnalGuru->materi_yang_disampaikan = $request->materi_yang_disampaikan;
            $jurnalGuru->catatan_pembelajaran = $request->catatan_pembelajaran;
            $jurnalGuru->status_pertemuan = $request->status_pertemuan;
            $jurnalGuru->save();
            
            // Remove existing attendances for this date and class
            Absensi::where('waktu_scan', 'LIKE', $request->tanggal . '%')
                ->whereHas('siswa', function($query) use ($jadwalPelajaran) {
                    $query->where('kelas_id', $jadwalPelajaran->kelas_id);
                })
                ->delete();
            
            // Handle Student Attendance
            $siswaTidakHadir = $request->input('siswa_tidak_hadir', []);
            $keteranganTidakHadir = $request->input('keterangan_tidak_hadir', []);
            
            // Get all students in the class
            $siswaKelas = DataSiswa::where('kelas_id', $jadwalPelajaran->kelas_id)->get();
            
            foreach ($siswaKelas as $siswa) {
                $absensi = new Absensi();
                $absensi->siswa_id = $siswa->id;
                $absensi->waktu_scan = Carbon::parse($request->tanggal)->setTime(date('H'), date('i'), date('s'));
                
                if (in_array($siswa->id, $siswaTidakHadir)) {
                    $absensi->status = 'Tidak Hadir';
                    $absensi->keterangan = $keteranganTidakHadir[$siswa->id] ?? null;
                } else {
                    $absensi->status = 'Hadir';
                }
                
                $absensi->save();
            }
            
            DB::commit();
            
            return redirect()->route('jurnal-guru.index')
                ->with('success', 'Jurnal pembelajaran dan absensi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui jurnal: ' . $e->getMessage());
        }
    }

    // Add a method to generate attendance report
    public function laporanAbsensi(Request $request)
    {
        $user = Auth::user();
        $guru = DataGuru::where('user_id', $user->id)->first();
        
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $kelasId = $request->input('kelas_id');
        
        $query = Absensi::query();
        
        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('waktu_scan', [$tanggalMulai, $tanggalSelesai]);
        }
        
        if ($kelasId) {
            $query->whereHas('siswa', function($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }
        
        $absensi = $query->with(['siswa', 'siswa.kelas'])
                        ->orderBy('waktu_scan', 'desc')
                        ->paginate(15);
        
        $kelas = Kelas::all();
        
        // Hitung statistik absensi
        $statistikAbsensi = $absensi->groupBy('status')->map(function($group) {
            return $group->count();
        });
        
        return view('absensi.laporan', compact('absensi', 'kelas', 'statistikAbsensi', 'tanggalMulai', 'tanggalSelesai', 'kelasId'));
    }

    
    public function destroy($id)
    {
        $jurnal = JurnalGuru::findOrFail($id);
        $jurnal->delete();
        
        return redirect()->route('jurnal-guru.index')
            ->with('success', 'Jurnal pembelajaran berhasil dihapus.');
    }
    
    public function laporanJurnal(Request $request)
    {
        $user = Auth::user();
        $guru = DataGuru::where('user_id', $user->id)->first();
        
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $kelasId = $request->input('kelas_id');
        
        $query = JurnalGuru::query();
        
        if ($guru && !Auth::user()->hasRole('admin')) {
            $query->where('guru_id', $guru->id);
        }
        
        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }
        
        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }
        
        $jurnals = $query->with(['jadwalPelajaran', 'kelas', 'guru'])
                        ->orderBy('tanggal', 'desc')
                        ->paginate(15);
                        
        $kelas = Kelas::all();
        $allGuru = DataGuru::all();
        
        return view('jurnal_guru.laporan', compact('jurnals', 'kelas', 'guru', 'allGuru', 'tanggalMulai', 'tanggalSelesai', 'kelasId'));
    }
}