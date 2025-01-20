<?php

namespace App\Http\Controllers;

use App\Models\DataGuru;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class DataGuruController extends Controller
{
    public function index()
{
    $guru = DataGuru::with(['user', 'sekolah'])
        ->latest()
        ->paginate(10); // Tetap gunakan paginate di sini

    return view('adminguru.index', compact('guru'));
}


    public function create()
    {
        $sekolahs = Sekolah::all();
        return view('adminguru.create', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nip' => 'nullable|string|size:18|unique:data_guru',
            'nuptk' => 'nullable|string|size:16|unique:data_guru',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|size:16|unique:data_guru',
            'status_kepegawaian' => 'required|in:PNS,PPPK,Honorer,GTY,GTT',
            'pendidikan_terakhir' => 'required|string',
            'jurusan_pendidikan' => 'required|string',
            'tmt_kerja' => 'required|date',
            'mata_pelajaran' => 'required|array',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Create user account
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);
    
        // Handle foto upload
        $guruData = $request->except(['email', 'password', 'foto']);
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = 'guru_' . time() . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('public/foto/guru', $filename);
            $guruData['foto'] = $filename;
        }
    
        $guruData['user_id'] = $user->id;
    
        // Store the guru data in the database
        DataGuru::create($guruData);
    
        return redirect()->route('adminguru.index')->with('success', 'Data guru berhasil ditambahkan');
    }
    

    public function show(DataGuru $guru)
    {
        $guru->load('user', 'sekolah');
        return view('adminguru.show', compact('guru'));
    }

    public function edit(DataGuru $guru)
    {
        $sekolahs = Sekolah::all();
        return view('adminguru.edit', compact('guru', 'sekolahs'));
    }

    public function update(Request $request, DataGuru $guru)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nip' => 'nullable|string|size:18|unique:data_guru,nip,'.$guru->id,
            'nuptk' => 'nullable|string|size:16|unique:data_guru,nuptk,'.$guru->id,
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|size:16|unique:data_guru,nik,'.$guru->id,
            'status_kepegawaian' => 'required|in:PNS,PPPK,Honorer,GTY,GTT',
            'pendidikan_terakhir' => 'required|string',
            'jurusan_pendidikan' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'tmt_kerja' => 'required|date',
            'mata_pelajaran' => 'required|array',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user name if changed
        if ($guru->nama_lengkap !== $request->nama_lengkap) {
            $guru->user->update(['name' => $request->nama_lengkap]);
        }

        $guruData = $request->except(['foto']);
    
        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($guru->foto) {
                Storage::delete('public/foto/guru/' . $guru->foto);
            }
            
            $foto = $request->file('foto');
            $filename = 'guru_' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto/guru', $filename);
            $guruData['foto'] = $filename;
        }

        $guru->update($request->all());
        return redirect()->route('adminguru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy(DataGuru $guru)
    {
        // Check if the user associated with the guru exists
        if ($guru->user) {
            $guru->user->delete();
        } else {
            return redirect()->route('adminguru.index')->with('error', 'Guru does not have an associated user.');
        }
        
        return redirect()->route('adminguru.index')->with('success', 'Data guru berhasil dihapus');
    }
    
}