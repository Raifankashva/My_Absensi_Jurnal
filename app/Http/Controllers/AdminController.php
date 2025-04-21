<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sekolah;
use App\Models\Task;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Halaman dashboard untuk admin.
     *
     * Menampilkan data total sekolah, total guru, total siswa, dan 5 pengguna terbaru.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
{
    $sekolah = Sekolah::all();
    // Get current and previous month dates
    $currentMonth = now();
    $lastMonth = now()->subMonth();
    
    // Calculate total schools and trends
    $totalSekolah = Sekolah::count();
    $lastMonthSekolah = Sekolah::where('created_at', '<', $lastMonth->endOfMonth())->count();
    $sekolahTrend = $lastMonthSekolah > 0 
        ? round((($totalSekolah - $lastMonthSekolah) / $lastMonthSekolah) * 100, 1)
        : 0;
    
    // Calculate total teachers and trends
    $totalGuru = User::where('role', 'guru')->count();
    $lastMonthGuru = User::where('role', 'guru')
        ->where('created_at', '<', $lastMonth->endOfMonth())
        ->count();
    $guruTrend = $lastMonthGuru > 0
        ? round((($totalGuru - $lastMonthGuru) / $lastMonthGuru) * 100, 1)
        : 0;
    
    // Calculate total students and trends
    $totalSiswa = User::where('role', 'siswa')->count();
    $lastMonthSiswa = User::where('role', 'siswa')
        ->where('created_at', '<', $lastMonth->endOfMonth())
        ->count();
    $siswaTrend = $lastMonthSiswa > 0
        ? round((($totalSiswa - $lastMonthSiswa) / $lastMonthSiswa) * 100, 1)
        : 0;
    
    // Calculate total users and trends
    $totalUsers = User::count();
    $lastMonthUsers = User::where('created_at', '<', $lastMonth->endOfMonth())->count();
    $usersTrend = $lastMonthUsers > 0
        ? round((($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1)
        : 0;

    $latestUsers = User::latest()->take(5)->get();
    
    // Define cards array with real trend data
    $cards = [
        [
            'color' => 'blue',
            'gradient' => 'from-blue-600 to-blue-400',
            'icon' => 'bxs-school',
            'title' => 'Total Sekolah',
            'count' => $totalSekolah,
            'trend' => ($sekolahTrend >= 0 ? '+' : '') . $sekolahTrend . '%',
            'trend_text' => 'dari bulan lalu'
        ],
        [
            'color' => 'emerald',
            'gradient' => 'from-emerald-600 to-emerald-400',
            'icon' => 'bxs-user-detail',
            'title' => 'Total Guru',
            'count' => $totalGuru,
            'trend' => ($guruTrend >= 0 ? '+' : '') . $guruTrend . '%',
            'trend_text' => 'dari bulan lalu'
        ],
        [
            'color' => 'purple',
            'gradient' => 'from-purple-600 to-purple-400',
            'icon' => 'bxs-group',
            'title' => 'Total Siswa',
            'count' => $totalSiswa,
            'trend' => ($siswaTrend >= 0 ? '+' : '') . $siswaTrend . '%',
            'trend_text' => 'dari bulan lalu'
        ],
        [
            'color' => 'rose',
            'gradient' => 'from-rose-600 to-rose-400',
            'icon' => 'bxs-user-pin',
            'title' => 'Total Pengguna',
            'count' => $totalUsers,
            'trend' => ($usersTrend >= 0 ? '+' : '') . $usersTrend . '%',
            'trend_text' => 'dari bulan lalu'
        ]
    ];

    
    

    return view('admin.dashboard', compact(
        'cards',
        'totalGuru', 
        'totalSiswa', 
        'latestUsers', 
        'totalSekolah', 
        'sekolah', 
    ));
}
    

}