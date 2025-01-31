<?php

namespace App\Http\Controllers;

use App\Models\SchoolAttendanceSetting;
use App\Models\SchoolHoliday;
use App\Models\Attendance;
use App\Models\FaceEncoding;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use function PHPSTORM_META\type;


class SchoolAttendanceSettingController extends Controller
{
    public function index()
    {
        $settings = SchoolAttendanceSetting::with('sekolah')->get();
        return view('attendance.settings.index', compact('settings'));
    }

    public function create()
    {
        $schools = Sekolah::all();
        return view('attendance.settings.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'jam_masuk' => 'required|date_format:H:i',
            'batas_telat' => 'required|date_format:H:i|after:jam_masuk',
            'jam_pulang' => 'required|date_format:H:i|after:batas_telat',
            'hari_aktif' => 'required|array',
            'hari_aktif.*' => 'integer|between:1,7'
        ]);

        $validated['token'] = Str::random(32);
        
        SchoolAttendanceSetting::create($validated);
        return redirect()->route('attendance.settings.index')->with('success', 'Pengaturan absensi berhasil dibuat');
    }

    public function edit(SchoolAttendanceSetting $setting)
    {
        $schools = Sekolah::all();
        return view('attendance.settings.edit', compact('setting', 'schools'));
    }

    public function update(Request $request, SchoolAttendanceSetting $setting)
    {
        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'jam_masuk' => 'required|date_format:H:i',
            'batas_telat' => 'required|date_format:H:i|after:jam_masuk',
            'jam_pulang' => 'required|date_format:H:i|after:batas_telat',
            'hari_aktif' => 'required|array',
            'hari_aktif.*' => 'integer|between:1,7',
            'is_active' => 'boolean'
        ]);

        $setting->update($validated);
        return redirect()->route('attendance.settings.index')->with('success', 'Pengaturan absensi berhasil diperbarui');
    }
}