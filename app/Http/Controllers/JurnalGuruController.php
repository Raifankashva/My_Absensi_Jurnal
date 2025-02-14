<?php

namespace App\Http\Controllers;

use App\Models\JurnalGuru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JurnalGuruController extends Controller
{
    public function index()
    {
        $guru_id = Auth::user()->guru->id;
        $jurnals = JurnalGuru::with(['kelas'])
            ->where('guru_id', $guru_id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        $guru = Auth::user()->guru;
        $kelas = Kelas::where('sekolah_id', $guru->sekolah_id)->get();
        
        return view('jurnal.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'mata_pelajaran' => 'required|string',
            'materi_pembelajaran' => 'required|string',
            'catatan_kegiatan' => 'required|string',
            'capaian_pembelajaran' => 'nullable|string',
            'jumlah_siswa_hadir' => 'required|integer|min:0',
            'jumlah_siswa_tidak_hadir' => 'required|integer|min:0',
            'keterangan_ketidakhadiran' => 'nullable|string',
            'rencana_pembelajaran_selanjutnya' => 'nullable|string',
            'tanda_tangan' => 'required|image|max:2048', // Max 2MB
        ]);

        // Handle tanda tangan upload
        if ($request->hasFile('tanda_tangan')) {
            $path = $request->file('tanda_tangan')->store('tanda-tangan', 'public');
            $validated['tanda_tangan'] = $path;
        }

        $validated['guru_id'] = Auth::user()->guru->id;
        $validated['status'] = 'submitted';
        $validated['waktu_submit'] = now();

        JurnalGuru::create($validated);

        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil disimpan!');
    }

    public function show(JurnalGuru $jurnal)
    {
        $this->authorize('view', $jurnal);
        return view('jurnal.show', compact('jurnal'));
    }

    public function edit(JurnalGuru $jurnal)
    {
        $this->authorize('update', $jurnal);
        $kelas = Kelas::where('sekolah_id', Auth::user()->guru->sekolah_id)->get();
        
        return view('jurnal.edit', compact('jurnal', 'kelas'));
    }

    public function update(Request $request, JurnalGuru $jurnal)
    {
        $this->authorize('update', $jurnal);
        
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'mata_pelajaran' => 'required|string',
            'materi_pembelajaran' => 'required|string',
            'catatan_kegiatan' => 'required|string',
            'capaian_pembelajaran' => 'nullable|string',
            'jumlah_siswa_hadir' => 'required|integer|min:0',
            'jumlah_siswa_tidak_hadir' => 'required|integer|min:0',
            'keterangan_ketidakhadiran' => 'nullable|string',
            'rencana_pembelajaran_selanjutnya' => 'nullable|string',
            'tanda_tangan' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('tanda_tangan')) {
            // Delete old signature if exists
            if ($jurnal->tanda_tangan) {
                Storage::disk('public')->delete($jurnal->tanda_tangan);
            }
            $path = $request->file('tanda_tangan')->store('tanda-tangan', 'public');
            $validated['tanda_tangan'] = $path;
        }

        $jurnal->update($validated);

        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil diperbarui!');
    }

    public function destroy(JurnalGuru $jurnal)
    {
        $this->authorize('delete', $jurnal);

        if ($jurnal->tanda_tangan) {
            Storage::disk('public')->delete($jurnal->tanda_tangan);
        }

        $jurnal->delete();

        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil dihapus!');
    }
}