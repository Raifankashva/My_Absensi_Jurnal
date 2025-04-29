<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Sekolah;
use App\Models\RuanganPhoto;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::with('sekolah')->latest()->paginate(10);
        return view('ruangans.index', compact('ruangans'));
    }

    public function create()
    {
        $user = auth()->user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();

        if (!$sekolah) {
            return redirect()->route('ruangans.index')
                ->with('error', 'Anda tidak memiliki akses untuk menambahkan ruangan.');
        }

        return view('ruangans.create', compact('sekolah'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'kode' => 'required',
        'kapasitas' => 'required|integer',
        'lokasi' => 'required',
        'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = auth()->user();
    $sekolah = Sekolah::where('user_id', $user->id)->first();

    $ruangan = Ruangan::create([
        'sekolah_id' => $sekolah->id,
        'nama' => $request->nama,
        'kode' => $request->kode,
        'kapasitas' => $request->kapasitas,
        'lokasi' => $request->lokasi,
    ]);

    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('ruangan_photos', 'public');

            RuanganPhoto::create([
                'ruangan_id' => $ruangan->id,
                'path' => $path,
            ]);
        }
    }

    return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil ditambahkan.');
}

    public function edit(Ruangan $ruangan)
    {
        return view('ruangans.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'nullable|string|max:50',
            'kapasitas' => 'nullable|integer',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $ruangan->update($request->only('nama', 'kode', 'kapasitas', 'lokasi', 'keterangan'));

        return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil diupdate.');
    }
    public function show(Ruangan $ruangan)
    {
        return view('ruangans.show', compact('ruangan'));
    }
    
    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
