<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

    public function dashboard()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        return view('guru.dashboard', compact('totalSiswa'));
    }
}
