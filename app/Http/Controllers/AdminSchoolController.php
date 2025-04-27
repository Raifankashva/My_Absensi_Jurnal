<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SchoolsExport;

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
     * Display a listing of the schools with filtering options.
     */
    public function index(Request $request)
    {
        $query = Sekolah::with('user', 'province', 'city');

        // Apply filters if provided
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }
        
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }
        
        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where('nama_sekolah', 'like', '%' . $request->search . '%')
                  ->orWhere('npsn', 'like', '%' . $request->search . '%');
        }
        
        // Get data for filter dropdowns
        $provinces = Province::orderBy('name')->get();
        $cities = collect();
        
        if ($request->filled('province_id')) {
            $cities = Regency::where('province_id', $request->province_id)
                      ->orderBy('name')
                      ->get();
        }
        
        // Get paginated results
        $schools = $query->orderBy('nama_sekolah')->paginate(10);
        
        // For export actions, we need to get all results without pagination
        if ($request->has('export')) {
            $allSchools = $query->get();
            
            if ($request->export === 'pdf') {
                return $this->exportPdf($allSchools);
            } elseif ($request->export === 'excel') {
                return $this->exportExcel($allSchools);
            }
        }
        
        return view('adminsekolah.index', compact('schools', 'provinces', 'cities'));
    }

    /**
     * Export schools data to PDF
     */
    protected function exportPdf($schools)
    {
        $pdf = PDF::loadView('adminsekolah.pdf', compact('schools'));
        return $pdf->download('daftar-sekolah-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export schools data to Excel
     */
    protected function exportExcel($schools)
    {
        return Excel::download(new SchoolsExport($schools), 'daftar-sekolah-' . date('Y-m-d') . '.xlsx');
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
        $provinces = Province::all();
        $cities = Regency::where('province_id', $school->province_id)->get();
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

    /**
     * Get cities by province (for AJAX)
     */
    public function getCities($provinceId)
    {
        $cities = Regency::where('province_id', $provinceId)->orderBy('name')->get();
        return response()->json($cities);
    }
}