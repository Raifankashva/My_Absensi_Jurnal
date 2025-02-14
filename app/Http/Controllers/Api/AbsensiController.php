<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JamSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
{
    $absensiHariIni = Absensi::where('siswa_id', auth()->user()->dataSiswa->id)
        ->whereDate('tanggal', Carbon::today())
        ->first();
        
    $riwayatAbsensi = Absensi::where('siswa_id', auth()->user()->dataSiswa->id)
        ->orderBy('tanggal', 'desc')
        ->paginate(10);
        
    return view('absensi.index', compact('absensiHariIni', 'riwayatAbsensi'));
}
    public function checkIn(Request $request)
    {
        $request->validate([
            'foto_masuk' => 'required|image',
            'lokasi_masuk' => 'required|string',
            'qr_code' => 'required|string'
        ]);

        $user = auth()->user();
        $siswa = $user->dataSiswa;
        $jamSekolah = JamSekolah::where('sekolah_id', $siswa->sekolah_id)->first();
        
        // Check if already checked in today
        $existingAbsensi = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();
            
        if ($existingAbsensi && $existingAbsensi->jam_masuk) {
            return response()->json(['message' => 'Sudah absen masuk hari ini'], 400);
        }

        // Validate QR Code
        if (!$this->validateQrCode($request->qr_code, $siswa->sekolah_id)) {
            return response()->json(['message' => 'QR Code tidak valid'], 400);
        }

        $now = Carbon::now();
        $status = 'hadir';
        
        if ($now->format('H:i:s') > $jamSekolah->jam_telat) {
            $status = 'telat';
        }

        // Store photo
        $fotoPath = $request->file('foto_masuk')->store('absensi/masuk', 'public');

        // Create or update attendance
        $absensi = Absensi::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'tanggal' => Carbon::today(),
            ],
            [
                'sekolah_id' => $siswa->sekolah_id,
                'jam_masuk' => $now,
                'status' => $status,
                'foto_masuk' => $fotoPath,
                'lokasi_masuk' => $request->lokasi_masuk,
                'qr_code' => $request->qr_code,
                'token' => Str::random(60)
            ]
        );

        return response()->json([
            'message' => 'Absen masuk berhasil',
            'data' => $absensi
        ]);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'foto_keluar' => 'required|image',
            'lokasi_keluar' => 'required|string',
            'token' => 'required|string'
        ]);

        $user = auth()->user();
        $siswa = $user->dataSiswa;
        $jamSekolah = JamSekolah::where('sekolah_id', $siswa->sekolah_id)->first();

        $absensi = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if (!$absensi) {
            return response()->json(['message' => 'Belum absen masuk hari ini'], 400);
        }

        if ($absensi->jam_keluar) {
            return response()->json(['message' => 'Sudah absen keluar hari ini'], 400);
        }

        // Validate token
        if ($absensi->token !== $request->token) {
            return response()->json(['message' => 'Token tidak valid'], 400);
        }

        $now = Carbon::now();
        
        // Check if it's not too early to leave
        if ($now->format('H:i:s') < $jamSekolah->jam_pulang) {
            return response()->json(['message' => 'Belum waktunya pulang'], 400);
        }

        // Store photo
        $fotoPath = $request->file('foto_keluar')->store('absensi/keluar', 'public');

        $absensi->update([
            'jam_keluar' => $now,
            'foto_keluar' => $fotoPath,
            'lokasi_keluar' => $request->lokasi_keluar
        ]);

        return response()->json([
            'message' => 'Absen keluar berhasil',
            'data' => $absensi
        ]);
    }

    private function validateQrCode($qrCode, $sekolahId)
    {
        // Implement your QR code validation logic here
        // This could involve checking against a valid QR code pattern for the school
        // or validating against stored valid QR codes
        return true; // Placeholder
    }
}