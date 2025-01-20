<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswa = DataSiswa::with(['user', 'sekolah', 'kelas'])->latest()->paginate(10);
        return view('adminsiswa.index', compact('siswa'));
    }

    public function create()
    {
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        return view('adminsiswa.create', compact('sekolahs', 'kelas'));
    }
    // Add this method to your existing AdminSiswaController

public function getKelasBySekolah($sekolah_id)
{
    try {
        $kelas = Kelas::where('sekolah_id', $sekolah_id)
                      ->select('id', 'nama_kelas')
                      ->orderBy('nama_kelas')
                      ->get();
                      
        return response()->json($kelas);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Terjadi kesalahan saat memuat data kelas'], 500);
    }
}
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'sekolah_id' => 'required|exists:sekolahs,id',
        'kelas_id' => 'required|exists:kelas,id',
        'nisn' => 'required|string|size:10|unique:data_siswa,nisn',
        'nis' => 'required|string|size:10|unique:data_siswa,nis',
        'nik' => 'required|string|size:16|unique:data_siswa,nik',
        'nama_lengkap' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'agama' => 'required|string|max:50',
        'alamat' => 'required|string|max:255',
        'kelurahan' => 'required|string|max:255',
        'kecamatan' => 'required|string|max:255',
        'kota' => 'required|string|max:255',
        'provinsi' => 'required|string|max:255',
        'kode_pos' => 'required|string|max:5',
        'jenis_tinggal' => 'required|string|max:50',
        'transportasi' => 'required|string|max:50',
        'no_hp' => 'required|string|max:15',
        'email' => 'required|email|max:255|unique:users,email',
        'nama_ayah' => 'required|string|max:255',
        'nik_ayah' => 'nullable|string|max:16',
        'tahun_lahir_ayah' => 'nullable|date_format:Y',
        'pendidikan_ayah' => 'nullable|string|max:50',
        'pekerjaan_ayah' => 'nullable|string|max:50',
        'penghasilan_ayah' => 'required|numeric',
        'nama_ibu' => 'required|string|max:255',
        'nik_ibu' => 'nullable|string|max:16',
        'tahun_lahir_ibu' => 'nullable|date_format:Y',
        'pendidikan_ibu' => 'nullable|string|max:50',
        'pekerjaan_ibu' => 'nullable|string|max:50',
        'penghasilan_ibu' => 'required|numeric',
        'nama_wali' => 'nullable|string|max:255',
        'nik_wali' => 'nullable|string|max:16',
        'tahun_lahir_wali' => 'nullable|date_format:Y',
        'pendidikan_wali' => 'nullable|string|max:50',
        'pekerjaan_wali' => 'nullable|string|max:50',
        'penghasilan_wali' => 'nullable|numeric',
        'tinggi_badan' => 'nullable|numeric',
        'berat_badan' => 'nullable|numeric',
        'jarak_rumah' => 'nullable|numeric',
        'waktu_tempuh' => 'nullable|string|max:50',
        'jumlah_saudara_kandung' => 'nullable|integer',
        'kks' => 'nullable|string|max:20',
        'kph' => 'nullable|string|max:20',
        'kip' => 'nullable|string|max:20',
        'password' => 'required|string|min:8|confirmed', // To confirm password
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
    ]);

    // Create user account
    $user = User::create([
        'name' => $request->nama_lengkap,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'role' => 'siswa'
    ]);

    // Upload photo if exists
    $photoPath = null;
    if ($request->hasFile('foto')) {
        $photoPath = $request->file('foto')->store('public/fotos_siswa');
    }

    // Create siswa data
    $siswaData = $request->except(['email', 'password', 'foto']);
    $siswaData['user_id'] = $user->id;
    $siswaData['foto'] = $photoPath; // Simpan path foto

    DataSiswa::create($siswaData);

    return redirect()->route('adminsiswa.index')->with('success', 'Data siswa berhasil ditambahkan');
}



    public function show(DataSiswa $siswa)
    {
        $siswa->load('user', 'sekolah', 'kelas');
        return view('adminsiswa.show', compact('siswa'));
    }

    public function edit(DataSiswa $siswa)
    {
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        return view('adminsiswa.edit', compact('siswa', 'sekolahs', 'kelas'));
    }

    public function update(Request $request, DataSiswa $siswa)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'kelas_id' => 'required|exists:kelas,id',
            'nisn' => 'required|string|size:10|unique:data_siswa,nisn',
            'nis' => 'required|string|size:10|unique:data_siswa,nis',
            'nik' => 'required|string|size:16|unique:data_siswa,nik',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P', // Assuming 'L' for male and 'P' for female
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:5',
            'jenis_tinggal' => 'required|string|max:50',
            'transportasi' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email',
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'required|string|max:16',
            'tahun_lahir_ayah' => 'required|date_format:Y',
            'pendidikan_ayah' => 'required|string|max:50',
            'pekerjaan_ayah' => 'required|string|max:50',
            'penghasilan_ayah' => 'required|numeric',
            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|string|max:16',
            'tahun_lahir_ibu' => 'required|date_format:Y',
            'pendidikan_ibu' => 'required|string|max:50',
            'pekerjaan_ibu' => 'required|string|max:50',
            'penghasilan_ibu' => 'required|numeric',
            'nama_wali' => 'nullable|string|max:255',
            'nik_wali' => 'nullable|string|max:16',
            'tahun_lahir_wali' => 'nullable|date_format:Y',
            'pendidikan_wali' => 'nullable|string|max:50',
            'pekerjaan_wali' => 'nullable|string|max:50',
            'penghasilan_wali' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'jarak_rumah' => 'nullable|numeric',
            'waktu_tempuh' => 'nullable|string|max:50',
            'jumlah_saudara_kandung' => 'nullable|integer',
            'kks' => 'nullable|string|max:20',
            'kph' => 'nullable|string|max:20',
            'kip' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed', // To confirm password
        ]);
        

        // Update user account
        $user = $siswa->user;
        $user->update([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa'
        ]);

        // Update siswa data
        $siswaData = $request->except(['email', 'password']);
        $siswaData['user_id'] = $user->id;

        $siswa->update($siswaData);
        return redirect()->route('adminsiswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(DataSiswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('adminsiswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}