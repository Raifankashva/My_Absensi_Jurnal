<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class SchoolProfileController extends Controller
{
    /**
     * Display the school profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
{
    // Get the authenticated user
    $user = Auth::user();
    
    // Check if the user has a school profile
    $sekolah = Sekolah::where('user_id', $user->id)->first();
    
    if (!$sekolah) {
        return redirect()->route('dashboard')
            ->with('error', 'Profil sekolah tidak ditemukan.');
    }
    
    // Get region data for display
    $province = Province::find($sekolah->province_id);
    $city = Regency::find($sekolah->city_id);
    $district = District::find($sekolah->district_id);
    $village = Village::find($sekolah->village_id);
    
    // Check if coordinates exist
    $hasCoordinates = !is_null($sekolah->latitude) && !is_null($sekolah->longitude);
    
    return view('school.profile', compact(
        'sekolah', 
        'province', 
        'city', 
        'district', 
        'village',
        'hasCoordinates'
    ));
}

    /**
     * Show the form for editing the school profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Check if the user has a school profile
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        if (!$sekolah) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil sekolah tidak ditemukan.');
        }
        
        // Get all regions data for dropdowns
        $provinces = Province::all();
        $cities = Regency::where('province_id', $sekolah->province_id)->get();
        $districts = District::where('regency_id', $sekolah->city_id)->get();
        $villages = Village::where('district_id', $sekolah->district_id)->get();
        
        return view('school.edit', compact(
            'sekolah', 
            'provinces', 
            'cities', 
            'districts', 
            'villages'
        ));
    }

    /**
     * Update the school profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|size:8',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'status' => 'required|in:Negeri,Swasta',
            'alamat' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'kode_pos' => 'required|string|size:5',
            'no_telp' => 'required|string|max:15',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'akreditasi' => 'nullable|string|max:1',
            'kepala_sekolah' => 'required|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|size:18',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);
        
        // Get the authenticated user
        $user = Auth::user();
        
        // Get the school profile
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        if (!$sekolah) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil sekolah tidak ditemukan.');
        }
        
        // Update the school's user information
        $user->name = $request->nama_sekolah;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->save();
        
        // Handle file upload if a new photo is provided
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($sekolah->foto && Storage::exists('public/sekolah/' . $sekolah->foto)) {
                Storage::delete('public/sekolah/' . $sekolah->foto);
            }
            
            // Store the new photo
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/sekolah', $fotoName);
            $sekolah->foto = $fotoName;
        }
        
        // Update school details
        $sekolah->nama_sekolah = $request->nama_sekolah;
        $sekolah->npsn = $request->npsn;
        $sekolah->jenjang = $request->jenjang;
        $sekolah->status = $request->status;
        $sekolah->alamat = $request->alamat;
        $sekolah->province_id = $request->province_id;
        $sekolah->city_id = $request->city_id;
        $sekolah->district_id = $request->district_id;
        $sekolah->village_id = $request->village_id;
        $sekolah->kode_pos = $request->kode_pos;
        $sekolah->no_telp = $request->no_telp;
        $sekolah->email = $request->email;
        $sekolah->website = $request->website;
        $sekolah->akreditasi = $request->akreditasi;
        $sekolah->kepala_sekolah = $request->kepala_sekolah;
        $sekolah->nip_kepala_sekolah = $request->nip_kepala_sekolah;
        $sekolah->latitude = $request->latitude;
        $sekolah->longitude = $request->longitude;
        
        $sekolah->save();
        
        return redirect()->route('sekolah.profile')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }
    
    /**
     * Get cities for a province using AJAX
     */
    public function getCities(Request $request)
    {
        $provinceId = $request->province_id;
        $cities = Regency::where('province_id', $provinceId)->get();
        return response()->json($cities);
    }
    
    /**
     * Get districts for a city using AJAX
     */
    public function getDistricts(Request $request)
    {
        $cityId = $request->city_id;
        $districts = District::where('regency_id', $cityId)->get();
        return response()->json($districts);
    }
    
    /**
     * Get villages for a district using AJAX
     */
    public function getVillages(Request $request)
    {
        $districtId = $request->district_id;
        $villages = Village::where('district_id', $districtId)->get();
        return response()->json($villages);
    }
}