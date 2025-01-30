<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::where('sekolah_id', auth()->user()->sekolah_id)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
        return view('attendance.holiday.index', compact('holidays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_libur' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable'
        ]);

        $request->merge(['sekolah_id' => auth()->user()->sekolah_id]);
        Holiday::create($request->all());

        return redirect()->route('holiday.index')
            ->with('success', 'Data libur berhasil ditambahkan');
    }
}