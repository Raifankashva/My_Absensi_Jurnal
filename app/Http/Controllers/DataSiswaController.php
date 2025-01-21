<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DataSiswaController extends Controller
{
    public function index(Request $request)
{
    $dataSiswa = DataSiswa::with(['user', 'sekolah', 'kelas', 'province', 'city', 'district', 'village'])
        ->latest()
        ->paginate(10);

    $sekolahs = Sekolah::all(); // Assuming you have a Sekolah model
    $allKelas = Kelas::all();   // Assuming you have a Kelas model

    // Optionally filter based on request inputs
    $groupedStudents = Sekolah::with(['kelas.siswa' => function ($query) use ($request) {
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
    }])->get();

    return view('adminsiswa.index', compact('dataSiswa', 'sekolahs', 'allKelas', 'groupedStudents'));
}


    public function create()
    {
        $sekolahs = Sekolah::all();
        $provinces = Province::all();
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        $livingOptions = ['Ortu', 'Wali', 'Kost', 'Asrama', 'Panti'];
        
        return view('adminsiswa.create', compact('sekolahs', 'provinces', 'religions', 'livingOptions'));
    }

    // Get Kelas based on Sekolah
    public function getKelas($sekolahId)
    {
        $kelas = Kelas::where('sekolah_id', $sekolahId)->get();
        return response()->json($kelas);
    }

    // Get Cities based on Province
    public function getCities($provinceId)
    {
        $cities = Regency::where('province_id', $provinceId)->get();
        return response()->json($cities);
    }

    // Get Districts based on City
    public function getDistricts($cityId)
    {
        $districts = District::where('regency_id', $cityId)->get();
        return response()->json($districts);
    }

    // Get Villages based on District
    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get();
        return response()->json($villages);
    }


public function store(Request $request)
{
    $request->validate([
        // Validasi yang Anda miliki tetap sama
        'sekolah_id' => 'required|exists:sekolahs,id',
        'kelas_id' => 'required|exists:kelas,id',
        'nisn' => 'required|string|max:10|unique:data_siswa',
        'nis' => 'required|string|max:10|unique:data_siswa',
        'nik' => 'required|string|max:16|unique:data_siswa',
        'nama_lengkap' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        'tmp_lahir' => 'required|string',
        'tgl_lahir' => 'required|date',
        'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
        'province_id' => 'required|exists:provinces,id',
        'city_id' => 'required|exists:regencies,id',
        'district_id' => 'required|exists:districts,id',
        'village_id' => 'required|exists:villages,id',
        'kode_pos' => 'required|string|max:5',
        'tinggal' => 'required|in:Ortu,Wali,Kost,Asrama,Panti',
        'transport' => 'required|string',
        'hp' => 'nullable|string',
        'ayah' => 'required|string',
        'kerja_ayah' => 'nullable|string',
        'ibu' => 'required|string',
        'kerja_ibu' => 'nullable|string',
        'wali' => 'nullable|string',
        'kerja_wali' => 'nullable|string',
        'tb' => 'nullable|integer',
        'bb' => 'nullable|integer',
        'kks' => 'nullable|string',
        'kph' => 'nullable|string',
        'kip' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    try {
        DB::beginTransaction();

        // Proses pembuatan data
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->nisn . '@student.sch.id',
            'password' => bcrypt($request->nis),
            'role' => 'siswa',
            'alamat' => $request->village_id . ', ' . $request->district_id,
            'no_hp' => $request->hp ?? '-'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = Str::slug($request->nama_lengkap) . '-' . time() . '.' . $foto->getClientOriginalExtension();
            $fotoPath = $foto->storeAs('public/siswa-photos', $fotoName);
        }

        $dataSiswa = DataSiswa::create([
            'user_id' => $user->id,
            'sekolah_id' => $request->sekolah_id,
            'kelas_id' => $request->kelas_id,
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'foto' => $fotoPath ? str_replace('public/', '', $fotoPath) : null,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'agama' => $request->agama,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'kode_pos' => $request->kode_pos,
            'tinggal' => $request->tinggal,
            'transport' => $request->transport,
            'hp' => $request->hp,
            'ayah' => $request->ayah,
            'kerja_ayah' => $request->kerja_ayah,
            'ibu' => $request->ibu,
            'kerja_ibu' => $request->kerja_ibu,
            'wali' => $request->wali,
            'kerja_wali' => $request->kerja_wali,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'kks' => $request->kks,
            'kph' => $request->kph,
            'kip' => $request->kip,
        ]);

        DB::commit();

        return redirect()
            ->route('adminsiswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');

    } catch (\Exception $e) {
        DB::rollBack();

        // Log the error
        Log::error('Error creating student data', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        if (isset($fotoPath) && Storage::exists($fotoPath)) {
            Storage::delete($fotoPath);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function show($id)
    {
        $dataSiswa = DataSiswa::findOrFail($id);
        $sekolahs = Sekolah::all();
        return view('adminsiswa.show', compact('dataSiswa', 'sekolahs'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $dataSiswa = DataSiswa::findOrFail($id);
            
            // Delete photo if exists
            if ($dataSiswa->foto) {
                Storage::delete('public/' . $dataSiswa->foto);
            }
            
            // Delete associated user
            $dataSiswa->user()->delete();
            
            // Delete student data
            $dataSiswa->delete();

            DB::commit();

            return redirect()
                ->route('adminsiswa.index')
                ->with('success', 'Data siswa berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}