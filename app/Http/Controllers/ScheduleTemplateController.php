<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceSetting;
use App\Models\ScheduleTemplate;
use App\Models\Holiday;
use App\Models\Attendance;
use App\Models\FaceData;
use App\Models\DataSiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ScheduleTemplateController extends Controller
{
    public function index()
    {
        $templates = ScheduleTemplate::where('sekolah_id', auth()->user()->sekolah_id)->get();
        return view('attendance.schedule.index', compact('templates'));
    }

    public function create()
    {
        return view('attendance.schedule.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required',
            'senin' => 'boolean',
            'selasa' => 'boolean',
            'rabu' => 'boolean',
            'kamis' => 'boolean',
            'jumat' => 'boolean',
            'sabtu' => 'boolean',
            'minggu' => 'boolean',
        ]);

        $request->merge(['sekolah_id' => auth()->user()->sekolah_id]);
        ScheduleTemplate::create($request->all());

        return redirect()->route('schedule.index')
            ->with('success', 'Template jadwal berhasil dibuat');
    }

    public function edit(ScheduleTemplate $template)
    {
        return view('attendance.schedule.edit', compact('template'));
    }

    public function update(Request $request, ScheduleTemplate $template)
    {
        $request->validate([
            'nama_template' => 'required',
        ]);

        $template->update($request->all());
        return redirect()->route('schedule.index')
            ->with('success', 'Template jadwal berhasil diupdate');
    }
}