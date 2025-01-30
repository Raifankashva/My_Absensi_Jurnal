<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use App\Models\ScheduleTemplate;
use App\Models\Holiday;
use App\Models\Attendance;
use App\Models\FaceData;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AttendanceSettingController extends Controller
{
    public function index()
    {
        $settings = AttendanceSetting::where('sekolah_id', auth()->user()->sekolah_id)->first();
        return view('attendance.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required',
            'batas_telat' => 'required',
            'jam_pulang' => 'required'
        ]);

        AttendanceSetting::updateOrCreate(
            ['sekolah_id' => auth()->user()->sekolah_id],
            $request->all()
        );

        return redirect()->route('attendance.settings.index')
            ->with('success', 'Pengaturan absensi berhasil disimpan');
    }
}
