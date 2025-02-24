<?php

namespace App\Http\Controllers;


use App\Models\User; // Ensure this is imported

use Illuminate\Http\Request;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:siswa']);
    }

    public function dashboard()
{
    $user = User::find(auth()->id())->load([
        'dataSiswa.kelas' => function($query) {
            $query->with(['jadwalPelajaran' => function($q) {
                $q->with('guru')
                  ->orderBy('hari')
                  ->orderBy('jam_mulai');
            }]);
        },
        'dataSiswa.sekolah'
    ]);
    $jadwalPerHari = $user->dataSiswa->kelas->jadwalPelajaran->groupBy('hari');

    return view('siswa.dashboard', compact('user', 'jadwalPerHari'));
}
    
public function jadwal()
{
    $user = User::find(auth()->id())->load([
        'dataSiswa.kelas' => function($query) {
            $query->with(['jadwalPelajaran' => function($q) {
                $q->with('guru')
                  ->orderBy('hari')
                  ->orderBy('jam_mulai');
            }]);
        }
    ]);

    $jadwalPerHari = $user->dataSiswa->kelas->jadwalPelajaran->groupBy('hari');
    
    return view('siswa.jadwal', compact('jadwalPerHari'));
}   
}