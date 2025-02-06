<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\DataSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;

class AttendanceSettingController extends Controller
{
    public function index()
    {
        $settings = AttendanceSetting::where('sekolah_id', auth()->user()->sekolah_id)->first();
        return view('attendance.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required',
            'batas_telat' => 'required',
            'jam_pulang' => 'required',
        ]);

        AttendanceSetting::updateOrCreate(
            ['sekolah_id' => auth()->user()->sekolah_id],
            [
                'jam_masuk' => $request->jam_masuk,
                'batas_telat' => $request->batas_telat,
                'jam_pulang' => $request->jam_pulang,
                'token' => Str::random(32),
            ]
        );

        return redirect()->back()->with('success', 'Settings saved successfully');
    }
}