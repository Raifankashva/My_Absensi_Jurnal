<?php

namespace App\Http\Controllers;

use App\Models\PengaturanAbsensi;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class PengaturanAbsensiController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanAbsensi::with('sekolah')->get();
        return view('pengaturan_absensi.index', compact('pengaturan'));
    }

    public function create()
    {
        $sekolahs = Sekolah::all();
        return view('pengaturan_absensi.create', compact('sekolahs'));
    }

    public function store(Request $request)
{
    $request->validate([
        'sekolah_id' => 'required|exists:sekolahs,id',
        'jam_masuk' => 'required|date_format:H:i', // Validasi 24 jam
        'jam_pulang' => 'required|date_format:H:i|after:jam_masuk', // Validasi 24 jam
        'batas_terlambat' => 'nullable|date_format:H:i', // Validasi 24 jam
        'status' => 'in:aktif,nonaktif'
    ]);

    // Pastikan data disimpan dengan benar
    PengaturanAbsensi::updateOrCreate(
        ['sekolah_id' => $request->sekolah_id],
        $request->only('jam_masuk', 'jam_pulang', 'batas_terlambat', 'status')
    );

    return redirect()->route('pengaturan-absensi.index')->with('success', 'Pengaturan absensi berhasil disimpan.');
}


    public function show($sekolahId)
    {
        $pengaturan = PengaturanAbsensi::where('sekolah_id', $sekolahId)->firstOrFail();
        return view('pengaturan_absensi.show', compact('pengaturan'));
    }

    public function edit($sekolahId)
    {
        $pengaturan = PengaturanAbsensi::where('sekolah_id', $sekolahId)->firstOrFail();
        $sekolahs = Sekolah::all();
        return view('pengaturan_absensi.edit', compact('pengaturan', 'sekolahs'));
    }

    public function update(Request $request, $sekolahId)
    {
        $pengaturan = PengaturanAbsensi::where('sekolah_id', $sekolahId)->firstOrFail();

        $request->validate([
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i|after:jam_masuk',
            'batas_terlambat' => 'nullable|date_format:H:i',
            'status' => 'in:aktif,nonaktif'
        ]);

        $pengaturan->update($request->only('jam_masuk', 'jam_pulang', 'batas_terlambat', 'status'));

        return redirect()->route('pengaturan-absensi.index')->with('success', 'Pengaturan absensi berhasil diperbarui.');
    }

    public function destroy($sekolahId)
    {
        $pengaturan = PengaturanAbsensi::where('sekolah_id', $sekolahId)->firstOrFail();
        $pengaturan->delete();

        return redirect()->route('pengaturan-absensi.index')->with('success', 'Pengaturan absensi berhasil dihapus.');
    }
}
