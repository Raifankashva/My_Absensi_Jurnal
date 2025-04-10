<?php

namespace App\Http\Controllers;

use App\Models\DataGuru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GuruProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $guru = DataGuru::where('user_id', $user->id)->with('sekolah')->first();
        
        if (!$guru) {
            return redirect()->route('home')->with('error', 'Data guru tidak ditemukan.');
        }
        
        // Decode mata pelajaran dari JSON
        if ($guru->mata_pelajaran) {
            $guru->mata_pelajaran_array = json_decode($guru->mata_pelajaran);
        } else {
            $guru->mata_pelajaran_array = [];
        }
        
        return view('guru.profile.show', compact('guru', 'user'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        $guru = DataGuru::where('user_id', $user->id)->first();
        
        if (!$guru) {
            return redirect()->route('home')->with('error', 'Data guru tidak ditemukan.');
        }
        
        // Decode mata pelajaran dari JSON
        if ($guru->mata_pelajaran) {
            $guru->mata_pelajaran_array = json_decode($guru->mata_pelajaran);
        } else {
            $guru->mata_pelajaran_array = [];
        }
        
        return view('guru.profile.edit', compact('guru', 'user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        $guru = DataGuru::where('user_id', $user->id)->first();
        
        if (!$guru) {
            return redirect()->route('home')->with('error', 'Data guru tidak ditemukan.');
        }
        
        $request->validate([
            'nama_lengkap' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'current_password' => 'nullable|required_with:password|string',
        ]);
        
        // Validasi password lama
        if ($request->filled('current_password') && $request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
            }
        }
        
        // Update user data
        $userData = [
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ];
        
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        
        $user->update($userData);
        
        // Update guru data
        $guruData = [
            'nama_lengkap' => $request->nama_lengkap,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ];
        
        // Handle upload foto jika ada
        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::delete('public/guru-photos/' . $guru->foto);
            }
            
            $foto = $request->file('foto');
            $fotoName = Str::slug($request->nama_lengkap) . '-' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/guru-photos', $fotoName);
            $guruData['foto'] = $fotoName;
        }
        
        $guru->update($guruData);
        
        return redirect()->route('guru.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}