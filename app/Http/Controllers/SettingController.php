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
    public function viewSettings()
{
    // Get the authenticated user
    $user = auth()->user();
    
    // Check if the user has a school
    $sekolah = Sekolah::where('user_id', $user->id)->first();
    
    if (!$sekolah) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pengaturan sekolah.');
    }
    
    // Get the settings for this school
    $settings = Setting::where('sekolah_id', $sekolah->id)->first();
    
    // If no settings exist yet, create a default object to avoid null errors in the view
    if (!$settings) {
        $settings = new Setting();
        $settings->sekolah_id = $sekolah->id;
        $settings->jam_masuk = '07:00';
        $settings->batas_terlambat = '07:30';
    }
    
    return view('settings.view', compact('settings', 'sekolah'));
}
}
