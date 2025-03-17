<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\DataGuru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with('sekolah', 'siswa');
    
        if ($request->filled('sekolah')) {
            $query->where('sekolah_id', $request->sekolah);
        }
    
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
    
        $kelas = $query->latest()->paginate(10);
    
        // Update remaining capacity for each class
       
        $kelas->appends($request->query());
    
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $sekolahs = Sekolah::all();
        $guru = DataGuru::all();
        return view('kelas.create', compact('sekolahs', 'guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nama_kelas' => 'required|string',
            'tingkat' => 'required|string',
            'jurusan' => 'nullable|string',
            'kapasitas' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|string',
            'wali_kelas' => 'nullable|string',
        ]);

        Kelas::create($validated);
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function show(Kelas $kelas)
    {
        $kelas->load('sekolah', 'siswa');
        $kelas->updateRemainingCapacity();
        return view('kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        $sekolahs = Sekolah::all();
        $guru = DataGuru::all();
        return view('kelas.edit', compact('kelas', 'sekolahs', 'guru'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nama_kelas' => 'required|string',
            'tingkat' => 'required|string',
            'jurusan' => 'nullable|string',
            'kapasitas' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|string',
            'wali_kelas' => 'nullable|string',
        ]);

        $kelas->update($validated);
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus');
    }

    public function indexBySchool(Request $request)
{
    // Get the current user's school_id from auth
    $schoolId = auth()->user()->sekolah_id;
    
    // Query classes only for this school
    $query = Kelas::with('sekolah', 'siswa')
                ->where('sekolah_id', $schoolId);
    
    // Apply filters if provided
    if ($request->filled('tingkat')) {
        $query->where('tingkat', $request->tingkat);
    }
    
    $kelas = $query->latest()->paginate(10);
    $kelas->appends($request->query());
    
    return view('school.kelas.index', compact('kelas'));
}

public function createBySchool()
{
    // Get the current user's school_id
    $schoolId = auth()->user()->sekolah_id;
    
    // Get the school data
    $sekolah = Sekolah::findOrFail($schoolId);
    
    // Get only teachers from this school
    $guru = DataGuru::where('sekolah_id', $schoolId)->get();
    
    return view('school.kelas.create_school', compact('sekolah', 'guru'));
}

public function storeBySchool(Request $request)
{
    // Get the current user's school_id
    $schoolId = auth()->user()->sekolah_id;
    
    $validated = $request->validate([
        'nama_kelas' => 'required|string',
        'tingkat' => 'required|string',
        'jurusan' => 'nullable|string',
        'kapasitas' => 'required|integer',
        'tahun_ajaran' => 'required|string',
        'semester' => 'required|string',
        'wali_kelas' => 'nullable|string',
    ]);
    
    // Set the school_id to the user's school
    $validated['sekolah_id'] = $schoolId;
    
    Kelas::create($validated);
    return redirect()->route('kelas.school.index')->with('success', 'Data kelas berhasil ditambahkan');
}

public function showBySchool(Kelas $kelas)
{
    $kelas->load('sekolah', 'siswa');
    $kelas->updateRemainingCapacity();
    return view('kelas.show_school', compact('kelas'));
}

public function editBySchool(Kelas $kelas)
{
    // Get the current user's school_id
    $schoolId = auth()->user()->sekolah_id;
    
    // Get the school data
    $sekolah = Sekolah::findOrFail($schoolId);
    
    // Get only teachers from this school
    $guru = DataGuru::where('sekolah_id', $schoolId)->get();
    
    return view('kelas.edit_school', compact('kelas', 'sekolah', 'guru'));
}

public function updateBySchool(Request $request, Kelas $kelas)
{
    $validated = $request->validate([
        'sekolah_id' => 'required|exists:sekolahs,id',
        'nama_kelas' => 'required|string',
        'tingkat' => 'required|string',
        'jurusan' => 'nullable|string',
        'kapasitas' => 'required|integer',
        'tahun_ajaran' => 'required|string',
        'semester' => 'required|string',
        'wali_kelas' => 'nullable|string',
    ]);

    $kelas->update($validated);
    return redirect()->route('kelas.school.index')->with('success', 'Data kelas berhasil diperbarui');
}

public function destroyBySchool(Kelas $kelas)
{
    $kelas->delete();
    return redirect()->route('kelas.school.index')->with('success', 'Data kelas berhasil dihapus');
}
}