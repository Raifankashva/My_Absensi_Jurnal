<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SchoolRegistrationController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        $provinces = Province::all();
        $jenjang = ['SD', 'SMP', 'SMA', 'SMK'];
        $status = ['Negeri', 'Swasta'];
        
        return view('auth.school-register', compact('provinces', 'jenjang', 'status'));
    }
    
    /**
     * Process the registration
     */
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $validator = Validator::make($request->all(), [
                'npsn' => 'required|string|max:8|unique:sekolahs',
                'nama_sekolah' => 'required|string|max:255',
                'jenjang' => 'required|in:SD,SMP,SMA,SMK',
                'status' => 'required|in:Negeri,Swasta',
                'alamat' => 'required|string',
                'province_id' => 'required|exists:provinces,id',
                'city_id' => 'required|exists:regencies,id',
                'district_id' => 'required|exists:districts,id',
                'village_id' => 'required|exists:villages,id',
                'kode_pos' => 'required|string|max:5',
                'no_telp' => 'required|string|max:15',
                'email' => 'required|email|unique:sekolahs,email|unique:users,email',
                'website' => 'nullable|url',
                'akreditasi' => 'nullable|string|max:1',
                'kepala_sekolah' => 'required|string|max:255',
                'nip_kepala_sekolah' => 'nullable|string|max:18',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'required|string|min:8|confirmed'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
    
            // Create user with pending status
            $user = User::create([
                'name' => $request->nama_sekolah,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'no_hp' => $request->no_telp,
                'role' => 'sekolah',
                'status' => 'pending' // Set initial status as pending
            ]);
    
            // Handle Foto
            $sekolahData = $request->all();
            $sekolahData['user_id'] = $user->id;
    
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto_sekolah', 'public');
                $sekolahData['foto'] = $fotoPath;
            }
    
            // Create school record
            Sekolah::create($sekolahData);
    
            DB::commit();
    
            return redirect()->route('registration.success')
                ->with('success', 'Pendaftaran sekolah berhasil! Mohon tunggu persetujuan dari admin.');
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Show success page after registration
     */
    public function showSuccessPage()
    {
        return view('auth.school-register-success');
    }
    
    /**
     * Get cities based on province
     */
    public function getCities($provinceId)
    {
        try {
            $cities = Regency::where('province_id', $provinceId)
                ->select('id', 'name')
                ->get();
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get districts based on city
     */
    public function getDistricts($cityId)
    {
        try {
            $districts = District::where('regency_id', $cityId)
                ->select('id', 'name')
                ->get();
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get villages based on district
     */
    public function getVillages($districtId)
    {
        try {
            $villages = Village::where('district_id', $districtId)
                ->select('id', 'name')
                ->get();
            return response()->json($villages);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}