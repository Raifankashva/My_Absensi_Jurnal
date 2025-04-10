<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Get cities by province ID.
     */
    public function getCities($provinceId)
    {
        $cities = Regency::where('province_id', $provinceId)->get();
        return response()->json($cities);
    }

    /**
     * Get districts by city ID.
     */
    public function getDistricts($cityId)
    {
        $districts = District::where('regency_id', $cityId)->get();
        return response()->json($districts);
    }

    /**
     * Get villages by district ID.
     */
    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get();
        return response()->json($villages);
    }
}
