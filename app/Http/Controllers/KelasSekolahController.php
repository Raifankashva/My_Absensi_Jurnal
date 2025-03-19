<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\DataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasSekolahController extends Controller
{
    public function index(Request $request)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Start query with school filter automatically applied
        $query = Kelas::with('sekolah', 'siswa')
            ->where('sekolah_id', $userSchool->id);
        
        // Additional filters
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        
        $kelas = $query->latest()->paginate(10);
        $kelas->appends($request->query());
        
        return view('kelassekolah.index', compact('kelas', 'userSchool'));
    }

    public function create()
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Get only teachers from the same school
        $guru = DataGuru::where('sekolah_id', $userSchool->id)->get();
        
        return view('kelassekolah.create', compact('userSchool', 'guru'));
    }

    public function store(Request $request)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        $validated = $request->validate([
            'nama_kelas' => 'required|string',
            'tingkat' => 'required|string',
            'jurusan' => 'nullable|string',
            'kapasitas' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|string',
            'wali_kelas' => 'nullable|string',
        ]);
        
        // Add school_id automatically
        $validated['sekolah_id'] = $userSchool->id;
        
        Kelas::create($validated);
        return redirect()->route('kelassekolah.index')->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Find class and ensure it belongs to the user's school
        $kelas = Kelas::where('id', $id)
            ->where('sekolah_id', $userSchool->id)
            ->with('sekolah', 'siswa')
            ->firstOrFail();
            
        if ($kelas) {
            $kelas->updateRemainingCapacity();
            return view('kelassekolah.show', compact('kelas'));
        }
        
        return redirect()->route('kelassekolah.index')->with('error', 'Data kelas tidak ditemukan');
    }

    public function edit($id)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Find class and ensure it belongs to the user's school
        $kelas = Kelas::where('id', $id)
            ->where('sekolah_id', $userSchool->id)
            ->firstOrFail();
            
        // Get only teachers from the same school
        $guru = DataGuru::where('sekolah_id', $userSchool->id)->get();
        
        return view('kelassekolah.edit', compact('kelas', 'userSchool', 'guru'));
    }

    public function update(Request $request, $id)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Find class and ensure it belongs to the user's school
        $kelas = Kelas::where('id', $id)
            ->where('sekolah_id', $userSchool->id)
            ->firstOrFail();
            
        $validated = $request->validate([
            'nama_kelas' => 'required|string',
            'tingkat' => 'required|string',
            'jurusan' => 'nullable|string',
            'kapasitas' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|string',
            'wali_kelas' => 'nullable|string',
        ]);
        
        // School ID cannot be changed, always use the logged-in user's school
        $validated['sekolah_id'] = $userSchool->id;
        
        $kelas->update($validated);
        return redirect()->route('kelassekolah.index')->with('success', 'Data kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Find class and ensure it belongs to the user's school
        $kelas = Kelas::where('id', $id)
            ->where('sekolah_id', $userSchool->id)
            ->firstOrFail();
            
        $kelas->delete();
        return redirect()->route('kelassekolah.index')->with('success', 'Data kelas berhasil dihapus');
    }
}