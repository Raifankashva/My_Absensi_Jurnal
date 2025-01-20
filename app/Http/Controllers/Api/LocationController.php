<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get cities based on province ID
     */
    public function getCities($provinceId): JsonResponse
    {
        $cities = City::where('province_id', $provinceId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($cities);
    }

    /**
     * Get districts based on city ID
     */
    public function getDistricts($cityId): JsonResponse
    {
        $districts = District::where('city_id', $cityId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($districts);
    }

    /**
     * Get villages based on district ID
     */
    public function getVillages($districtId): JsonResponse
    {
        $villages = Village::where('district_id', $districtId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($villages);
    }
}