<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    try {
        $query = Sekolah::with(['province', 'city', 'district', 'village']);

        // Apply filters
        if ($request->filled('search')) {
            $query->where('nama_sekolah', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }

        if ($request->filled('province')) {
            $query->where('province_id', $request->province);
        }

        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }

        if ($request->filled('district')) {
            $query->where('district_id', $request->district);
        }

        if ($request->filled('village')) {
            $query->where('village_id', $request->village);
        }
        if ($request->filled('search')) {
            $query->where('nama_sekolah', 'like', '%' . $request->search . '%');
        }

        $sekolahs = $query->latest()->paginate(10);
        $provinces = Province::all(); // Get all provinces

        // Generate QR codes for each school
        foreach ($sekolahs as $sekolah) {
            $sekolah->qr_code_url = QrCode::size(200)->generate(route('sekolahs.show', $sekolah->id));
        }

        return view('sekolahs.index', compact('sekolahs', 'provinces'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $provinces = Province::all();
            $jenjang = ['SD', 'SMP', 'SMA', 'SMK'];
            $status = ['Negeri', 'Swasta'];
            return view('sekolahs.create', compact('provinces', 'jenjang', 'status'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
                'email' => 'required|email|unique:sekolahs',
                'website' => 'nullable|url',
                'akreditasi' => 'nullable|string|max:1',
                'kepala_sekolah' => 'required|string|max:255',
                'nip_kepala_sekolah' => 'nullable|string|max:18'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            Sekolah::create($request->all());

            DB::commit();

            return redirect()->route('sekolahs.index')
                ->with('success', 'Data sekolah berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get cities based on province
     *
     * @param string $provinceId
     * @return \Illuminate\Http\JsonResponse
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
     *
     * @param string $cityId
     * @return \Illuminate\Http\JsonResponse
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
     *
     * @param string $districtId
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function show(Sekolah $sekolah)
    {
        try {
            return view('sekolahs.show', compact('sekolah'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit(Sekolah $sekolah)
    {
        try {
            $provinces = Province::all();
            $cities = Regency::where('province_id', $sekolah->province_id)->get();
            $districts = District::where('regency_id', $sekolah->city_id)->get();
            $villages = Village::where('district_id', $sekolah->district_id)->get();
            $jenjang = ['SD', 'SMP', 'SMA', 'SMK'];
            $status = ['Negeri', 'Swasta'];

            return view('sekolahs.edit', compact(
                'sekolah',
                'provinces',
                'cities',
                'districts',
                'villages',
                'jenjang',
                'status'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'npsn' => 'required|string|max:8|unique:sekolahs,npsn,' . $sekolah->id,
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
                'email' => 'required|email|unique:sekolahs,email,' . $sekolah->id,
                'website' => 'nullable|url',
                'akreditasi' => 'nullable|string|max:1',
                'kepala_sekolah' => 'required|string|max:255',
                'nip_kepala_sekolah' => 'nullable|string|max:18'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $sekolah->update($request->all());

            DB::commit();

            return redirect()->route('sekolahs.index')
                ->with('success', 'Data sekolah berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sekolah $sekolah)
    {
        try {
            DB::beginTransaction();
            
            $sekolah->delete();
            
            DB::commit();
            
            return redirect()->route('sekolahs.index')
                ->with('success', 'Data sekolah berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}