<?php 

namespace App\Http\Controllers;

use Laravolt\Indonesia\Models\Provinsi;
use Laravolt\Indonesia\Models\Kota;
use Laravolt\Indonesia\Models\Kecamatan;
use Laravolt\Indonesia\Models\Kelurahan;
use Illuminate\Http\Request;

class DependentDropdownController extends Controller
{

    public function getCities(Request $request)
    {
        $cities = \Indonesia::findProvince($request->id, ['cities'])->cities;
        return response()->json($cities->pluck('name', 'id'));
    }

    public function getDistricts(Request $request)
    {
        $districts = \Indonesia::findCity($request->id, ['districts'])->districts;
        return response()->json($districts->pluck('name', 'id'));
    }

    public function getVillages(Request $request)
    {
        $villages = \Indonesia::findDistrict($request->id, ['villages'])->villages;
        return response()->json($villages->pluck('name', 'id'));
    }
}
