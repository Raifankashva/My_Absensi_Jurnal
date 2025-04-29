<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\DataGuru;
use App\Models\Sekolah;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalPelajaranExport;
use function PHPUnit\Framework\isEmpty;

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

    public function create()
{
    $sekolahId = $this->getSekolahId();

    // Filter kelas, guru, and ruangan by school ID
    $kelas = Kelas::where('sekolah_id', $sekolahId)->get();
    $guru = DataGuru::where('sekolah_id', $sekolahId)->get();
    $ruangans = Ruangan::where('sekolah_id', $sekolahId)->get();

    return view('jadwal_pelajaran.create', compact('kelas', 'guru', 'ruangans'));
}

public function index(Request $request)
{
    $sekolahId = $this->getSekolahId();

    $query = JadwalPelajaran::with(['kelas', 'guru', 'ruangan'])
        // Filter by school ID for class, teacher, and room
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
    
    // Filter by room if selected
    if ($request->filled('ruangan_id')) {
        $query->where('ruangan_id', $request->ruangan_id);
    }
    
    // Get all schedules
    $jadwalPelajaran = $query->get();
    
    // Group schedules by class
    $jadwalPerKelas = $jadwalPelajaran->groupBy('kelas.nama_kelas');
    
    // Get classes for the specific school
    $kelas = Kelas::where('sekolah_id', $sekolahId)->get();
    
    // Get teachers for the specific school (for export filters)
    $guru = DataGuru::where('sekolah_id', $sekolahId)->get();
    
    // Get rooms for the specific school
    $ruangans = Ruangan::where('sekolah_id', $sekolahId)->get();
    
    // Days array for filter
    $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    
    return view('jadwal_pelajaran.index', compact('jadwalPerKelas', 'kelas', 'hariList', 'guru', 'ruangans'));
}

    public function store(Request $request)
{
    $sekolahId = $this->getSekolahId();

    // Validate that the selected class, teacher, and room belong to the school
    $kelas = Kelas::where('id', $request->kelas_id)
        ->where('sekolah_id', $sekolahId)
        ->firstOrFail();

    $guru = DataGuru::where('id', $request->guru_id)
        ->where('sekolah_id', $sekolahId)
        ->firstOrFail();
        
    // Validate room if provided
    if ($request->filled('ruangan_id')) {
        $ruangan = Ruangan::where('id', $request->ruangan_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();
    }

    $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'guru_id' => 'required|exists:data_guru,id',
        'ruangan_id' => 'nullable|exists:ruangans,id',
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

    // Filter kelas, guru, and ruangan by school ID
    $kelas = Kelas::where('sekolah_id', $sekolahId)->get();
    $guru = DataGuru::where('sekolah_id', $sekolahId)->get();
    $ruangans = Ruangan::where('sekolah_id', $sekolahId)->get();
    
    return view('jadwal_pelajaran.edit', compact('jadwalPelajaran', 'kelas', 'guru', 'ruangans'));
}

public function update(Request $request, $id)
{
    $sekolahId = $this->getSekolahId();

    $jadwalPelajaran = JadwalPelajaran::whereHas('kelas', function($q) use ($sekolahId) {
            $q->where('sekolah_id', $sekolahId);
        })
        ->findOrFail($id);

    // Additional validation to ensure the selected class, teacher, and room belong to the school
    $kelas = Kelas::where('id', $request->kelas_id)
        ->where('sekolah_id', $sekolahId)
        ->firstOrFail();

    $guru = DataGuru::where('id', $request->guru_id)
        ->where('sekolah_id', $sekolahId)
        ->firstOrFail();
        
    // Validate room if provided
    if ($request->filled('ruangan_id')) {
        $ruangan = Ruangan::where('id', $request->ruangan_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();
    }
    
    $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'guru_id' => 'required|exists:data_guru,id',
        'ruangan_id' => 'nullable|exists:ruangans,id',
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
        'jam_selesai' => 'required',
        'ruangan_id' => 'nullable|exists:ruangans,id'
    ]);

    // Validate that the selected guru and kelas belong to the school
    $guru = DataGuru::where('id', $request->guru_id)
        ->where('sekolah_id', $sekolahId)
        ->firstOrFail();

    $kelas = Kelas::where('id', $request->kelas_id)
        ->where('sekolah_id', $sekolahId)
        ->firstOrFail();

    // Validate room if provided
    if ($request->filled('ruangan_id')) {
        $ruangan = Ruangan::where('id', $request->ruangan_id)
            ->where('sekolah_id', $sekolahId)
            ->firstOrFail();
    }

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
        
    // Check for room schedule conflict if room is selected
    $ruanganBentrok = false;
    if ($request->filled('ruangan_id')) {
        $ruanganBentrok = JadwalPelajaran::where('ruangan_id', $request->ruangan_id)
            ->whereHas('ruangan', function($q) use ($sekolahId) {
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
    }

    return response()->json([
        'bentrok' => $guruBentrok || $kelasBentrok || $ruanganBentrok,
        'message' => $guruBentrok ? 'Guru sudah memiliki jadwal pada waktu tersebut' : 
                    ($kelasBentrok ? 'Kelas sudah memiliki jadwal pada waktu tersebut' : 
                    ($ruanganBentrok ? 'Ruangan sudah digunakan pada waktu tersebut' : 'Tidak ada bentrok'))
    ]);
}
    /**
 * Export schedules to PDF format
 * 
 * @param Request $request
 * @return \Illuminate\Http\Response
 */
public function exportPDF(Request $request)
{
    $sekolahId = $this->getSekolahId();
    
    // Build the query with filters
    $query = JadwalPelajaran::with(['kelas', 'guru', 'ruangan'])
        ->whereHas('kelas', function($q) use ($sekolahId) {
            $q->where('sekolah_id', $sekolahId);
        })
        ->whereHas('guru', function($q) use ($sekolahId) {
            $q->where('sekolah_id', $sekolahId);
        });
    
    // Apply filters
    if ($request->filled('kelas_id')) {
        $query->where('kelas_id', $request->kelas_id);
    }
    
    if ($request->filled('hari')) {
        $query->where('hari', $request->hari);
    }
    
    if ($request->filled('guru_id')) {
        $query->where('guru_id', $request->guru_id);
    }
    
    if ($request->filled('ruangan_id')) {
        $query->where('ruangan_id', $request->ruangan_id);
    }
    
    // Get data
    $jadwalPelajaran = $query->orderBy('hari')->orderBy('jam_mulai')->get();
    
    // Get school information
    $sekolah = Sekolah::findOrFail($sekolahId);
    
    // Generate PDF with Dompdf
    $pdf = \PDF::loadView('exports.jadwal_pelajaran_pdf', [
        'jadwalPelajaran' => $jadwalPelajaran,
        'sekolah' => $sekolah,
        'filterKelas' => $request->filled('kelas_id') ? Kelas::find($request->kelas_id)->nama_kelas : 'Semua Kelas',
        'filterHari' => $request->filled('hari') ? $request->hari : 'Semua Hari',
        'filterGuru' => $request->filled('guru_id') ? DataGuru::find($request->guru_id)->nama : 'Semua Guru',
        'filterRuangan' => $request->filled('ruangan_id') ? Ruangan::find($request->ruangan_id)->nama : 'Semua Ruangan',
    ]);
    
    // Set the PDF to download with a filename
    $filename = 'jadwal_pelajaran_';
    $filename .= $request->filled('kelas_id') ? Kelas::find($request->kelas_id)->nama_kelas . '_' : '';
    $filename .= $request->filled('hari') ? $request->hari . '_' : '';
    $filename .= $request->filled('ruangan_id') ? Ruangan::find($request->ruangan_id)->nama . '_' : '';
    $filename .= date('Y-m-d') . '.pdf';
    
    return $pdf->download($filename);
}

public function exportExcel(Request $request)
{
    $sekolahId = $this->getSekolahId();
    
    // Build the query with filters
    $query = JadwalPelajaran::with(['kelas', 'guru', 'ruangan'])
        ->whereHas('kelas', function($q) use ($sekolahId) {
            $q->where('sekolah_id', $sekolahId);
        })
        ->whereHas('guru', function($q) use ($sekolahId) {
            $q->where('sekolah_id', $sekolahId);
        });
    
    // Apply filters
    if ($request->filled('kelas_id')) {
        $query->where('kelas_id', $request->kelas_id);
    }
    
    if ($request->filled('hari')) {
        $query->where('hari', $request->hari);
    }
    
    if ($request->filled('guru_id')) {
        $query->where('guru_id', $request->guru_id);
    }
    
    if ($request->filled('ruangan_id')) {
        $query->where('ruangan_id', $request->ruangan_id);
    }
    
    // Get data sorted by day and time
    $jadwalPelajaran = $query->orderBy('hari')->orderBy('jam_mulai')->get();
    
    // Create a custom filename
    $filename = 'jadwal_pelajaran_';
    $filename .= $request->filled('kelas_id') ? Kelas::find($request->kelas_id)->nama_kelas . '_' : '';
    $filename .= $request->filled('hari') ? $request->hari . '_' : '';
    $filename .= $request->filled('ruangan_id') ? Ruangan::find($request->ruangan_id)->nama . '_' : '';
    $filename .= date('Y-m-d') . '.xlsx';
    
    // Export to Excel using Laravel Excel
    return \Excel::download(new \App\Exports\JadwalPelajaranExport($jadwalPelajaran), $filename);
}
}