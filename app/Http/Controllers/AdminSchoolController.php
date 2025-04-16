<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSchoolController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the schools.
     */
    public function index()
    {
        $schools = Sekolah::with('user')->paginate(10);
        return view('adminsekolah.index', compact('schools'));
    }

    /**
     * Display the specified school.
     */
    public function show($id)
    {
        $school = Sekolah::with(['user', 'province', 'city', 'district', 'village'])->findOrFail($id);
        return view('adminsekolah.show', compact('school'));
    }

    /**
     * Toggle activation status of a school.
     */
    public function toggleActive($id)
    {
        $school = Sekolah::findOrFail($id);
        $school->is_active = !$school->is_active;
        $school->save();

        $status = $school->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()
            ->with('success', "Sekolah {$school->nama_sekolah} berhasil {$status}.");
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit($id)
    {
        $school = Sekolah::with('user')->findOrFail($id);
        $provinces = \App\Models\Province::all();
        $cities = \App\Models\Regency::where('province_id', $school->province_id)->get();
        $districts = \App\Models\District::where('regency_id', $school->city_id)->get();
        $villages = \App\Models\Village::where('district_id', $school->district_id)->get();
        
        return view('adminsekolah.edit', compact('school', 'provinces', 'cities', 'districts', 'villages'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, $id)
    {
        $school = Sekolah::findOrFail($id);
        
        $validator = \Validator::make($request->all(), [
            'npsn' => 'required|string|size:8|unique:sekolahs,npsn,' . $id,
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'status' => 'required|in:Negeri,Swasta',
            'alamat' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'kode_pos' => 'required|string|size:5',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:sekolahs,email,' . $id,
            'website' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|size:1',
            'kepala_sekolah' => 'required|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|size:18',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle file upload if provided
        if ($request->hasFile('foto')) {
            // Delete old file if exists
            if ($school->foto && Storage::disk('public')->exists($school->foto)) {
                Storage::disk('public')->delete($school->foto);
            }
            
            $fotoPath = $request->file('foto')->store('sekolah_foto', 'public');
            $school->foto = $fotoPath;
        }

        // Update school details
        $school->update([
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

        return redirect()->route('adminsekolah.index')
            ->with('success', 'Data sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy($id)
    {
        $school = Sekolah::findOrFail($id);
        
        // Delete photo if exists
        if ($school->foto && Storage::disk('public')->exists($school->foto)) {
            Storage::disk('public')->delete($school->foto);
        }
        
        // Delete user associated with school
        $user = $school->user;
        if ($user) {
            $user->delete();
        }
        
        // School will be deleted automatically due to cascading delete in migration

        return redirect()->route('adminsekolah.index')
            ->with('success', 'Sekolah berhasil dihapus.');
    }
}