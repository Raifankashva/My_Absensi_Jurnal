<?php

namespace App\Http\Controllers;

use App\Models\FasilitasSekolah;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FasilitasSekolahController extends Controller
{
    public function index()
    {
        $userSchool = Sekolah::where('user_id', Auth::id())->first();

        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }

        $fasilitas = FasilitasSekolah::where('sekolah_id', $userSchool->id)->get();

        return view('fasilitas.index', compact('fasilitas', 'userSchool'));
    }

    public function create()
    {
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses');
        }

        return view('fasilitas.create', compact('userSchool'));
    }

    public function store(Request $request)
    {
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'kategori' => 'required|in:Akademik,Olahraga,Umum,Teknologi,Kesehatan',
            'jumlah' => 'nullable|integer|min:0',
            'kondisi' => 'required|in:Baik,Cukup,Perlu Perbaikan',
            'deskripsi' => 'nullable|string',
            'foto_fasilitas' => 'nullable|image',
        ]);

        $data = $request->all();
        $data['sekolah_id'] = $userSchool->id;
        $data['foto_fasilitas'] = $request->file('foto_fasilitas')->store('fasilitas', 'public');

        if ($request->hasFile('foto_fasilitas')) {
            $data['foto_fasilitas'] = $request->file('foto_fasilitas')->store('fasilitas');
        }

        FasilitasSekolah::create($data);

        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $fasilitas = FasilitasSekolah::with('riwayatPemeliharaan')->findOrFail($id);
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
    
        if (!$userSchool || $fasilitas->sekolah_id != $userSchool->id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data fasilitas ini');
        }
    
        return view('fasilitas.show', compact('fasilitas', 'userSchool'));
    }
    
    
    public function edit($id)
    {
        $fasilitas = FasilitasSekolah::findOrFail($id);
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
    
        if (!$userSchool || $fasilitas->sekolah_id != $userSchool->id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data fasilitas ini');
        }
    
        return view('fasilitas.edit', compact('fasilitas', 'userSchool'));
    }
    
    public function update(Request $request, $id)
    {
        $fasilitas = FasilitasSekolah::findOrFail($id);
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
    
        if (!$userSchool || $fasilitas->sekolah_id != $userSchool->id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data fasilitas ini');
        }
    
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'kategori' => 'required|in:Akademik,Olahraga,Umum,Teknologi,Kesehatan',
            'jumlah' => 'nullable|integer|min:0',
            'kondisi' => 'required|in:Baik,Cukup,Perlu Perbaikan',
            'deskripsi' => 'nullable|string',
            'foto_fasilitas' => 'nullable|image',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('foto_fasilitas')) {
            $data['foto_fasilitas'] = $request->file('foto_fasilitas')->store('fasilitas');
        }
    
        $fasilitas->update($data);
    
        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $fasilitas = FasilitasSekolah::findOrFail($id);
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
    
        if (!$userSchool || $fasilitas->sekolah_id != $userSchool->id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data fasilitas ini');
        }
    
        $fasilitas->delete();
    
        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
