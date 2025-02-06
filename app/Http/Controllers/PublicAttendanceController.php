<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class PublicAttendanceController extends Controller
{
    public function view(Request $request)
    {
        if (!$request->has('token')) {
            return view('attendance.public-view');
        }

        $attendances = Attendance::with('siswa')
            ->where('sekolah_id', $request->school_setting->sekolah_id)
            ->whereDate('tanggal', now())
            ->get();

        return view('attendance.public-view', compact('attendances'));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now());

        $attendances = Attendance::with('siswa')
            ->where('sekolah_id', $request->school_setting->sekolah_id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        return response()->json([
            'school' => $request->school_setting->sekolah->nama,
            'period' => "$startDate to $endDate",
            'data' => $attendances
        ]);
    }
}