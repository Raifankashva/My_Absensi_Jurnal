<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\DataGuru;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dashboard()
    {
        // Get the logged-in guru's details
        $guru = DataGuru::where('user_id', Auth::id())->firstOrFail();

        // Fetch students in the same school as the guru
        $totalSiswa = User::where('role', 'siswa')
            ->whereHas('dataSiswa', function ($query) use ($guru) {
                $query->where('sekolah_id', $guru->sekolah_id);
            })
            ->count();

        // Fetch other stats
        $totalGuru = User::where('role', 'guru')->count();
        $totalSekolah = Sekolah::count();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalSekolah'
        ));
    }
}