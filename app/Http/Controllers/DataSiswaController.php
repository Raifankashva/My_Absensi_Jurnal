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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Exports\UserCredentialsExport;
use App\Imports\DataSiswaImport;
use App\Exports\TemplateExport;
use ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;

class DataSiswaController extends Controller
{

    
    public function index(Request $request)
{
    // Get the current logged-in user's school
    $user = auth()->user();
    $sekolah = Sekolah::where('user_id', $user->id)->firstOrFail();
    
    // Get all classes for dropdown
    $allKelas = Kelas::where('sekolah_id', $sekolah->id)->get();
    
    // Initial student query
    $dataSiswaQuery = DataSiswa::with(['user', 'sekolah', 'kelas', 'province', 'city', 'district', 'village'])
        ->where('sekolah_id', $sekolah->id);
    
    // Filter by class
    if ($request->filled('kelas_id')) {
        $dataSiswaQuery->where('kelas_id', $request->kelas_id);
    }
    
    // Search by keyword
    if ($request->filled('search')) {
        $keyword = $request->search;
        $dataSiswaQuery->where(function ($query) use ($keyword) {
            $query->where('nama_lengkap', 'like', "%{$keyword}%")
                ->orWhere('nisn', 'like', "%{$keyword}%")
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('email', 'like', "%{$keyword}%");
                });
        });
    }
    
    // Sorting
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    $dataSiswaQuery->orderBy($sortBy, $sortOrder);
    
    // Group query by class for grouped view
    $groupedStudentsQuery = clone $dataSiswaQuery;
    
    // Standard paginated results
    $dataSiswa = $dataSiswaQuery->paginate(10)->withQueryString();
    
    // Group students by class
    $groupedStudents = [];
    if ($request->get('view_mode', 'list') === 'grouped') {
        // Get students grouped by class
        $groupedStudents = $groupedStudentsQuery->get()
            ->groupBy(function($student) {
                return $student->kelas ? $student->kelas->nama_kelas : 'Belum Ada Kelas';
            });
    }
    
    // Calculate statistics
    $totalStudents = DataSiswa::where('sekolah_id', $sekolah->id)->count();
    $totalClasses = $allKelas->count();
    $maleStudents = DataSiswa::where('sekolah_id', $sekolah->id)->where('jenis_kelamin', 'L')->count();
    $femaleStudents = DataSiswa::where('sekolah_id', $sekolah->id)->where('jenis_kelamin', 'P')->count();
    
    // Generate QR codes
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
        
        $qrCodePath = 'public/qrcodes/siswa-' . $siswa->id . '.png';
        Storage::put($qrCodePath, $result->getString());
        
        $qrCodeUrls[$siswa->id] = Storage::url('qrcodes/siswa-' . $siswa->id . '.png');
    }
    
    return view('adminsiswa.index', compact(
        'dataSiswa', 
        'sekolah', 
        'allKelas', 
        'groupedStudents', 
        'qrCodeUrls',
        'totalStudents',
        'totalClasses',
        'maleStudents',
        'femaleStudents'
    ));
}   
    private function generateQRCodeForStudent($siswa)
    {
        $writer = new PngWriter();
        $qrCode = QrCode::create($this->generateQRContent($siswa))
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeMode\RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
    
        $result = $writer->write($qrCode);
        Storage::put('public/qrcodes/siswa-' . $siswa->id . '.png', $result->getString());
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

public function storeFromExcel(Request $request)
{
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls|max:10240',
        'sekolah_id' => 'required|exists:sekolahs,id',
        'kelas_id' => 'required|exists:kelas,id',
    ]);

    try {
        DB::beginTransaction();

        $file = $request->file('excel_file');
        $import = new DataSiswaImport($request->sekolah_id, $request->kelas_id);
        
        Excel::import($import, $file);
        
        $stats = $import->getStats();
        
        DB::commit();

        return redirect()
            ->route('adminsiswa.index')
            ->with('success', "Berhasil mengimpor {$stats['success']} data siswa. {$stats['failed']} data gagal diimpor.");

    } catch (\Exception $e) {
        DB::rollBack();

        // Log the error
        Log::error('Error importing student data from Excel', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function showImportForm()
    {
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        return view('adminsiswa.import', compact('sekolahs', 'kelas'));
    }

    // Process Excel import
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('excel_file');
            $import = new DataSiswaImport($request->sekolah_id, $request->kelas_id);
            
            Excel::import($import, $file);
            
            $stats = $import->getStats();
            $newUsers = $import->getNewUsers();
            $failedImports = $import->getFailedImports();
            
            // Store the generated credentials in session for display
            session(['import_results' => [
                'stats' => $stats,
                'newUsers' => $newUsers,
                'failedImports' => $failedImports
            ]]);
            
            DB::commit();

            return redirect()->route('adminsiswa.import.results');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error importing student data from Excel', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Display import results
    public function showImportResults()
    {
        if (!session('import_results')) {
            return redirect()->route('adminsiswa.import.show')
                ->with('error', 'Tidak ada hasil import yang tersedia.');
        }

        $results = session('import_results');
        $stats = $results['stats'];
        $newUsers = $results['newUsers'];
        $failedImports = $results['failedImports'];

        return view('adminsiswa.import_results', compact('stats', 'newUsers', 'failedImports'));
    }

    // Generate Excel template for import
    public function downloadTemplate()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Define the column headers
    $headers = [
        'nisn', 'nis', 'nik', 'nama_lengkap', 'jenis_kelamin', 'tmp_lahir', 
        'tgl_lahir', 'agama', 'province_id', 'city_id', 'district_id', 
        'village_id', 'kode_pos', 'tinggal', 'transport', 'hp', 
        'ayah', 'kerja_ayah', 'ibu', 'kerja_ibu', 'wali', 
        'kerja_wali', 'tb', 'bb', 'kks', 'kph', 'kip', 'email', 'alamat'
    ];
    
    // Set headers in the first row
    foreach ($headers as $index => $header) {
        $col = Coordinate::stringFromColumnIndex($index + 1);
        $sheet->setCellValue($col . '1', $header);
        $sheet->getStyle($col . '1')->getFont()->setBold(true);
    }
    
    // Add sample data in the second row
    $sampleData = [
        '1234567890', '987654321', '1234567890123456', 'Nama Siswa', 'laki-laki', 'Jakarta',
        '2000-01-01', 'Islam', '1', '1', '1', '1', '12345', 'Ortu', 'Sepeda', '081234567890',
        'Nama Ayah', 'PNS', 'Nama Ibu', 'Ibu Rumah Tangga', 'Nama Wali', 'Wiraswasta',
        '170', '65', 'KKS12345', 'KPH12345', 'KIP12345', 'email@example.com', 'Jalan Contoh No. 123'
    ];
    
    foreach ($sampleData as $index => $value) {
        $col = Coordinate::stringFromColumnIndex($index + 1);
        $sheet->setCellValue($col . '2', $value);
    }
    
    // Add dropdown for jenis_kelamin
    $jenis_kelamin_col = Coordinate::stringFromColumnIndex(array_search('jenis_kelamin', $headers) + 1);
    $validation = $sheet->getCell($jenis_kelamin_col . '2')->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setShowDropDown(true);
    $validation->setFormula1('"laki-laki,perempuan"');
    
    // Add dropdown for agama
    $agama_col = Coordinate::stringFromColumnIndex(array_search('agama', $headers) + 1);
    $validation = $sheet->getCell($agama_col . '2')->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setShowDropDown(true);
    $validation->setFormula1('"Islam,Kristen,Katolik,Hindu,Buddha,Konghucu"');
    
    // Add dropdown for tinggal
    $tinggal_col = Coordinate::stringFromColumnIndex(array_search('tinggal', $headers) + 1);
    $validation = $sheet->getCell($tinggal_col . '2')->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setShowDropDown(true);
    $validation->setFormula1('"Ortu,Wali,Kost,Asrama,Panti"');
    
    // Format all columns to auto-width
    foreach ($headers as $index => $header) {
        $col = Coordinate::stringFromColumnIndex($index + 1);
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    
    // Create the Excel file
    $writer = new Xlsx($spreadsheet);
    $filename = 'template_import_siswa.xlsx';
    $path = storage_path('app/public/' . $filename);
    
    // Save the Excel file
    $writer->save($path);
    
    // Return the file as a download
    return response()->download($path, $filename)->deleteFileAfterSend(true);
}

    // Export created user credentials
    public function exportCredentials()
    {
        if (!session('import_results') || empty(session('import_results')['newUsers'])) {
            return redirect()->route('adminsiswa.index')
                ->with('error', 'Tidak ada kredensial yang tersedia untuk diunduh.');
        }
        
        $newUsers = session('import_results')['newUsers'];
        
        return Excel::download(new UserCredentialsExport($newUsers), 'kredensial_siswa.xlsx');
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

    public function downloadQRCodes(Request $request)
    {
        $selectedStudents = $request->input('selected_students', []);
        
        if (empty($selectedStudents)) {
            return back()->with('error', 'Pilih minimal satu siswa untuk mengunduh QR Code.');
        }
    
        // If only one student is selected, use the single download function
        if (count($selectedStudents) == 1) {
            return $this->downloadQRCode($selectedStudents[0]);
        }
    
        // Create a temporary zip file
        $zipFileName = 'qrcodes_' . time() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);
        
        // Ensure the directory exists
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }
    
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($selectedStudents as $studentId) {
                $student = DataSiswa::findOrFail($studentId);
                if ($student) {
                    // Generate QR Code on the fly
                    $writer = new PngWriter();
                    $qrCode = QrCode::create($this->generateQRContent($student))
                        ->setEncoding(new Encoding('UTF-8'))
                        ->setErrorCorrectionLevel(new ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
                        ->setSize(300)
                        ->setMargin(10)
                        ->setRoundBlockSizeMode(new RoundBlockSizeMode\RoundBlockSizeModeMargin())
                        ->setForegroundColor(new Color(0, 0, 0))
                        ->setBackgroundColor(new Color(255, 255, 255));
    
                    $result = $writer->write($qrCode);
                    
                    // Add to zip with clean filename
                    $zip->addFromString('qrcode_' . $student->nama_lengkap . '.png', $result->getString());
                }
            }
            $zip->close();
    
            // Download zip file and then delete it
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Gagal membuat file zip QR Code.');
    }

public function downloadQRCode($id)
{
    $siswa = DataSiswa::findOrFail($id);
    $qrCodePath = storage_path('app/public/qrcodes/siswa-' . $siswa->id . '.png');
    
    // Check if file exists
    if (!file_exists($qrCodePath)) {
        // Generate the QR code if it doesn't exist
        $writer = new PngWriter();
        $qrCode = QrCode::create($this->generateQRContent($siswa))
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
        Storage::put('public/qrcodes/siswa-' . $siswa->id . '.png', $result->getString());
    }
    
    // Now try to download
    if (file_exists($qrCodePath)) {
        return response()->download($qrCodePath, 'qrcode-' . $siswa->nama_lengkap . '.png');
    }
    
    return back()->with('error', 'QR Code tidak dapat dibuat.');
}
public function printQRCodes(Request $request)
{
    $selectedStudents = $request->input('selected_students', []);
    
    if (empty($selectedStudents)) {
        return back()->with('error', 'Pilih minimal satu siswa untuk mencetak QR Code.');
    }

    $students = DataSiswa::whereIn('id', $selectedStudents)->get();

    $qrData = [];

    foreach ($students as $student) {
        $qrCode = \Endroid\QrCode\QrCode::create($this->generateQRContent($student))
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->setSize(200)
            ->setMargin(10)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255))
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin());

        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $base64 = base64_encode($result->getString());

        $qrData[] = [
            'nama' => $student->nama_lengkap,
            'nisn' => $student->nisn,
            'image' => 'data:image/png;base64,' . $base64
        ];
    }

    $pdf = Pdf::loadView('adminsiswa.qr_pdf', compact('qrData'))->setPaper('A4');

    return $pdf->download('qrcodes_siswa.pdf');
}
public function edit($id)
{
    $dataSiswa = DataSiswa::findOrFail($id);
    $sekolahs = Sekolah::all();
    $allKelas = Kelas::where('sekolah_id', $dataSiswa->sekolah_id)->get();
    $provinces = Province::all();
    $cities = Regency::where('province_id', $dataSiswa->province_id)->get();
    $districts = District::where('regency_id', $dataSiswa->city_id)->get();
    $villages = Village::where('district_id', $dataSiswa->district_id)->get();
    $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    $livingOptions = ['Ortu', 'Wali', 'Kost', 'Asrama', 'Panti'];
    
    return view('adminsiswa.edit', compact(
        'dataSiswa', 
        'sekolahs', 
        'allKelas', 
        'provinces', 
        'cities', 
        'districts', 
        'villages', 
        'religions', 
        'livingOptions'
    ));
}

public function update(Request $request, $id)
{
    $dataSiswa = DataSiswa::findOrFail($id);
    
    $request->validate([
        'sekolah_id' => 'required|exists:sekolahs,id',
        'kelas_id' => 'required|exists:kelas,id',
        'nisn' => 'required|string|max:10|unique:data_siswa,nisn,' . $id,
        'nis' => 'required|string|max:10|unique:data_siswa,nis,' . $id,
        'nik' => 'required|string|max:16|unique:data_siswa,nik,' . $id,
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
        'alamat' => 'required|string',
    ]);
    
    try {
        DB::beginTransaction();
        
        // Update user data
        $user = User::findOrFail($dataSiswa->user_id);
        $user->update([
            'name' => $request->nama_lengkap,
            'alamat' => $request->alamat,
            'no_hp' => $request->hp ?? '-'
        ]);
        
        // Process photo upload if provided
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($dataSiswa->foto && Storage::exists('public/' . $dataSiswa->foto)) {
                Storage::delete('public/' . $dataSiswa->foto);
            }
            
            // Upload new photo
            $foto = $request->file('foto');
            $fotoName = Str::slug($request->nama_lengkap) . '-' . time() . '.' . $foto->getClientOriginalExtension();
            $fotoPath = $foto->storeAs('public/siswa-photos', $fotoName);
            $dataSiswa->foto = str_replace('public/', '', $fotoPath);
        }
        
        // Update student data
        $dataSiswa->update([
            'sekolah_id' => $request->sekolah_id,
            'kelas_id' => $request->kelas_id,
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
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
        
        // Regenerate QR code since data has changed
        $this->generateQRCodeForStudent($dataSiswa);
        
        DB::commit();
        
        return redirect()
            ->route('adminsiswa.show', $dataSiswa->id)
            ->with('success', 'Data siswa berhasil diperbarui');
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        // Log the error
        Log::error('Error updating student data', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
}