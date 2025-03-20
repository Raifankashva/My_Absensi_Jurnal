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

public function profile()
{
    $user = User::find(auth()->id())->load('dataSiswa');
    $dataSiswa = $user->dataSiswa;
    
    return view('siswa.profile', compact('dataSiswa'));
}

// Update student's profile
public function updateProfile(Request $request)
{
    // Validate the request
    $request->validate([
        'sekolah_id' => 'required|exists:sekolahs,id',
        'kelas_id' => 'required|exists:kelas,id',
        'nisn' => 'required|string|max:10|unique:data_siswa',
        'nis' => 'required|string|max:10|unique:data_siswa',
        'nik' => 'required|string|max:16|unique:data_siswa',
        'nama_lengkap' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        'tmp_lahir' => 'required|string',
        'tgl_lahir' => 'required|date',
        'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
        'province_id' => 'required|exists:provinces,id',
        'city_id' => 'required|exists:regencies,id',
        'district_id' => 'required|exists:districts,id',
        'village_id' => 'required|exists:villages,id',
        'kode_pos' => 'required|string|max:5',
        'tinggal' => 'required|in:Ortu,Wali,Kost,Asrama,Panti',
        'transport' => 'required|string',
        'hp' => 'nullable|string',
        'ayah' => 'required|string',
        'email_ayah' => 'nullable|email',
        'kerja_ayah' => 'nullable|string',
        'ibu' => 'required|string',
        'email_ibu' => 'nullable|email',
        'kerja_ibu' => 'nullable|string',
        'wali' => 'nullable|string',
        'email_wali' => 'nullable|email',
        'kerja_wali' => 'nullable|string',
        'tb' => 'nullable|integer',
        'bb' => 'nullable|integer',
        'kks' => 'nullable|string',
        'kph' => 'nullable|string',
        'kip' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'email' => 'required|email|unique:users,email',  
        'alamat' => 'required|string',
    ]);

    $user = Auth::user();
    $dataSiswa = $user->dataSiswa;

    // Update profile data
    $dataSiswa->update([
        'user_id' => $user->id,
            'sekolah_id' => $request->sekolah_id,
            'kelas_id' => $request->kelas_id,
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'foto' => $fotoPath ? str_replace('public/', '', $fotoPath) : null,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'agama' => $request->agama,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'kode_pos' => $request->kode_pos,
            'tinggal' => $request->tinggal,
            'transport' => $request->transport,
            'hp' => $request->hp,
            'ayah' => $request->ayah,
            'email_ayah' => $request->email_ayah,
            'kerja_ayah' => $request->kerja_ayah,
            'ibu' => $request->ibu,
            'email_ibu' => $request->email_ibu,
            'kerja_ibu' => $request->kerja_ibu,
            'wali' => $request->wali,
            'email_wali' => $request->email_wali,
            'kerja_wali' => $request->kerja_wali,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'kks' => $request->kks,
            'kph' => $request->kph,
            'kip' => $request->kip,
    ]);

    // If the user uploaded a new photo or file, handle the upload
    if ($request->hasFile('foto')) {
        $photoPath = $request->file('foto')->store('public/siswa-photos');
        $dataSiswa->update(['foto' => Storage::url($photoPath)]);
    }

    return redirect()->route('siswa.profile')->with('success', 'Profile updated successfully!');
}
}