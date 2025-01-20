<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Azishapidin\Indoregion\Models\Province;
use Azishapidin\Indoregion\Models\City;
use Azishapidin\Indoregion\Models\District;
use Azishapidin\Indoregion\Models\Village;

class RegionController extends Controller
{
    public function getCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->get();
        return response()->json($cities);
    }

    public function getDistricts($cityId)
    {
        $districts = District::where('city_id', $cityId)->get();
        return response()->json($districts);
    }

    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get();
        return response()->json($villages);
    }
}
