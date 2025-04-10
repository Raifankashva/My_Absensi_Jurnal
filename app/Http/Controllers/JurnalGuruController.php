<?php

namespace App\Http\Controllers;

use App\Models\JurnalGuru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\DataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'jumlah_siswa_hadir' => 'required|integer|min:0',
            'jumlah_siswa_tidak_hadir' => 'required|integer|min:0',
            'data_siswa_tidak_hadir' => 'nullable|array',
            'status_pertemuan' => 'required|in:Terlaksana,Diganti,Dibatalkan',
            'catatan_pembelajaran' => 'nullable|string',
        ]);
        
        $jadwalPelajaran = JadwalPelajaran::findOrFail($request->jadwal_pelajaran_id);
        
        $jurnalGuru = new JurnalGuru();
        $jurnalGuru->jadwal_pelajaran_id = $request->jadwal_pelajaran_id;
        $jurnalGuru->guru_id = $jadwalPelajaran->guru_id;
        $jurnalGuru->kelas_id = $jadwalPelajaran->kelas_id;
        $jurnalGuru->tanggal = $request->tanggal;
        $jurnalGuru->materi_yang_disampaikan = $request->materi_yang_disampaikan;
        $jurnalGuru->catatan_pembelajaran = $request->catatan_pembelajaran;
        $jurnalGuru->jumlah_siswa_hadir = $request->jumlah_siswa_hadir;
        $jurnalGuru->jumlah_siswa_tidak_hadir = $request->jumlah_siswa_tidak_hadir;
        $jurnalGuru->data_siswa_tidak_hadir = $request->data_siswa_tidak_hadir;
        $jurnalGuru->status_pertemuan = $request->status_pertemuan;
        $jurnalGuru->save();
        
        return redirect()->route('jurnal-guru.index')
            ->with('success', 'Jurnal pembelajaran berhasil disimpan.');
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
        $jurnal = JurnalGuru::findOrFail($id);
        
        $request->validate([
            'jadwal_pelajaran_id' => 'required|exists:jadwal_pelajaran,id',
            'tanggal' => 'required|date',
            'materi_yang_disampaikan' => 'required|string',
            'jumlah_siswa_hadir' => 'required|integer|min:0',
            'jumlah_siswa_tidak_hadir' => 'required|integer|min:0',
            'data_siswa_tidak_hadir' => 'nullable|array',
            'status_pertemuan' => 'required|in:Terlaksana,Diganti,Dibatalkan',
            'catatan_pembelajaran' => 'nullable|string',
        ]);
        
        $jadwalPelajaran = JadwalPelajaran::findOrFail($request->jadwal_pelajaran_id);
        
        $jurnal->jadwal_pelajaran_id = $request->jadwal_pelajaran_id;
        $jurnal->kelas_id = $jadwalPelajaran->kelas_id;
        $jurnal->tanggal = $request->tanggal;
        $jurnal->materi_yang_disampaikan = $request->materi_yang_disampaikan;
        $jurnal->catatan_pembelajaran = $request->catatan_pembelajaran;
        $jurnal->jumlah_siswa_hadir = $request->jumlah_siswa_hadir;
        $jurnal->jumlah_siswa_tidak_hadir = $request->jumlah_siswa_tidak_hadir;
        $jurnal->data_siswa_tidak_hadir = $request->data_siswa_tidak_hadir;
        $jurnal->status_pertemuan = $request->status_pertemuan;
        $jurnal->save();
        
        return redirect()->route('jurnal-guru.index')
            ->with('success', 'Jurnal pembelajaran berhasil diperbarui.');
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