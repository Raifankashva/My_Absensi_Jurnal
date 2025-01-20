<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataSiswaController extends Controller
{
    public function index()
    {
        $students = DataSiswa::with(['user', 'sekolah', 'kelas', 'province', 'city', 'district', 'village'])
            ->latest()
            ->paginate(10);
            
        // Fetch distinct schools if needed
        $sekolah = Sekolah::all(); // Adjust the query based on your data structure
        
        return view('adminsiswa.index', compact('students', 'sekolah'));
    }
    
    public function create()
    {
        $sekola = Sekolah::all();
        $provinces = Province::all();
        return view('adminsiswa.create')->with('sekola', $sekola)->with('provinces', $provinces); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            
            // Student validation
            'sekolah_id' => 'required|exists:sekolahs,id',
            'kelas_id' => 'required|exists:kelas,id',
            'nisn' => 'required|string|size:10|unique:data_siswa',
            'nis' => 'required|string|size:10|unique:data_siswa',
            'nik' => 'required|string|size:16|unique:data_siswa',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_kelamin' => 'required|in:laki-laki,Perempuan',
            'tmp_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'kode_pos' => 'required|string|size:5',
            'tinggal' => 'required|in:Ortu,Wali,Kost,Asrama,Panti',
            'transport' => 'required|string|max:255',
            'hp' => 'nullable|string|max:255',
            'ayah' => 'required|string|max:255',
            'kerja_ayah' => 'nullable|string|max:255',
            'ibu' => 'required|string|max:255',
            'kerja_ibu' => 'nullable|string|max:255',
            'wali' => 'nullable|string|max:255',
            'kerja_wali' => 'nullable|string|max:255',
            'tb' => 'nullable|integer',
            'bb' => 'nullable|integer',
            'kks' => 'nullable|string|max:255',
            'kph' => 'nullable|string|max:255',
            'kip' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'role' => 'siswa' // Automatically set role as siswa
            ]);

            $data = $request->all();
            $data['user_id'] = $user->id;

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = time() . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('public/student-photos', $filename);
                $data['foto'] = $filename;
            }

            DataSiswa::create($data);

            DB::commit();

            return redirect()->route('adminsiswa.index')
                ->with('success', 'Data siswa berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(DataSiswa $student)
    {
        return view('adminsiswa.show', compact('student'));
    }

    public function edit(DataSiswa $student)
    {
        return view('adminsiswa.edit', compact('student'));
    }

    public function update(Request $request, DataSiswa $student)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'password' => 'nullable|min:6',
            
            // Student validation
            'sekolah_id' => 'required|exists:sekolahs,id',
            'kelas_id' => 'required|exists:kelas,id',
            'nisn' => 'required|string|size:10|unique:data_siswa,nisn,' . $student->id,
            'nis' => 'required|string|size:10|unique:data_siswa,nis,' . $student->id,
            'nik' => 'required|string|size:16|unique:data_siswa,nik,' . $student->id,
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_kelamin' => 'required|in:laki-laki,Perempuan',
            'tmp_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'kode_pos' => 'required|string|size:5',
            'tinggal' => 'required|in:Ortu,Wali,Kost,Asrama,Panti',
            'transport' => 'required|string|max:255',
            'hp' => 'nullable|string|max:255',
            'ayah' => 'required|string|max:255',
            'kerja_ayah' => 'nullable|string|max:255',
            'ibu' => 'required|string|max:255',
            'kerja_ibu' => 'nullable|string|max:255',
            'wali' => 'nullable|string|max:255',
            'kerja_wali' => 'nullable|string|max:255',
            'tb' => 'nullable|integer',
            'bb' => 'nullable|integer',
            'kks' => 'nullable|string|max:255',
            'kph' => 'nullable|string|max:255',
            'kip' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Update user
            $userData = [
                'name' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $student->user->update($userData);

            // Update student
            $data = $request->all();

            if ($request->hasFile('foto')) {
                if ($student->foto) {
                    Storage::delete('public/student-photos/' . $student->foto);
                }
                
                $foto = $request->file('foto');
                $filename = time() . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('public/student-photos', $filename);
                $data['foto'] = $filename;
            }

            $student->update($data);

            DB::commit();

            return redirect()->route('adminsiswa.index')
                ->with('success', 'Data siswa berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(DataSiswa $student)
    {
        try {
            DB::beginTransaction();

            if ($student->foto) {
                Storage::delete('public/student-photos/' . $student->foto);
            }
            
            // Delete associated user
            $student->user->delete();
            // Student will be deleted automatically due to cascade delete

            DB::commit();

            return redirect()->route('adminsiswa.index')
                ->with('success', 'Data siswa berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}