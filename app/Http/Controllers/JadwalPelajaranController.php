<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\DataGuru;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPelajaranController extends Controller
{
    protected function getSekolahId()
    {
        $sekolah = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$sekolah) {
            abort(403, 'Sekolah tidak ditemukan');
        }
        
        return $sekolah->id;
    }

    public function index(Request $request)
    {
        $sekolahId = $this->getSekolahId();

        $query = JadwalPelajaran::with(['kelas', 'guru'])
            // Filter by school ID for both class and teacher
            ->whereHas('kelas', function($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            })
            ->whereHas('guru', function($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            });
        
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
        
        // Get classes for the specific school
        $kelas = Kelas::where('sekolah_id', $sekolahId)->get();
        
        // Days array for filter
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        return view('jadwal_pelajaran.index', compact('jadwalPerKelas', 'kelas', 'hariList'));
    }

    public function create()
    {
        $sekolahId = $this->getSekolahId();

        // Filter kelas and guru by school ID
        $kelas = Kelas::where('sekolah_id', $sekolahId)->get();
        $guru = DataGuru::where('sekolah_id', $sekolahId)->get();

        return view('jadwal_pelajaran.create', compact('kelas', 'guru'));
    }

    public function store(Request $request)
    {
        $sekolahId = $this->getSekolahId();

        // Validate that the selected class and teacher belong to the school
        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();

        $guru = DataGuru::where('id', $request->guru_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();

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
        $sekolahId = $this->getSekolahId();

        $jadwalPelajaran = JadwalPelajaran::whereHas('kelas', function($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            })
            ->findOrFail($id);

        // Filter kelas and guru by school ID
        $kelas = Kelas::where('sekolah_id', $sekolahId)->get();
        $guru = DataGuru::where('sekolah_id', $sekolahId)->get();
        
        return view('jadwal_pelajaran.edit', compact('jadwalPelajaran', 'kelas', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $sekolahId = $this->getSekolahId();

        $jadwalPelajaran = JadwalPelajaran::whereHas('kelas', function($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            })
            ->findOrFail($id);

        // Additional validation to ensure the selected class and teacher belong to the school
        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();

        $guru = DataGuru::where('id', $request->guru_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();
        
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
        $sekolahId = $this->getSekolahId();

        $jadwalPelajaran = JadwalPelajaran::whereHas('kelas', function($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            })
            ->findOrFail($id);

        $jadwalPelajaran->delete();

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
    
    public function checkJadwalBentrok(Request $request)
    {
        $sekolahId = $this->getSekolahId();

        $request->validate([
            'guru_id' => 'required|exists:data_guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        // Validate that the selected guru and kelas belong to the school
        $guru = DataGuru::where('id', $request->guru_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();

        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();

        // Check for teacher schedule conflict
        $guruBentrok = JadwalPelajaran::where('guru_id', $request->guru_id)
            ->whereHas('guru', function($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            })
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
            ->whereHas('kelas', function($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            })
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