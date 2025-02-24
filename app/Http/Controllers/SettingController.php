<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Sekolah;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::with('sekolah')->get();
        $sekolahs = Sekolah::all();

        return view('settings.index', compact('settings', 'sekolahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'jam_masuk' => 'required',
            'batas_terlambat' => 'required',
        ]);

        Setting::updateOrCreate(
            ['sekolah_id' => $request->sekolah_id],
            ['jam_masuk' => $request->jam_masuk, 'batas_terlambat' => $request->batas_terlambat]
        );

        return redirect()->back()->with('success', 'Pengaturan jam masuk berhasil disimpan!');
    }
}
