<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\DataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalPelajaran::with(['kelas', 'guru']);
        
        // Filter by class if selected
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        
        // Filter by day if selected
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }
        
        // Get all schedules
        $jadwalPelajaran = $query->get();
        
        // Group schedules by class
        $jadwalPerKelas = $jadwalPelajaran->groupBy('kelas.nama_kelas');
        
        // Get all classes for filter
        $kelas = Kelas::all();
        
        // Days array for filter
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        return view('jadwal_pelajaran.index', compact('jadwalPerKelas', 'kelas', 'hariList'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $guru = DataGuru::all();
        return view('jadwal_pelajaran.create', compact('kelas', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:data_guru,id',
            'mata_pelajaran' => 'required|string|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        JadwalPelajaran::create($request->all());

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $kelas = Kelas::all();
        $guru = DataGuru::all();
        
        return view('jadwal_pelajaran.edit', compact('jadwalPelajaran', 'kelas', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:data_guru,id',
            'mata_pelajaran' => 'required|string|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwalPelajaran->update($request->all());

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $jadwalPelajaran->delete();

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
    
    public function getJadwalByGuru($guruId)
    {
        $jadwal = JadwalPelajaran::where('guru_id', $guruId)
            ->with('kelas')
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
            
        return response()->json($jadwal);
    }
    
    public function getJadwalHariIni($guruId)
    {
        $hariIni = now()->locale('id')->dayName;
        $jadwalHariIni = JadwalPelajaran::where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->with(['kelas', 'guru'])
            ->orderBy('jam_mulai')
            ->get();
            
        return response()->json($jadwalHariIni);
    }
    // Add this method to JadwalPelajaranController
public function checkJadwalBentrok(Request $request)
{
    $request->validate([
        'guru_id' => 'required|exists:data_guru,id',
        'kelas_id' => 'required|exists:kelas,id',
        'hari' => 'required',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required'
    ]);

    // Check for teacher schedule conflict
    $guruBentrok = JadwalPelajaran::where('guru_id', $request->guru_id)
        ->where('hari', $request->hari)
        ->where(function($query) use ($request) {
            $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                ->orWhere(function($q) use ($request) {
                    $q->where('jam_mulai', '<=', $request->jam_mulai)
                      ->where('jam_selesai', '>=', $request->jam_selesai);
                });
        })
        ->exists();

    // Check for class schedule conflict
    $kelasBentrok = JadwalPelajaran::where('kelas_id', $request->kelas_id)
        ->where('hari', $request->hari)
        ->where(function($query) use ($request) {
            $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                ->orWhere(function($q) use ($request) {
                    $q->where('jam_mulai', '<=', $request->jam_mulai)
                      ->where('jam_selesai', '>=', $request->jam_selesai);
                });
        })
        ->exists();

    return response()->json([
        'bentrok' => $guruBentrok || $kelasBentrok,
        'message' => $guruBentrok ? 'Guru sudah memiliki jadwal pada waktu tersebut' : 
                    ($kelasBentrok ? 'Kelas sudah memiliki jadwal pada waktu tersebut' : 'Tidak ada bentrok')
    ]);
}
}