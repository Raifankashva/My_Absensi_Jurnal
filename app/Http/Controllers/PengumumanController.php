<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    /**
     * Tampilkan semua pengumuman milik sekolah yang login
     */
    public function index()
    {
        $userSchool = Sekolah::where('user_id', Auth::id())->first();

        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }

        $pengumuman = Pengumuman::where('sekolah_id', $userSchool->id)->latest()->get();

        return view('pengumuman.index', compact('pengumuman'));
    }

    /**
     * Tampilkan form tambah pengumuman
     */
    public function create()
    {
        return view('pengumuman.create');
    }

    /**
     * Simpan pengumuman baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date',
            'lampiran' => 'nullable|file|mimes:pdf,docx,doc,png,jpg,jpeg|max:2048',
            'status' => 'required|in:aktif,arsip',
        ]);

        // Ambil sekolah berdasarkan user yang sedang login
        $userSchool = Sekolah::where('user_id', Auth::id())->first();

        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }

        // Mengambil data dari request dan menambahkan sekolah_id
        $data = $request->only(['judul', 'isi', 'kategori', 'tanggal_mulai', 'tanggal_berakhir', 'status']);
        $data['sekolah_id'] = $userSchool->id; // Menambahkan sekolah_id yang didapat dari sekolah yang login

        // Cek jika ada lampiran yang diupload
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $path = $file->store('lampiran', 'public'); // Simpan di folder "lampiran" dalam disk public
            $data['lampiran'] = $path;
        }

        // Simpan pengumuman
        Pengumuman::create($data);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dibuat');
    }

    /**
     * Tampilkan detail pengumuman
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('pengumuman.show', compact('pengumuman'));
    }

    /**
     * Tampilkan form edit pengumuman
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update data pengumuman
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date',
            'lampiran' => 'nullable|file|mimes:pdf,docx,doc,png,jpg,jpeg|max:2048',
            'status' => 'required|in:aktif,arsip',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        $data = $request->only(['judul', 'isi', 'kategori', 'tanggal_mulai', 'tanggal_berakhir', 'status']);

        // Cek jika ada lampiran yang diupload
        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($pengumuman->lampiran) {
                Storage::disk('public')->delete($pengumuman->lampiran);
            }
            $file = $request->file('lampiran');
            $path = $file->store('lampiran', 'public'); // Simpan di folder "lampiran" dalam disk public
            $data['lampiran'] = $path;
        }

        $pengumuman->update($data);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui');
    }

    /**
     * Hapus pengumuman
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }
}
