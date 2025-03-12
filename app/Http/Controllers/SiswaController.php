<?php

namespace App\Http\Controllers;


use App\Models\User; // Ensure this is imported

use Illuminate\Http\Request;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Pdf;



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
        'dataSiswa.sekolah',
        'dataSiswa.absensi' // Tambahkan relasi absensi
    ]);

    // Ambil data absensi siswa yang login
    $absensi = $user->dataSiswa->absensi->sortByDesc('waktu_scan');

    // Kelompokkan jadwal berdasarkan hari
    $jadwalPerHari = $user->dataSiswa->kelas->jadwalPelajaran->groupBy('hari');
    
    // Generate QR Code for the logged-in student
    $dataSiswa = $user->dataSiswa;
    $qrCodePath = 'public/qrcodes/siswa-' . $dataSiswa->id . '.png';
    
    // Check if QR code already exists, if not generate it
    if (!Storage::exists($qrCodePath)) {
        $writer = new PngWriter();
        $qrCode = QrCode::create($this->generateQRContent($dataSiswa))
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeMode\RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $result = $writer->write($qrCode);
        
        // Make sure directory exists
        Storage::makeDirectory('public/qrcodes');
        
        // Save the QR code
        Storage::put($qrCodePath, $result->getString());
    }
    
    // Get the QR code URL for view
    $qrCodeUrl = Storage::url('qrcodes/siswa-' . $dataSiswa->id . '.png');

    return view('siswa.dashboard', compact('user', 'jadwalPerHari', 'absensi', 'qrCodeUrl'));
}
public function generateStudentCard()
{
    $user = auth()->user()->load('dataSiswa.sekolah', 'dataSiswa.kelas');
    $dataSiswa = $user->dataSiswa;
    
    // Pastikan hanya data siswa yang sesuai yang dapat diunduh
    if (!$dataSiswa) {
        return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
    }
    
    // Path QR Code
    $qrCodePath = 'qrcodes/siswa-' . $dataSiswa->id . '.png';
    
    // Check if QR code exists, if not generate it
    if (!Storage::exists('public/' . $qrCodePath)) {
        Storage::makeDirectory('public/qrcodes');
        $qrCode = QrCode::size(150)->generate($this->generateQRContent($dataSiswa));
        Storage::put('public/' . $qrCodePath, $qrCode);
    }
    
    // Prepare data for the PDF
    $pdf = Pdf::loadView('siswa.kartu_pelajar', [
        'user' => $user,
        'dataSiswa' => $dataSiswa,
        'qrCodePath' => Storage::url($qrCodePath)
    ])->setPaper('a4', 'landscape');
    
    // Set file name
    $fileName = 'Kartu_Pelajar_' . $dataSiswa->id . '.pdf';

    // Return PDF for download
    return $pdf->download($fileName);
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