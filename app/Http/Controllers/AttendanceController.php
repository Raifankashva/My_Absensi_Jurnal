<?php

namespace App\Http\Controllers;


use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\DataSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('siswa')
            ->where('sekolah_id', auth()->user()->sekolah_id)
            ->whereDate('tanggal', Carbon::today())
            ->get();

        $siswa = DataSiswa::where('sekolah_id', auth()->user()->sekolah_id)->get();
        return view('attendance.index', compact('attendances', 'siswa'));
    }

    public function scanPage()
    {
        $setting = AttendanceSetting::where('sekolah_id', auth()->user()->sekolah_id)->firstOrFail();
        return view('attendance.scan', compact('setting'));
    }

    public function processQr(Request $request)
    {
        $request->validate([
            'nisn' => 'required',
            'token' => 'required',
            'photo' => 'required|image',
        ]);

        $setting = AttendanceSetting::where('token', $request->token)->firstOrFail();
        $siswa = DataSiswa::where('nisn', $request->nisn)
            ->where('sekolah_id', $setting->sekolah_id)
            ->firstOrFail();

        $now = Carbon::now();
        $attendance = Attendance::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        // Store photo
        $photo = $request->file('photo');
        $photoName = time() . '_' . $siswa->id . '.' . $photo->getClientOriginalExtension();
        $photo->storeAs('public/attendance_photos', $photoName);

        if (!$attendance) {
            // Process entry
            $status = $now->format('H:i:s') <= $setting->batas_telat ? 'hadir' : 'telat';
            Attendance::create([
                'siswa_id' => $siswa->id,
                'sekolah_id' => $setting->sekolah_id,
                'tanggal' => $now->toDateString(),
                'status' => $status,
                'jam_masuk' => $now->format('H:i:s'),
                'foto_masuk' => $photoName,
                'metode' => 'qr',
                'created_by' => auth()->id(),
            ]);
            return response()->json(['message' => 'Entry recorded']);
        } else {
            // Process exit
            $attendance->update([
                'jam_pulang' => $now->format('H:i:s'),
                'foto_keluar' => $photoName,
            ]);
            return response()->json(['message' => 'Exit recorded']);
        }
    }

    public function manualAttendance(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'status' => 'required|in:hadir,telat,izin,sakit,alfa',
            'keterangan' => 'required_unless:status,hadir,telat',
        ]);

        Attendance::create([
            'siswa_id' => $request->siswa_id,
            'sekolah_id' => auth()->user()->sekolah_id,
            'tanggal' => Carbon::today(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'metode' => 'manual',
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Manual attendance recorded');
    }
}