<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\DataGuru;
use App\Models\DataSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SchoolDashboardController extends Controller
{
    /**
     * Display the school dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the current authenticated user's school
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        if (!$sekolah) {
            return redirect()->route('home')->with('error', 'Sekolah tidak ditemukan');
        }

        // Get school statistics
        $totalSiswa = $sekolah->total_siswa;
        $totalGuru = DataGuru::where('sekolah_id', $sekolah->id)->count();
        $totalKelas = Kelas::where('sekolah_id', $sekolah->id)->count();
        
        // Get class distribution by grade level
        $kelasByTingkat = Kelas::where('sekolah_id', $sekolah->id)
            ->select('tingkat', DB::raw('count(*) as total'))
            ->groupBy('tingkat')
            ->orderBy('tingkat')
            ->get();
        
        // Get student distribution by gender
        $siswaByGender = DataSiswa::where('sekolah_id', $sekolah->id)
            ->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->get();
        
        // Get teacher distribution by employment status
        $guruByStatus = DataGuru::where('sekolah_id', $sekolah->id)
            ->select('status_kepegawaian', DB::raw('count(*) as total'))
            ->groupBy('status_kepegawaian')
            ->get();
        
        // Get latest 5 registered students
        $latestSiswa = DataSiswa::where('sekolah_id', $sekolah->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get latest 5 registered teachers
        $latestGuru = DataGuru::where('sekolah_id', $sekolah->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get class capacity utilization
        $kelasUtilization = Kelas::where('sekolah_id', $sekolah->id)
            ->select('nama_kelas', 'kapasitas', 'sisa_kapasitas')
            ->get()
            ->map(function($kelas) {
                $kelas->utilization = ($kelas->kapasitas - $kelas->sisa_kapasitas) / $kelas->kapasitas * 100;
                return $kelas;
            });

        // Get student distribution by year level
        $siswaByTingkat = DataSiswa::join('kelas', 'data_siswa.kelas_id', '=', 'kelas.id')
            ->where('data_siswa.sekolah_id', $sekolah->id)
            ->select('kelas.tingkat', DB::raw('count(*) as total'))
            ->groupBy('kelas.tingkat')
            ->orderBy('kelas.tingkat')
            ->get();
        
        // Get teachers by subject
        $guruBySubject = DataGuru::where('sekolah_id', $sekolah->id)
            ->get()
            ->flatMap(function($guru) {
                $mapelArray = ('$guru->mata_pelajaran');
                return $mapelArray;
            })
            ->countBy()
            ->sortDesc();

        return view('school.dashboard', compact(
            'sekolah',
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'kelasByTingkat',
            'siswaByGender',
            'guruByStatus',
            'latestSiswa',
            'latestGuru',
            'kelasUtilization',
            'siswaByTingkat',
            'guruBySubject'
        ));
    }

    /**
     * Show class details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showClass($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        // Check if the class belongs to the authenticated user's school
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        if (!$sekolah || $kelas->sekolah_id !== $sekolah->id) {
            return redirect()->route('school.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        // Get students in this class
        $siswa = DataSiswa::where('kelas_id', $kelas->id)->get();
        
        // Get the homeroom teacher if assigned
        $waliKelas = $kelas->wali_kelas ? DataGuru::where('nama_lengkap', $kelas->wali_kelas)->first() : null;
        
        return view('school.class-details', compact('kelas', 'siswa', 'waliKelas'));
    }

    /**
     * Show teacher details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTeacher($id)
    {
        $guru = DataGuru::findOrFail($id);
        
        // Check if the teacher belongs to the authenticated user's school
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        if (!$sekolah || $guru->sekolah_id !== $sekolah->id) {
            return redirect()->route('school.dashboard')->with('error', 'Guru tidak ditemukan');
        }
        
        // Get classes where this teacher is assigned as homeroom teacher
        $kelasWali = Kelas::where('sekolah_id', $sekolah->id)
            ->where('wali_kelas', $guru->nama_lengkap)
            ->get();
        
        return view('school.teacher-details', compact('guru', 'kelasWali'));
    }

    /**
     * Show student details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showStudent($id)
    {
        $siswa = DataSiswa::findOrFail($id);
        
        // Check if the student belongs to the authenticated user's school
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();
        
        if (!$sekolah || $siswa->sekolah_id !== $sekolah->id) {
            return redirect()->route('school.dashboard')->with('error', 'Siswa tidak ditemukan');
        }
        
        // Get student's class
        $kelas = Kelas::findOrFail($siswa->kelas_id);
        
        return view('school.student-details', compact('siswa', 'kelas'));
    }

    /**
 * Display a listing of the classes.
 *
 * @return \Illuminate\Http\Response
 */
public function indexClasses()
{
    // Get the current authenticated user's school
    $user = Auth::user();
    $sekolah = Sekolah::where('user_id', $user->id)->first();
    
    if (!$sekolah) {
        return redirect()->route('home')->with('error', 'Sekolah tidak ditemukan');
    }
    
    // Get all classes for this school
    $kelas = Kelas::where('sekolah_id', $sekolah->id)
        ->orderBy('tingkat')
        ->orderBy('nama_kelas')
        ->get();
    
    return view('school.classes.index', compact('kelas', 'sekolah'));
}

/**
 * Display a listing of the students.
 *
 * @return \Illuminate\Http\Response
 */
public function indexStudents()
{
    // Get the current authenticated user's school
    $user = Auth::user();
    $sekolah = Sekolah::where('user_id', $user->id)->first();
    
    if (!$sekolah) {
        return redirect()->route('home')->with('error', 'Sekolah tidak ditemukan');
    }
    
    // Get all students for this school with pagination
    $siswa = DataSiswa::where('sekolah_id', $sekolah->id)
        ->with('kelas')
        ->orderBy('nama_lengkap')
        ->paginate(15);
    
    return view('school.students.index', compact('siswa', 'sekolah'));
}

/**
 * Display a listing of the teachers.
 *
 * @return \Illuminate\Http\Response
 */
public function indexTeachers()
{
    // Get the current authenticated user's school
    $user = Auth::user();
    $sekolah = Sekolah::where('user_id', $user->id)->first();
    
    if (!$sekolah) {
        return redirect()->route('home')->with('error', 'Sekolah tidak ditemukan');
    }
    
    // Get all teachers for this school with pagination
    $guru = DataGuru::where('sekolah_id', $sekolah->id)
        ->orderBy('nama_lengkap')
        ->paginate(15);
    
    return view('school.teachers.index', compact('guru', 'sekolah'));
}

/**
 * Display class capacity information.
 *
 * @return \Illuminate\Http\Response
 */
public function classCapacity()
{
    // Get the current authenticated user's school
    $user = Auth::user();
    $sekolah = Sekolah::where('user_id', $user->id)->first();
    
    if (!$sekolah) {
        return redirect()->route('home')->with('error', 'Sekolah tidak ditemukan');
    }
    
    // Get class capacity information
    $kelasCapacity = Kelas::where('sekolah_id', $sekolah->id)
        ->orderBy('tingkat')
        ->orderBy('nama_kelas')
        ->get()
        ->map(function($kelas) {
            $kelas->terisi = $kelas->kapasitas - $kelas->sisa_kapasitas;
            $kelas->persentase = $kelas->kapasitas > 0 ? round(($kelas->terisi / $kelas->kapasitas) * 100) : 0;
            return $kelas;
        });
    
    return view('school.classes.capacity', compact('kelasCapacity', 'sekolah'));
}
}