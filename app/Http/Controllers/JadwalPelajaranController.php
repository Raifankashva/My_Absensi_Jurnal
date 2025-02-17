<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\DataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        $jadwalPelajaran = JadwalPelajaran::with(['kelas', 'guru'])->get();
        return view('jadwal_pelajaran.index', compact('jadwalPelajaran'));
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
}