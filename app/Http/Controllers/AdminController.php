<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard()
    {
        $sekolah = Sekolah::all();
        $totalSekolah = Sekolah::count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $latestUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'latestUsers', 'totalSekolah', 'sekolah'));
    }
}