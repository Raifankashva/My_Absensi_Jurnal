<?php

namespace App\Http\Controllers;

use App\Models\PemeliharaanFasilitas;
use App\Models\FasilitasSekolah;
use Illuminate\Http\Request;

class PemeliharaanFasilitasController extends Controller
{
    // Menampilkan daftar pemeliharaan fasilitas
    public function index()
    {
        $pemeliharaanFasilitas = PemeliharaanFasilitas::with('fasilitasSekolah')->get();
        return view('pemeliharaan_fasilitas.index', compact('pemeliharaanFasilitas'));
    }

    // Menampilkan form untuk membuat pemeliharaan fasilitas baru
    public function create()
    {
        $fasilitasSekolah = FasilitasSekolah::all();
        return view('pemeliharaan_fasilitas.create', compact('fasilitasSekolah'));
    }

    // Menyimpan data pemeliharaan fasilitas baru
    public function store(Request $request)
    {
        $request->validate([
            'fasilitas_sekolah_id' => 'required|exists:fasilitas_sekolah,id',
            'tanggal_pemeliharaan' => 'required|date',
            'jenis_pemeliharaan' => 'required|in:Rutin,Darurat,Perbaikan Besar',
            'status' => 'nullable|in:Selesai,Proses,Tertunda',
            'deskripsi' => 'nullable|string',
        ]);

        PemeliharaanFasilitas::create($request->all());
        return redirect()->route('pemeliharaan_fasilitas.index')->with('success', 'Pemeliharaan Fasilitas berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit pemeliharaan fasilitas
    public function edit($id)
    {
        $pemeliharaanFasilitas = PemeliharaanFasilitas::findOrFail($id);
        $fasilitasSekolah = FasilitasSekolah::all();
        return view('pemeliharaan_fasilitas.edit', compact('pemeliharaanFasilitas', 'fasilitasSekolah'));
    }

    // Memperbarui data pemeliharaan fasilitas
    public function update(Request $request, $id)
    {
        $request->validate([
            'fasilitas_sekolah_id' => 'required|exists:fasilitas_sekolah,id',
            'tanggal_pemeliharaan' => 'required|date',
            'jenis_pemeliharaan' => 'required|in:Rutin,Darurat,Perbaikan Besar',
            'status' => 'nullable|in:Selesai,Proses,Tertunda',
            'deskripsi' => 'nullable|string',
        ]);

        $pemeliharaanFasilitas = PemeliharaanFasilitas::findOrFail($id);
        $pemeliharaanFasilitas->update($request->all());

        return redirect()->route('pemeliharaan_fasilitas.index')->with('success', 'Pemeliharaan Fasilitas berhasil diperbarui!');
    }

    // Menghapus data pemeliharaan fasilitas
    public function destroy($id)
    {
        $pemeliharaanFasilitas = PemeliharaanFasilitas::findOrFail($id);
        $pemeliharaanFasilitas->delete();

        return redirect()->route('pemeliharaan_fasilitas.index')->with('success', 'Pemeliharaan Fasilitas berhasil dihapus!');
    }
    public function show ($id)
    {
        $pemeliharaanFasilitas = PemeliharaanFasilitas::findOrFail($id);
        return view('pemeliharaan_fasilitas.show', compact('pemeliharaanFasilitas'));
    }
}
