<?php

namespace App\Http\Controllers;


use App\Models\User; // Ensure this is imported

use Illuminate\Http\Request;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Pdf;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\JadwalPelajaran;
use App\Models\DataSiswa;
use App\Models\Absensi;
use App\Models\Setting;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;



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

    $pengumuman = $user->dataSiswa->sekolah->pengumuman;

    return view('siswa.dashboard', compact('user', 'jadwalPerHari', 'absensi', 'qrCodeUrl', 'pengumuman'));
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

public function editProfile()
{
    $user = User::find(auth()->id())->load('dataSiswa');
    $dataSiswa = $user->dataSiswa;
    
    // Load provinces for the dropdown
    $provinces = Province::all();
    
    // Load cities, districts, and villages if the student already has location data
    $cities = collect();
    $districts = collect();
    $villages = collect();
    
    if ($dataSiswa->province_id) {
        $cities = Regency::where('province_id', $dataSiswa->province_id)->get();
        
        if ($dataSiswa->regency_id) {
            $districts = District::where('regency_id', $dataSiswa->regency_id)->get();
            
            if ($dataSiswa->district_id) {
                $villages = Village::where('district_id', $dataSiswa->district_id)->get();
            }
        }
    }
    
    return view('siswa.edit-profile', compact('dataSiswa', 'provinces', 'cities', 'districts', 'villages'));
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

public function cetakKartuPelajar()
{
    // Get logged in student data with relationships
    $user = User::find(auth()->id())->load([
        'dataSiswa.kelas',
        'dataSiswa.sekolah'
    ]);
    
    $dataSiswa = $user->dataSiswa;
    
    // Generate QR Code for the student
    $qrCodePath = 'public/qrcodes/siswa-' . $dataSiswa->id . '.png';
    
    // Check if QR code already exists, if not generate it
    if (!Storage::exists($qrCodePath)) {
        // Generate QR content (student ID and other necessary info)
        $qrContent = "ID:" . $dataSiswa->id . 
                     "|NISN:" . $dataSiswa->nisn . 
                     "|NAMA:" . $dataSiswa->nama_lengkap;
                     
        // Generate and store QR code
        $qrImage = QrCode::format('png')
                        ->size(300)
                        ->margin(1)
                        ->generate($qrContent);
                        
        Storage::put($qrCodePath, $qrImage);
    }
    
    // Get the QR code path for PDF
    $qrCodeFullPath = storage_path('app/' . $qrCodePath);
    
    // Get student photo path
    $fotoPath = $dataSiswa->foto ? public_path(str_replace('/storage', 'storage/app/public', $dataSiswa->foto)) 
                                : public_path('images/default-profile.png');
    
    // Card measurements (standard ID card size in mm - 85.6 x 54 mm)
    $cardWidth = 85.6;
    $cardHeight = 54;
    
    // Generate PDF with proper card size
    $pdf = Pdf::loadView('siswa.kartu-pelajar', compact('dataSiswa', 'qrCodeFullPath', 'fotoPath'))
        ->setPaper([0, 0, $cardWidth * 2.83, $cardHeight * 2.83], 'landscape'); // Convert mm to points (1mm ≈ 2.83pts)
    
    return $pdf->stream('kartu-pelajar-' . $dataSiswa->nisn . '.pdf');
}

/**
 * Helper method to generate QR content
 */
private function generateQRContent($dataSiswa)
{
    // Generate a unique identifier for this student's QR code
    $uniqueId = $dataSiswa->id . '-' . Str::random(10);
    
    // Create an array of essential student information
    $studentData = [
        'id' => $dataSiswa->id,
        'nisn' => $dataSiswa->nisn,
        'nama' => $dataSiswa->nama_lengkap,
        'sekolah' => $dataSiswa->sekolah->nama_sekolah,
        'kelas' => $dataSiswa->kelas->nama_kelas,
        'unique' => $uniqueId
    ];
    
    // Convert to JSON and encode
    return json_encode($studentData);
}

public function cetakDataSiswa()
{
    // Get logged in student data with relationships
    $user = User::find(auth()->id())->load([
        'dataSiswa.kelas',
        'dataSiswa.sekolah'
    ]);
    
    $dataSiswa = $user->dataSiswa;
    
    // Generate QR Code for the student
    $qrCodePath = 'public/qrcodes/siswa-' . $dataSiswa->id . '.png';
    
    // Check if QR code already exists, if not generate it
    if (!Storage::exists($qrCodePath)) {
        // Generate QR content (student ID and other necessary info)
        $qrContent = "ID:" . $dataSiswa->id . 
                     "|NISN:" . $dataSiswa->nisn . 
                     "|NAMA:" . $dataSiswa->nama_lengkap . 
                     "|SEKOLAH:" . $dataSiswa->sekolah->nama_sekolah;
                     
        // Generate and store QR code
        $qrImage = QrCode::format('png')
                        ->size(200)
                        ->margin(1)
                        ->generate($qrContent);
                        
        Storage::put($qrCodePath, $qrImage);
    }
    
    // Get the QR code path for PDF
    $qrCodeFullPath = storage_path('app/' . $qrCodePath);
    
    // Get student photo path
    $fotoPath = $dataSiswa->foto ? public_path(str_replace('/storage', '/public', $dataSiswa->foto)) 
                                : public_path('images/default-profile.png');
    
    // Generate PDF with A4 size
    $pdf = Pdf::loadView('siswa.cetak-data-siswa', compact('dataSiswa', 'qrCodeFullPath', 'fotoPath'));
    
    return $pdf->stream('data-siswa-' . $dataSiswa->nisn . '.pdf');
}
}