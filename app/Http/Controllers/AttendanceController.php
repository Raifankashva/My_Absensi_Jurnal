<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\DataSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function generateQrCode(DataSiswa $siswa)
    {
        $data = [
            'siswa_id' => $siswa->id,
            'timestamp' => now()->timestamp
        ];
        
        $qrcode = QrCode::size(300)->generate(json_encode($data));
        return view('attendance.qrcode', compact('qrcode'));
    }

    public function scanQrCode(Request $request)
    {
        try {
            $data = json_decode($request->qr_data);
            $siswa = DataSiswa::findOrFail($data->siswa_id);
            $setting = AttendanceSetting::where('sekolah_id', $siswa->sekolah_id)->first();
            
            if (!$setting) {
                return response()->json(['error' => 'Pengaturan absensi belum dibuat'], 404);
            }

            $now = Carbon::now();
            $attendance = Attendance::firstOrNew([
                'siswa_id' => $siswa->id,
                'tanggal' => $now->toDateString(),
            ]);

            // If this is first scan of the day (entering)
            if (!$attendance->jam_masuk) {
                $attendance->setting_id = $setting->id;
                $attendance->jam_masuk = $now->toTimeString();
                
                // Determine status based on entry time
                if ($now->format('H:i:s') <= $setting->jam_masuk) {
                    $attendance->status = 'hadir';
                } elseif ($now->format('H:i:s') <= $setting->batas_telat) {
                    $attendance->status = 'telat';
                } else {
                    $attendance->status = 'tidak_hadir';
                }
            }
            // If this is second scan of the day (leaving)
            elseif (!$attendance->jam_pulang && $now->format('H:i:s') >= $setting->jam_pulang) {
                $attendance->jam_pulang = $now->toTimeString();
                $attendance->status = 'pulang';
            }

            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dicatat',
                'data' => $attendance
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memproses QR Code'], 500);
        }
    }

    public function settings()
    {
        $settings = AttendanceSetting::with('sekolah')->get();
        return view('attendance.settings', compact('settings'));
    }

    public function updateSettings(Request $request, AttendanceSetting $setting)
    {
        $validated = $request->validate([
            'jam_masuk' => 'required|date_format:H:i',
            'batas_telat' => 'required|date_format:H:i|after:jam_masuk',
            'jam_pulang' => 'required|date_format:H:i|after:batas_telat',
        ]);

        $setting->update($validated);

        return redirect()->route('attendance.settings')
            ->with('success', 'Pengaturan absensi berhasil diperbarui');
    }
}