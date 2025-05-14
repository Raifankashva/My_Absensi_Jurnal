<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingDaily;
use App\Models\Sekolah;
use App\Models\HariLibur;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SettingDailyController extends Controller
{
    /**
     * Tampilkan halaman pengaturan
     */
    public function index()
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        // Jika user memiliki sekolah, tampilkan pengaturan sekolah tersebut
        if ($userSchool) {
            return $this->viewSettings();
        } 
        // Jika user tidak memiliki sekolah (diasumsikan admin)
        else {
            $sekolahs = Sekolah::all();
            $settings = SettingDaily::with('sekolah')->get();
            return view('settings.daily.index', compact('settings', 'sekolahs'));
        }
    }

    /**
     * Simpan pengaturan untuk semua hari
     */
    public function store(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'jam_masuk' => 'required|array',
            'batas_terlambat' => 'required|array',
            'jam_pulang' => 'required|array',
            'is_active' => 'array',
        ]);

        // Cek akses pengguna ke sekolah yang akan diubah
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        // Jika pengguna memiliki sekolah dan ID sekolah tidak cocok
        if ($userSchool && $userSchool->id != $request->sekolah_id) {
            return redirect()->back()->with('error', 'Anda hanya dapat mengubah pengaturan untuk sekolah Anda sendiri.');
        }

        // List semua hari dalam seminggu
        $daysOfWeek = SettingDaily::getDaysOfWeek();

        foreach ($daysOfWeek as $index => $hari) {
            // Default is_active ke false jika tidak ada dalam request
            $isActive = isset($request->is_active[$index]) ? true : false;

            // Update atau buat pengaturan untuk setiap hari
            SettingDaily::updateOrCreate(
                [
                    'sekolah_id' => $request->sekolah_id,
                    'hari' => $hari
                ],
                [
                    'jam_masuk' => $request->jam_masuk[$index],
                    'batas_terlambat' => $request->batas_terlambat[$index],
                    'jam_pulang' => $request->jam_pulang[$index],
                    'is_active' => $isActive
                ]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan jadwal harian berhasil disimpan!');
    }

    /**
     * Tampilkan pengaturan untuk pengelola sekolah
     */
    public function viewSettings()
    {
        // Get current user's school
        $sekolah = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$sekolah) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Ambil semua pengaturan harian untuk sekolah ini
        $settingsCollection = SettingDaily::where('sekolah_id', $sekolah->id)->get();
        
        // Konversi ke array berdasarkan hari untuk memudahkan akses di view
        $settings = [];
        $daysOfWeek = SettingDaily::getDaysOfWeek();
        
        foreach ($daysOfWeek as $day) {
            $daySetting = $settingsCollection->where('hari', $day)->first();
            
            // Jika pengaturan untuk hari tersebut tidak ditemukan, buat default
            if (!$daySetting) {
                $daySetting = new SettingDaily();
                $daySetting->sekolah_id = $sekolah->id;
                $daySetting->hari = $day;
                $daySetting->jam_masuk = '07:00';
                $daySetting->batas_terlambat = '07:30';
                $daySetting->jam_pulang = '15:00';
                $daySetting->is_active = ($day !== 'Minggu'); // Default Minggu tidak aktif
            }
            
            $settings[$day] = $daySetting;
        }
        
        // Ambil data hari libur
        $hariLibur = HariLibur::where('sekolah_id', $sekolah->id)
            ->where('tanggal', '>=', Carbon::now()->startOfMonth())
            ->orderBy('tanggal')
            ->get();
        
        return view('settings.daily.view', compact('settings', 'sekolah', 'daysOfWeek', 'hariLibur'));
    }

    /**
     * Simpan pengaturan hari libur
     */
    public function storeHariLibur(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'action' => 'required|in:add,delete'
        ]);

        // Cek akses pengguna ke sekolah yang akan diubah
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        // Jika pengguna memiliki sekolah dan ID sekolah tidak cocok
        if ($userSchool && $userSchool->id != $request->sekolah_id) {
            return redirect()->back()->with('error', 'Anda hanya dapat mengubah pengaturan untuk sekolah Anda sendiri.');
        }

        if ($request->action === 'add') {
            // Cek apakah tanggal sudah ada
            $existing = HariLibur::where('sekolah_id', $request->sekolah_id)
                ->where('tanggal', $request->tanggal)
                ->first();
            
            if ($existing) {
                return redirect()->back()->with('error', 'Tanggal tersebut sudah ditandai sebagai hari libur.');
            }

            HariLibur::create([
                'sekolah_id' => $request->sekolah_id,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan
            ]);
            
            return redirect()->back()->with('success', 'Hari libur berhasil ditambahkan.');
        } else {
            // Hapus hari libur
            HariLibur::where('sekolah_id', $request->sekolah_id)
                ->where('tanggal', $request->tanggal)
                ->delete();
                
            return redirect()->back()->with('success', 'Hari libur berhasil dihapus.');
        }
    }
}