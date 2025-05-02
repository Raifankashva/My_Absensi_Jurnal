<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class LocationController extends Controller
{
    public function getCities($provinceId)
    {
        return City::where('province_id', $provinceId)->get(['id', 'name']);
    }

    public function getDistricts($cityId)
    {
        return District::where('city_id', $cityId)->get(['id', 'name']);
    }

    public function getVillages($districtId)
    {
        return Village::where('district_id', $districtId)->get(['id', 'name']);
    }
}