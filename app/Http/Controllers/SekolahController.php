<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolahs = Sekolah::latest()->paginate(10);
        return view('sekolah.index', compact('sekolahs'));
    }

    public function create()
    {
        // Mengambil data provinsi, kota, kecamatan, dan kelurahan
        $provinces = Province::all();
        $cities = Regency::all();
        $districts = District::all();
        $villages = Village::all();

        return view('sekolah.create', compact('provinces', 'cities', 'districts', 'villages'));
    }
   

    /**
     * Menyimpan data Sekolah yang baru.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'npsn' => 'required|string|size:8|unique:sekolahs,npsn',
            'nama_sekolah' => 'required|string',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'status' => 'required|in:Negeri,Swasta',
            'alamat' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'kode_pos' => 'required|string|size:5',
            'no_telp' => 'required|string',
            'email' => 'required|email|unique:sekolahs,email',
            'website' => 'nullable|url',
            'akreditasi' => 'nullable|string',
            'kepala_sekolah' => 'required|string',
            'nip_kepala_sekolah' => 'nullable|string|max:18',
        ]);

        // Menyimpan data Sekolah
        Sekolah::create([
            'npsn' => $request->npsn,
            'nama_sekolah' => $request->nama_sekolah,
            'jenjang' => $request->jenjang,
            'status' => $request->status,
            'alamat' => $request->alamat,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'kode_pos' => $request->kode_pos,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'website' => $request->website,
            'akreditasi' => $request->akreditasi,
            'kepala_sekolah' => $request->kepala_sekolah,
            'nip_kepala_sekolah' => $request->nip_kepala_sekolah,
        ]);

        return redirect()->route('sekolah.index')->with('success', 'Sekolah berhasil ditambahkan!');
    }

    public function show(Sekolah $sekolah)
    {
        return view('sekolah.show', compact('sekolah'));
    }

    public function edit(Sekolah $sekolah)
    {
        // Mengambil data provinsi, kota, kecamatan, dan kelurahan
        $provinces = Province::all();
        $cities = Regency::all();
        $districts = District::all();
        $villages = Village::all();

        return view('sekolah.edit', compact('sekolah', 'provinces', 'cities', 'districts', 'villages'));
    }

    /**
     * Memperbarui data Sekolah.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sekolah $sekolah
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        // Validasi data
        $request->validate([
            'npsn' => 'required|string|size:8|unique:sekolahs,npsn,' . $sekolah->id,
            'nama_sekolah' => 'required|string',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'status' => 'required|in:Negeri,Swasta',
            'alamat' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'kode_pos' => 'required|string|size:5',
            'no_telp' => 'required|string',
            'email' => 'required|email|unique:sekolahs,email,' . $sekolah->id,
            'website' => 'nullable|url',
            'akreditasi' => 'nullable|string',
            'kepala_sekolah' => 'required|string',
            'nip_kepala_sekolah' => 'nullable|string|max:18',
        ]);

        // Memperbarui data Sekolah
        $sekolah->update([
            'npsn' => $request->npsn,
            'nama_sekolah' => $request->nama_sekolah,
            'jenjang' => $request->jenjang,
            'status' => $request->status,
            'alamat' => $request->alamat,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'kode_pos' => $request->kode_pos,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'website' => $request->website,
            'akreditasi' => $request->akreditasi,
            'kepala_sekolah' => $request->kepala_sekolah,
            'nip_kepala_sekolah' => $request->nip_kepala_sekolah,
        ]);

        return redirect()->route('sekolah.index')->with('success', 'Sekolah berhasil diperbarui!');
    }

    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();
        return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil dihapus');
    }
}