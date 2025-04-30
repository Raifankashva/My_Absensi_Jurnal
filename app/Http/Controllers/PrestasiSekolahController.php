<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\PrestasiSekolah;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PrestasiSekolahController extends Controller
{
    public function index()
    {
        $userSchool = Sekolah::where('user_id', Auth::id())->first();

        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }

        $prestasi = PrestasiSekolah::where('sekolah_id', $userSchool->id)
        ->with(['guru', 'siswa'])
        ->latest()
        ->paginate(10);
    
    return view('prestasi.index', compact('prestasi', 'userSchool'));
    
    }

    public function create()
    {
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses');
        }

        return view('prestasi.create', compact('userSchool'));
    }

    public function store(Request $request)
{
    $userSchool = Sekolah::where('user_id', Auth::id())->first();
    if (!$userSchool) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses');
    }

    $validator = Validator::make($request->all(), [
        'nama_prestasi' => 'required|string|max:255',
        'tingkat' => 'required|string',
        'tahun' => 'required|integer',
        'penyelenggara' => 'nullable|string',
        'deskripsi' => 'nullable|string',
        'foto_prestasi' => 'nullable|array',
        'foto_prestasi.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->route('prestasi.create')
                         ->withErrors($validator)
                         ->withInput();
    }

    // Ambil data dan tambahkan sekolah_id
    $data = $request->only('nama_prestasi', 'tingkat', 'tahun', 'penyelenggara', 'deskripsi');
    $data['sekolah_id'] = $userSchool->id;

    // Simpan foto jika ada
    if ($request->hasFile('foto_prestasi')) {
        $fotoPaths = [];
        foreach ($request->file('foto_prestasi') as $file) {
            $fotoPaths[] = $file->store('prestasi');
        }
        $data['foto_prestasi'] = $fotoPaths;
    }
    $fotoPaths[] = $file->store('prestasi', 'public');

    PrestasiSekolah::create($data);

    return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil ditambahkan');
}


    // Tambahkan show, edit, update, destroy sesuai kebutuhan
    public function show($id)
{
    $userSchool = Sekolah::where('user_id', Auth::id())->firstOrFail();
    $prestasi = PrestasiSekolah::where('sekolah_id', $userSchool->id)->findOrFail($id);
    return view('prestasi.show', compact('prestasi'));
}

public function edit($id)
{
    $userSchool = Sekolah::where('user_id', Auth::id())->firstOrFail();
    $prestasi = PrestasiSekolah::where('sekolah_id', $userSchool->id)->findOrFail($id);
    return view('prestasi.edit', compact('prestasi'));
}

public function update(Request $request, $id)
{
    $userSchool = Sekolah::where('user_id', Auth::id())->firstOrFail();
    $prestasi = PrestasiSekolah::where('sekolah_id', $userSchool->id)->findOrFail($id);

    $validator = Validator::make($request->all(), [
        'nama_prestasi' => 'required|string|max:255',
        'tingkat' => 'required|string',
        'tahun' => 'required|integer',
        'penyelenggara' => 'nullable|string',
        'deskripsi' => 'nullable|string',
        'foto_prestasi' => 'nullable|array',
        'foto_prestasi.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $data = $request->only('nama_prestasi', 'tingkat', 'tahun', 'penyelenggara', 'deskripsi');

    if ($request->hasFile('foto_prestasi')) {
        // Hapus foto lama
        foreach ((array) $prestasi->foto_prestasi as $foto) {
            Storage::disk('public')->delete($foto);
        }

        $fotoPaths = [];
        foreach ($request->file('foto_prestasi') as $file) {
            $fotoPaths[] = $file->store('prestasi', 'public');
        }
        $data['foto_prestasi'] = $fotoPaths;
    }

    $prestasi->update($data);

    return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil diperbarui');
}

public function destroy($id)
{
    $userSchool = Sekolah::where('user_id', Auth::id())->firstOrFail();
    $prestasi = PrestasiSekolah::where('sekolah_id', $userSchool->id)->findOrFail($id);

    if ($prestasi->foto_prestasi) {
        foreach ((array) $prestasi->foto_prestasi as $foto) {
            Storage::disk('public')->delete($foto);
        }
    }

    $prestasi->delete();

    return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil dihapus');
}
}
