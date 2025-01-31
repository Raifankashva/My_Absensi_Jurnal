<?php

namespace App\Http\Controllers;

use App\Models\SchoolAttendanceSetting;
use App\Models\SchoolHoliday;
use App\Models\Attendance;
use App\Models\FaceEncoding;
use App\Models\Sekolah;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class AttendanceController extends Controller
{
    protected $faceRecognitionThreshold = 0.6; // Threshold for face matching confidence

    public function selectSchool()
    {
        $schools = Sekolah::orderBy('nama_sekolah')->get();
        return view('attendance.select-school', compact('schools'));
    }

    public function verifyToken(Request $request)
    {
        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'token' => 'required|string'
        ]);

        $setting = SchoolAttendanceSetting::where('sekolah_id', $validated['sekolah_id'])
            ->where('token', $validated['token'])
            ->where('is_active', true)
            ->first();

        if (!$setting) {
            return redirect()->back()->with('error', 'Token tidak valid atau pengaturan absensi tidak aktif');
        }

        // Check if current time is within attendance hours
        $now = Carbon::now();
        $jamMasuk = Carbon::createFromTimeString($setting->jam_masuk);
        $jamPulang = Carbon::createFromTimeString($setting->jam_pulang);
        $batasJamMasuk = Carbon::createFromTimeString($setting->batas_telat);

        // Allow attendance 30 minutes before start time
        $jamMasuk->subMinutes(30);

        if ($now->lt($jamMasuk)) {
            return redirect()->back()->with('error', 'Belum waktunya absen masuk');
        }

        if ($now->gt($jamPulang->addHours(2))) { // Give 2 hours grace period after school ends
            return redirect()->back()->with('error', 'Waktu absensi sudah berakhir');
        }

        session([
            'verified_school_id' => $validated['sekolah_id'],
            'attendance_setting' => $setting
        ]);

        return redirect()->route('attendance.scan');
    }

    public function scan()
    {
        if (!session('verified_school_id')) {
            return redirect()->route('attendance.select-school')
                ->with('error', 'Silahkan pilih sekolah terlebih dahulu');
        }

        $school = Sekolah::findOrFail(session('verified_school_id'));
        $setting = session('attendance_setting');

        // Get current attendance period (Masuk/Pulang)
        $now = Carbon::now();
        $jamMasuk = Carbon::createFromTimeString($setting->jam_masuk);
        $jamPulang = Carbon::createFromTimeString($setting->jam_pulang);
        $periode = $now->lt($jamPulang) ? 'masuk' : 'pulang';

        return view('attendance.scan', compact('school', 'periode'));
    }

    public function process(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'face_image' => 'required|string', // Base64 encoded image
            ]);

            $schoolId = session('verified_school_id');
            $setting = session('attendance_setting');

            if (!$schoolId || !$setting) {
                return redirect()->route('attendance.select-school')
                    ->with('error', 'Sesi telah berakhir. Silahkan mulai ulang.');
            }

            // Check if today is a school day
            $today = Carbon::now();
            
            // Check holidays
            $isHoliday = SchoolHoliday::where('sekolah_id', $schoolId)
                ->where('tanggal', $today->toDateString())
                ->first();

            if ($isHoliday) {
                return redirect()->back()
                    ->with('error', "Hari ini adalah hari libur: {$isHoliday->keterangan}");
            }

            // Check active days
            if (!in_array($today->dayOfWeek, $setting->hari_aktif)) {
                return redirect()->back()
                    ->with('error', 'Hari ini bukan hari aktif sekolah');
            }

            // Process face recognition
            $faceImage = $this->processBase64Image($validated['face_image']);
            $studentId = $this->recognizeFace($faceImage, $schoolId);

            if (!$studentId) {
                return redirect()->back()
                    ->with('error', 'Wajah tidak dikenali. Silahkan coba lagi.');
            }

            // Get or create attendance record
            $attendance = $this->processAttendanceRecord(
                $schoolId,
                $studentId,
                $setting,
                $faceImage
            );

            DB::commit();

            $message = $attendance->wasRecentlyCreated ? 
                'Absensi masuk berhasil dicatat' : 
                'Absensi pulang berhasil dicatat';

            return redirect()->back()->with('success', $message);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    protected function processBase64Image($base64Image)
    {
        // Remove data:image/jpeg;base64, from string
        $image = preg_replace('/^data:image\/\w+;base64,/', '', $base64Image);
        $image = str_replace(' ', '+', $image);
        
        // Generate unique filename
        $filename = 'attendance_' . time() . '_' . uniqid() . '.jpg';
        
        // Save image
        Storage::disk('public')->put('attendance/' . $filename, base64_decode($image));
        
        return 'attendance/' . $filename;
    }

    protected function recognizeFace($imagePath, $schoolId)
    {
        // Get all active face encodings for the school
        $faceEncodings = FaceEncoding::whereHas('siswa', function ($query) use ($schoolId) {
            $query->where('sekolah_id', $schoolId);
        })->where('is_active', true)->get();

        // Load the captured image
        $capturedImage = Storage::disk('public')->get($imagePath);
        
        // Here you would use a face recognition library like face-recognition.js
        // or Python's face_recognition library via API call
        // For this example, we'll simulate the recognition
        
        // In real implementation, you would:
        // 1. Extract face encodings from captured image
        // 2. Compare with stored encodings
        // 3. Return student ID of best match above threshold
        
        // Simulation for example purposes
        foreach ($faceEncodings as $encoding) {
            // In real implementation, compare face encodings here
            // If match found above threshold, return student ID
            if (rand(0, 1) == 1) { // Simulate 50% match rate for example
                return $encoding->data_siswa_id;
            }
        }

        return null;
    }

    protected function processAttendanceRecord($schoolId, $studentId, $setting, $imagePath)
    {
        $now = Carbon::now();
        $today = $now->toDateString();
        
        $jamMasuk = Carbon::createFromTimeString($setting->jam_masuk);
        $batasTelat = Carbon::createFromTimeString($setting->batas_telat);
        $jamPulang = Carbon::createFromTimeString($setting->jam_pulang);

        $attendance = Attendance::firstOrNew([
            'sekolah_id' => $schoolId,
            'data_siswa_id' => $studentId,
            'tanggal' => $today
        ]);

        // If no entry record exists, create entry record
        if (!$attendance->jam_masuk) {
            $attendance->jam_masuk = $now;
            $attendance->foto_masuk = $imagePath;
            
            // Determine entry status
            if ($now->lte($jamMasuk)) {
                $attendance->status_masuk = 'tepat_waktu';
            } elseif ($now->lte($batasTelat)) {
                $attendance->status_masuk = 'terlambat';
            } else {
                $attendance->status_masuk = 'alpha';
            }

            $attendance->status_pulang = 'belum_pulang';
        }
        // If entry exists but no exit record, create exit record
        elseif (!$attendance->jam_pulang && $now->gte($jamPulang)) {
            $attendance->jam_pulang = $now;
            $attendance->foto_pulang = $imagePath;
            
            // Determine exit status
            if ($now->gte($jamPulang)) {
                $attendance->status_pulang = 'normal';
            } else {
                $attendance->status_pulang = 'pulang_cepat';
            }
        }
        // If both records exist, don't allow another record
        else {
            throw new Exception('Anda sudah melakukan absensi masuk dan pulang hari ini');
        }

        $attendance->save();
        return $attendance;
    }

    public function report(Request $request)
    {
        $schools = Sekolah::orderBy('nama_sekolah')->get();
        $selectedSchool = null;
        $attendances = collect();

        if ($request->filled('sekolah_id')) {
            $selectedSchool = Sekolah::findOrFail($request->sekolah_id);
            
            $query = Attendance::with(['siswa', 'sekolah'])
                ->where('sekolah_id', $request->sekolah_id);

            if ($request->filled('tanggal_mulai')) {
                $query->where('tanggal', '>=', $request->tanggal_mulai);
            }

            if ($request->filled('tanggal_akhir')) {
                $query->where('tanggal', '<=', $request->tanggal_akhir);
            }

            if ($request->filled('status')) {
                $query->where(function($q) use ($request) {
                    $q->where('status_masuk', $request->status)
                      ->orWhere('status_pulang', $request->status);
                });
            }

            $attendances = $query->orderBy('tanggal', 'desc')
                               ->orderBy('jam_masuk', 'desc')
                               ->paginate(25);
        }

        return view('attendance.report', compact('schools', 'selectedSchool', 'attendances'));
    }

    public function exportReport(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai'
        ]);

        $attendances = Attendance::with(['siswa', 'sekolah'])
            ->where('sekolah_id', $request->sekolah_id)
            ->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir])
            ->orderBy('tanggal')
            ->orderBy('jam_masuk')
            ->get();

        // Generate Excel/PDF report
        // Implementation depends on your preferred export library
        // Return file download response
    }
}