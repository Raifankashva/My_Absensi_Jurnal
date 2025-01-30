<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use App\Models\ScheduleTemplate;
use App\Models\Holiday;
use App\Models\Attendance;
use App\Models\FaceData;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('siswa')
            ->whereHas('siswa', function($query) {
                $query->where('sekolah_id', auth()->user()->sekolah_id);
            })
            ->whereDate('tanggal', Carbon::today())
            ->get();

        return view('attendance.index', compact('attendances'));
    }

    public function scan()
    {
        return view('attendance.scan');
    }

    public function process(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Save captured image
        $image = $request->file('foto');
        $fileName = time() . '_attendance.' . $image->getClientOriginalExtension();
        Storage::put('public/attendance/' . $fileName, file_get_contents($image));

        // Process face recognition using Python script
        $pythonScript = base_path('python/recognize_face.py');
        $imagePath = storage_path('app/public/attendance/' . $fileName);
        $result = shell_exec("python3 {$pythonScript} {$imagePath}");

        if (!$result) {
            Storage::delete('public/attendance/' . $fileName);
            return back()->with('error', 'Wajah tidak terdeteksi');
        }

        $studentId = trim($result); // Get student ID from recognition result
        $student = DataSiswa::find($studentId);
        
        if (!$student) {
            Storage::delete('public/attendance/' . $fileName);
            return back()->with('error', 'Siswa tidak ditemukan');
        }

        // Get attendance settings
        $settings = AttendanceSetting::where('sekolah_id', auth()->user()->sekolah_id)->first();
        $now = Carbon::now();
        
        // Check if it's entry or exit time
        if ($now->format('H:i:s') <= $settings->batas_telat) {
            // Entry time
            $status = $now->format('H:i:s') <= $settings->jam_masuk ? 'hadir' : 'telat';
            
            Attendance::updateOrCreate(
                [
                    'data_siswa_id' => $student->id,
                    'tanggal' => $now->toDateString()
                ],
                [
                    'jam_masuk' => $now,
                    'status_masuk' => $status,
                    'foto_masuk' => $fileName
                ]
            );

            $message = 'Absensi masuk berhasil dicatat';
        } else {
            // Exit time
            $attendance = Attendance::where('data_siswa_id', $student->id)
                ->whereDate('tanggal', $now->toDateString())
                ->first();

            if ($attendance) {
                $status = $now->format('H:i:s') >= $settings->jam_pulang ? 'tepat' : 'awal';
                $attendance->update([
                    'jam_pulang' => $now,
                    'status_pulang' => $status,
                    'foto_pulang' => $fileName
                ]);
                $message = 'Absensi pulang berhasil dicatat';
            } else {
                Storage::delete('public/attendance/' . $fileName);
                return back()->with('error', 'Tidak ada data absensi masuk');
            }
        }

        return redirect()->route('attendance.index')->with('success', $message);
    }

    public function report()
    {
        $attendances = Attendance::with('siswa')
            ->whereHas('siswa', function($query) {
                $query->where('sekolah_id', auth()->user()->sekolah_id);
            })
            ->whereBetween('tanggal', [
                request('start_date', Carbon::now()->startOfMonth()),
                request('end_date', Carbon::now()->endOfMonth())
            ])
            ->get();

        return view('attendance.report', compact('attendances'));
    }
}