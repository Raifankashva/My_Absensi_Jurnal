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
        $totalSekolah = Sekolah::count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $latestUsers = User::latest()->take(5)->get();
    
        // Ambil tugas yang belum lebih dari 7 hari setelah due_date
        $tasks = Task::where('due_date', '>=', now()->subDays(7))->get();

        // Get today's schedules
        $todaySchedules = Schedule::where('day', Carbon::now()->format('l'))
            ->orderBy('time')
            ->get();
        
        // Get upcoming schedules for the next 7 days
        $upcomingSchedules = Schedule::whereIn('day', collect(range(0, 6))->map(function($day) {
                return Carbon::now()->addDays($day)->format('l');
            }))
            ->orderBy('day')
            ->orderBy('time')
            ->get()
            ->groupBy('day');
    
        return view('admin.dashboard', compact(
            'totalGuru', 
            'totalSiswa', 
            'latestUsers', 
            'totalSekolah', 
            'sekolah', 
            'tasks',
            'todaySchedules',
            'upcomingSchedules'
        ));
    }
    

}