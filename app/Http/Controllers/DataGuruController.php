<?php

namespace App\Http\Controllers;

use App\Models\DataGuru;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DataGuruController extends Controller
{
    public function create()
    {
        // Get the authenticated user
        $user = auth()->user();
        
        // Check if the user has a school
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        // If no school is associated with this user, redirect with error
        if (!$sekolah) {
            return redirect()->route('adminguru.index')
                ->with('error', 'Anda tidak memiliki akses untuk menambahkan guru');
        }
        
        return view('adminguru.create', compact('sekolah'));
    }
    
    public function store(Request $request)
    {
        // Get the authenticated user's school
        $user = auth()->user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        // If no school is found, redirect with error
        if (!$sekolah) {
            return redirect()->route('adminguru.index')
                ->with('error', 'Anda tidak memiliki akses untuk menambahkan guru');
        }
        
        $request->validate([
            // Remove sekolah_id from validation since it will be set automatically
            'nip' => 'nullable|string|size:18|unique:data_guru',
            'nuptk' => 'nullable|string|size:16|unique:data_guru',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|size:16|unique:data_guru',
            'status_kepegawaian' => 'required|in:PNS,PPPK,Honorer,GTY,GTT',
            'pendidikan_terakhir' => 'required|string',
            'jurusan_pendidikan' => 'required|string',
            'tmt_kerja' => 'required|date',
            'mata_pelajaran' => 'required|array',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);
    
        $guruData = $request->except(['email', 'password', 'foto', 'sekolah_id']);
        $guruData['user_id'] = $user->id;
        $guruData['sekolah_id'] = $sekolah->id; // Set the school ID from the authenticated user
        $guruData['mata_pelajaran'] = json_encode($request->mata_pelajaran);
    
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = Str::slug($request->nama_lengkap) . '-' . time() . '.' . $foto->getClientOriginalExtension();
            $fotoPath = $foto->storeAs('public/guru-photos', $fotoName);
            $guruData['foto'] = $fotoName;
        }
    
        DataGuru::create($guruData);
    
        return redirect()->route('adminguru.index')->with('success', 'Data guru berhasil ditambahkan');
    }
    
    public function edit(DataGuru $guru)
{
    // Get the authenticated user's school
    $user = auth()->user();
    $sekolah = Sekolah::where('user_id', $user->id)->first();
    
    // Check if the guru belongs to the user's school
    if ($guru->sekolah_id != $sekolah->id) {
        return redirect()->route('adminguru.index')
            ->with('error', 'Anda tidak memiliki akses untuk mengedit guru ini');
    }
    
    return view('adminguru.edit', compact('guru', 'sekolah'));
}

public function update(Request $request, DataGuru $guru)
{
    // Get the authenticated user's school
    $user = auth()->user();
    $sekolah = Sekolah::where('user_id', $user->id)->first();
    
    // Check if the guru belongs to the user's school
    if ($guru->sekolah_id != $sekolah->id) {
        return redirect()->route('adminguru.index')
            ->with('error', 'Anda tidak memiliki akses untuk mengedit guru ini');
    }
    
    $request->validate([
        // Remove sekolah_id from validation
        'nip' => 'nullable|string|size:18|unique:data_guru,nip,'.$guru->id,
        'nuptk' => 'nullable|string|size:16|unique:data_guru,nuptk,'.$guru->id,
        'nama_lengkap' => 'required|string',
        'jenis_kelamin' => 'required|in:L,P',
        'tempat_lahir' => 'required|string',
        'tanggal_lahir' => 'required|date',
        'nik' => 'required|string|size:16|unique:data_guru,nik,'.$guru->id,
        'status_kepegawaian' => 'required|in:PNS,PPPK,Honorer,GTY,GTT',
        'pendidikan_terakhir' => 'required|string',
        'jurusan_pendidikan' => 'required|string',
        'alamat' => 'required|string',
        'no_hp' => 'required|string',
        'tmt_kerja' => 'required|date',
        'mata_pelajaran' => 'required|array',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($guru->nama_lengkap !== $request->nama_lengkap) {
        $guru->user->update(['name' => $request->nama_lengkap]);
    }

    $guruData = $request->except(['foto', 'sekolah_id']);
    $guruData['mata_pelajaran'] = json_encode($request->mata_pelajaran);
    // School ID remains unchanged as it's tied to the logged-in school

    if ($request->hasFile('foto')) {
        if ($guru->foto) {
            Storage::delete('public/guru-photos/' . $guru->foto);
        }

        $foto = $request->file('foto');
        $fotoName = 'guru_' . time() . '.' . $foto->getClientOriginalExtension();
        $foto->storeAs('public/guru-photos', $fotoName);
        $guruData['foto'] = $fotoName;
    }

    $guru->update($guruData);
    return redirect()->route('adminguru.index')->with('success', 'Data guru berhasil diperbarui');
}
    
    public function destroy(DataGuru $guru)
    {
        // Get the authenticated user's school
        $user = auth()->user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        // Check if the guru belongs to the user's school
        if ($guru->sekolah_id != $sekolah->id) {
            return redirect()->route('adminguru.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus guru ini');
        }
        
        if ($guru->foto) {
            Storage::delete('public/guru-photos/' . $guru->foto);
        }
    
        if ($guru->user) {
            $guru->user->delete();
        }
    
        $guru->delete();
        return redirect()->route('adminguru.index')->with('success', 'Data guru berhasil dihapus');
    }
    
    public function index(Request $request)
    {
        // Get the authenticated user's school
        $user = auth()->user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        // Initialize query
        $query = DataGuru::with(['user', 'sekolah']);
        
        // If admin, show all. If school, filter by school ID
        if ($user->role !== 'admin') {
            $query->where('sekolah_id', $sekolah->id);
        }
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'like', "%{$search}%");
            });
        }
        
        // Apply school filter
        if ($request->has('sekolah_id') && !empty($request->sekolah_id)) {
            $query->where('sekolah_id', $request->sekolah_id);
        }
        
        // Apply mata pelajaran filter
        if ($request->has('mapel') && !empty($request->mapel)) {
            $mapel = $request->mapel;
            $query->where('mata_pelajaran', 'like', "%{$mapel}%");
        }
        
        // Get data with pagination
        $guru = $query->latest()->paginate(10);
        
        // Get list of schools for filter dropdown (admin only)
        $sekolahList = ($user->role === 'admin') ? Sekolah::all() : null;
        
        // Get unique mata pelajaran for filter dropdown
        $mapelList = $this->getUniqueMapel();
        
        // Get statistics
        $totalGuru = $query->count();
        $totalMapel = count($mapelList);
        $totalSekolah = ($user->role === 'admin') ? Sekolah::count() : 1;
        
        return view('adminguru.index', compact('guru', 'sekolahList', 'mapelList', 'totalGuru', 'totalMapel', 'totalSekolah'));
    }
    
    /**
     * Get unique mata pelajaran from all teachers
     */
    private function getUniqueMapel()
    {
        $allMapel = [];
        $guruList = DataGuru::all();
        
        foreach ($guruList as $guru) {
            $mapel = json_decode($guru->mata_pelajaran, true);
            if (is_array($mapel)) {
                $allMapel = array_merge($allMapel, $mapel);
            }
        }
        
        return array_unique($allMapel);
    }

    public function show (DataGuru $guru)
    {
        return view('adminguru.show', compact('guru'));
    }
}