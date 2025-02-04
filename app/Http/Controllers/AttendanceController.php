<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:data_siswas,id',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'check_in_photo' => 'required|image|max:2048',
            'attendance_token' => 'required',
        ]);

        // Check attendance setting
        $attendanceSetting = AttendanceSetting::where('sekolah_id', $request->sekolah_id)
            ->where('is_active', true)
            ->where('attendance_token', $request->attendance_token)
            ->firstOrFail();

        // Check if already checked in today
        $existingAttendance = Attendance::today($request->siswa_id)->first();
        if ($existingAttendance) {
            return response()->json(['message' => 'Anda sudah absen hari ini'], 400);
        }

        // Store check-in photo
        $photoPath = $request->file('check_in_photo')->store('attendance_photos', 'public');

        // Create attendance record
        $attendance = Attendance::create([
            'siswa_id' => $request->siswa_id,
            'sekolah_id' => $request->sekolah_id,
            'kelas_id' => DataSiswa::findOrFail($request->siswa_id)->kelas_id,
            'attendance_date' => today(),
            'check_in_time' => now()->format('H:i:s'),
            'check_in_photo' => $photoPath,
            'status' => $this->determineAttendanceStatus($request->siswa_id, $attendanceSetting)
        ]);

        return response()->json([
            'message' => 'Absensi berhasil',
            'attendance' => $attendance
        ]);
    }

    public function manualCheckIn(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:data_siswas,id',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'status' => 'required|in:izin,sakit',
            'keterangan' => 'required|string',
        ]);

        // Check existing attendance
        $existingAttendance = Attendance::today($request->siswa_id)->first();
        if ($existingAttendance) {
            return response()->json(['message' => 'Anda sudah absen hari ini'], 400);
        }

        $attendance = Attendance::create([
            'siswa_id' => $request->siswa_id,
            'sekolah_id' => $request->sekolah_id,
            'kelas_id' => DataSiswa::findOrFail($request->siswa_id)->kelas_id,
            'attendance_date' => today(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'is_validated' => false
        ]);

        return response()->json([
            'message' => 'Absensi manual berhasil',
            'attendance' => $attendance
        ]);
    }

    private function determineAttendanceStatus($siswaId, $attendanceSetting)
    {
        $currentTime = now();
        $startTime = Carbon::parse($attendanceSetting->start_time);
        $lateThreshold = Carbon::parse($attendanceSetting->late_threshold);

        if ($currentTime->gt($lateThreshold)) {
            return 'terlambat';
        }

        return 'hadir';
    }
    public function report(Request $request)
    {
        $query = Attendance::with(['siswa', 'sekolah', 'kelas']);

        // Apply filters
        if ($request->filled('sekolah_id')) {
            $query->where('sekolah_id', $request->sekolah_id);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('attendance_date', [
                $request->start_date, 
                $request->end_date
            ]);
        }

        $attendances = $query->latest()->paginate(20);
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();

        return view('attendance.report', compact('attendances', 'sekolahs', 'kelas'));
    }

    public function getAttendanceDetail($id)
    {
        $attendance = Attendance::with(['siswa', 'sekolah', 'kelas'])
            ->findOrFail($id);

        return response()->json($attendance);
    }

    public function validateAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);
        
        // Check if already validated
        if ($attendance->is_validated) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi sudah divalidasi sebelumnya'
            ]);
        }

        $attendance->update([
            'is_validated' => true,
            'validated_at' => now(),
            'validated_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil divalidasi'
        ]);
    }

    public function getSummary()
    {
        $today = now()->toDateString();

        return response()->json([
            'hadir' => Attendance::where('status', 'hadir')
                ->whereDate('attendance_date', $today)
                ->count(),
            'izin' => Attendance::where('status', 'izin')
                ->whereDate('attendance_date', $today)
                ->count(),
            'sakit' => Attendance::where('status', 'sakit')
                ->whereDate('attendance_date', $today)
                ->count(),
            'alfa' => Attendance::where('status', 'alfa')
                ->whereDate('attendance_date', $today)
                ->count(),
            'terlambat' => Attendance::where('status', 'terlambat')
                ->whereDate('attendance_date', $today)
                ->count(),
        ]);
    }

    public function exportPdf(Request $request)
    {
        // Implementation for PDF export
        $query = Attendance::with(['siswa', 'sekolah', 'kelas']);

        // Apply same filters as in report method
        // Use a PDF library like FPDF or TCPDF to generate the report
    }

    public function exportExcel(Request $request)
    {
        // Implementation for Excel export
        // Use a library like PhpSpreadsheet to generate Excel file
    }
    public function showTokenForm()
    {
        $sekolahs = Sekolah::all();
        return view('attendance.token-form', compact('sekolahs'));
    }

    /**
     * Validate token and redirect to scanning
     */
    public function validateToken(Request $request)
    {
        $request->validate([
            'attendance_token' => 'required|string',
            'sekolah_id' => 'required|exists:sekolahs,id'
        ]);

        // Check if token is valid for the selected school
        $validToken = AttendanceSetting::where('sekolah_id', $request->sekolah_id)
            ->where('attendance_token', $request->attendance_token)
            ->where('is_active', true)
            ->exists();

        if (!$validToken) {
            return redirect()->back()->with('error', 'Token tidak valid atau tidak aktif');
        }

        // Store token in session for next step
        $request->session()->put('attendance_token', $request->attendance_token);
        $request->session()->put('sekolah_id', $request->sekolah_id);

        // Redirect to scanning page (you'll need to create this route/view)
        return redirect()->route('attendance.check-in');
    }

    /**
     * Scanning page
     */
    public function scanAttendance()
    {
        // Retrieve token from session
        $attendanceToken = session('attendance_token');
        $sekolahId = session('sekolah_id');

        // Validate session data
        if (!$attendanceToken || !$sekolahId) {
            return redirect()->route('attendance.token')->with('error', 'Silakan masukkan token terlebih dahulu');
        }

        return view('attendance.scan', [
            'attendanceToken' => $attendanceToken,
            'sekolahId' => $sekolahId
        ]);
    }
}