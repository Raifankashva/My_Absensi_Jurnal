<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use App\Exports\DataSiswaExport;
use Maatwebsite\Excel\Facades\Excel;


class DataSiswaController extends Controller
{
    public function index(Request $request)
    {
        $dataSiswa = DataSiswa::with(['user', 'sekolah', 'kelas', 'province', 'city', 'district', 'village'])
            ->latest()
            ->paginate(10);
    
        $sekolahs = Sekolah::all();
        $allKelas = Kelas::all();
    
        // Optionally filter based on request inputs
        $groupedStudents = Sekolah::with(['kelas.siswa' => function ($query) use ($request) {
            if ($request->filled('kelas_id')) {
                $query->where('kelas_id', $request->kelas_id);
            }
        }])->get();
    
        // Buat QR Code untuk setiap siswa dalam hasil paginasi
        $writer = new PngWriter();
        $qrCodeUrls = [];
    
        foreach ($dataSiswa as $siswa) {
            $qrCode = QrCode::create($this->generateQRContent($siswa))
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
                ->setSize(300)
                ->setMargin(10)
                ->setRoundBlockSizeMode(new RoundBlockSizeMode\RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
    
            $result = $writer->write($qrCode);
    
            // Simpan QR code dengan nama unik berdasarkan ID siswa
            $qrCodePath = 'public/qrcodes/siswa-' . $siswa->id . '.png';
            Storage::put($qrCodePath, $result->getString());
    
            // Simpan URL QR Code dalam array
            $qrCodeUrls[$siswa->id] = Storage::url('qrcodes/' . $siswa->id . '.png');
        }
    
        return view('adminsiswa.index', compact('dataSiswa', 'sekolahs', 'allKelas', 'groupedStudents', 'qrCodeUrls'));
    }
    


    public function create()
    {
        $sekolahs = Sekolah::all();
        $provinces = Province::all();
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        $livingOptions = ['Ortu', 'Wali', 'Kost', 'Asrama', 'Panti'];
        
        return view('adminsiswa.create', compact('sekolahs', 'provinces', 'religions', 'livingOptions'));
    }

    // Get Kelas based on Sekolah
    public function getKelas($sekolahId)
    {
        $kelas = Kelas::where('sekolah_id', $sekolahId)->get();
        return response()->json($kelas);
    }

    // Get Cities based on Province
    public function getCities($provinceId)
    {
        $cities = Regency::where('province_id', $provinceId)->get();
        return response()->json($cities);
    }

    // Get Districts based on City
    public function getDistricts($cityId)
    {
        $districts = District::where('regency_id', $cityId)->get();
        return response()->json($districts);
    }

    // Get Villages based on District
    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get();
        return response()->json($villages);
    }


public function store(Request $request)
{
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
    
    try {
        DB::beginTransaction();
    
        // Proses pembuatan data user
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email ,  // Ensure email is constructed and saved
            'password' => bcrypt($request->password),
            'role' => 'siswa',
            'alamat' => $request->alamat ,  // Ensure alamat is passed
            'no_hp' => $request->hp ?? '-'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = Str::slug($request->nama_lengkap) . '-' . time() . '.' . $foto->getClientOriginalExtension();
            $fotoPath = $foto->storeAs('public/siswa-photos', $fotoName);
        }

        $dataSiswa = DataSiswa::create([
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

        DB::commit();

        return redirect()
            ->route('adminsiswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');

    } catch (\Exception $e) {
        DB::rollBack();

        // Log the error
        Log::error('Error creating student data', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        if (isset($fotoPath) && Storage::exists($fotoPath)) {
            Storage::delete($fotoPath);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function show($id)
{
    $dataSiswa = DataSiswa::findOrFail($id);
    $sekolahs = Sekolah::all();

    // Create QR Code
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
    
    // Store QR code image
    $qrCodePath = 'public/qrcodes/siswa-' . $dataSiswa->id . '.png';
    Storage::put($qrCodePath, $result->getString());
    
    $qrCodeUrl = Storage::url('qrcodes/siswa-' . $dataSiswa->id . '.png');
    
    return view('adminsiswa.show', compact('dataSiswa', 'sekolahs', 'qrCodeUrl'));
}

private function generateQRContent($dataSiswa)
{
    return json_encode([
        'id' => $dataSiswa->id,
        'nisn' => $dataSiswa->nisn,
        'nama' => $dataSiswa->nama_lengkap,
        'kelas' => $dataSiswa->kelas->nama_kelas ?? '',
        'sekolah' => $dataSiswa->sekolah->nama_sekolah ?? '',
    ]);
}
public function showQR($id)
    {
        $dataSiswa = DataSiswa::findOrFail($id);
        $qrContent = $this->generateQRContent($dataSiswa);
        
        return view('adminsiswa.qr-code', compact('dataSiswa', 'qrContent'));
    }
public function downloadQRCode($id)
{
    $dataSiswa = DataSiswa::findOrFail($id);
    $qrCodePath = storage_path('app/public/qrcodes/siswa-' . $id . '.png');

    return response()->download($qrCodePath, 'qrcode-' . $dataSiswa->nama_lengkap . '.png');
}

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $dataSiswa = DataSiswa::findOrFail($id);
            
            // Delete photo if exists
            if ($dataSiswa->foto) {
                Storage::delete('public/' . $dataSiswa->foto);
            }
            
            // Delete associated user
            $dataSiswa->user()->delete();
            
            // Delete student data
            $dataSiswa->delete();

            DB::commit();

            return redirect()
                ->route('adminsiswa.index')
                ->with('success', 'Data siswa berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function export() 
    {
        // Generate QR Code untuk semua siswa terlebih dahulu
        $dataSiswa = DataSiswa::all();
        foreach ($dataSiswa as $siswa) {
            // Gunakan fungsi yang sudah ada untuk generate QR
            $writer = new PngWriter();
            $qrCode = QrCode::create($this->generateQRContent($siswa))
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
                ->setSize(300)
                ->setMargin(10)
                ->setRoundBlockSizeMode(new RoundBlockSizeMode\RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
    
            // Add Logo if exists
            $logoPath = public_path('images/logo.png');
            if (file_exists($logoPath)) {
                $logo = Logo::create($logoPath)->setResizeToWidth(50);
            }
    
            $result = $writer->write($qrCode);
            
            // Store QR code
            $qrCodePath = 'public/qrcodes/siswa-' . $siswa->id . '.png';
            Storage::put($qrCodePath, $result->getString());
        }
    
        return Excel::download(new DataSiswaExport, 'data_siswa.xlsx');
    }

    public function downloadSelectedQRCodes(Request $request)
{
    // Validate the request
    $request->validate([
        'selected_students' => 'required|array',
        'selected_students.*' => 'exists:data_siswa,id'
    ]);

    // Check if no students were selected
    if (empty($request->selected_students)) {
        return redirect()->back()->with('error', 'Pilih minimal satu siswa untuk di-download QR Code-nya.');
    }

    // If only one student is selected, download individual QR
    if (count($request->selected_students) == 1) {
        $studentId = $request->selected_students[0];
        return $this->downloadQRCode($studentId);
    }

    // Multiple students - create a zip file
    $zip = new \ZipArchive();
    $zipFileName = 'selected_students_qrcodes_' . now()->format('YmdHis') . '.zip';
    $zipFilePath = storage_path('app/public/qrcodes/' . $zipFileName);

    // Ensure the directory exists
    Storage::makeDirectory('public/qrcodes');

    if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
        foreach ($request->selected_students as $studentId) {
            $dataSiswa = DataSiswa::findOrFail($studentId);
            
            // Generate QR Code
            $writer = new PngWriter();
            $qrCode = QrCode::create($this->generateQRContent($dataSiswa))
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
                ->setSize(300)
                ->setMargin(10)
                ->setRoundBlockSizeMode(new RoundBlockSizeMode\RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));

            // Add Logo to QR Code (optional)
            $logoPath = public_path('images/logo.png');
            if (file_exists($logoPath)) {
                $logo = Logo::create($logoPath)->setResizeToWidth(50);
                $qrCode = $qrCode->setLogo($logo);
            }

            $result = $writer->write($qrCode);
            
            // Generate filename
            $filename = 'qrcode_' . $dataSiswa->nisn . '_' . $dataSiswa->nama_lengkap . '.png';
            
            // Add QR code to zip
            $zip->addFromString($filename, $result->getString());
        }

        $zip->close();

        // Download the zip file
        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    // If zip creation fails
    return redirect()->back()->with('error', 'Gagal membuat file download QR Code.');
}


    public function downloadQRCodes(Request $request)
    {
        $selectedStudents = $request->input('selected_students', []);
        
        if (empty($selectedStudents)) {
            return back()->with('error', 'Pilih minimal satu siswa untuk mengunduh QR Code.');
        }

        // Create a temporary zip file
        $zipFileName = 'qrcodes_' . time() . '.zip';
        $zipPath = storage_path('app/public/temp/' . $zipFileName);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($selectedStudents as $studentId) {
                $student = DataSiswa::find($studentId);
                if ($student) {
                    $qrCodePath = storage_path('app/public/qrcodes/siswa-' . $studentId . '.png');
                    if (file_exists($qrCodePath)) {
                        // Add file to zip with student name
                        $zip->addFile($qrCodePath, 'qrcode_' . $student->nama_lengkap . '.png');
                    }
                }
            }
            $zip->close();

            // Download zip file and then delete it
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Gagal membuat file zip QR Code.');
    }
}