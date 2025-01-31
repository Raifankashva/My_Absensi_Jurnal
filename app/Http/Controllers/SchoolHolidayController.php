<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolHoliday;
use App\Models\Sekolah;

class SchoolHolidayController extends Controller
{
    public function index()
    {
        $holidays = SchoolHoliday::with('sekolah')->get();
        return view('attendance.holidays.index', compact('holidays'));
    }

    public function create()
    {
        $schools = Sekolah::all();
        return view('attendance.holidays.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255'
        ]);

        SchoolHoliday::create($validated);
        return redirect()->route('attendance.holidays.index')->with('success', 'Hari libur berhasil ditambahkan');
    }
}