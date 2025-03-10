<?php

namespace App\Imports;

use App\Models\User;
use App\Models\DataSiswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DataSiswaImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $sekolahId;
    protected $kelasId;
    private $successCount = 0;
    private $failedCount = 0;
    private $newUsers = [];
    private $failedImports = [];

    public function __construct($sekolahId, $kelasId)
    {
        $this->sekolahId = $sekolahId;
        $this->kelasId = $kelasId;
    }

    public function collection(Collection $rows)
    {
        $rowNum = 2; // Starting from row 2 (after headers)
        
        foreach ($rows as $row) {
            try {
                // Perform validation
                $validator = Validator::make($row->toArray(), $this->rules());
                
                if ($validator->fails()) {
                    $this->addFailedImport($rowNum, $row, 'Validasi gagal: ' . $validator->errors()->first());
                    $rowNum++;
                    continue;
                }
                
                // Generate a random password for the user
                $password = Str::random(8);
                
                // Create user first
                $user = User::create([
                    'name' => $row['nama_lengkap'],
                    'email' => $row['email'],
                    'password' => bcrypt($password),
                    'role' => 'siswa',
                    'alamat' => $row['alamat'] ?? '-',
                    'no_hp' => $row['hp'] ?? '-'
                ]);
                
                // Format date from Excel if needed
                $tglLahir = $row['tgl_lahir'];
                if (is_numeric($tglLahir)) {
                    $tglLahir = Date::excelToDateTimeObject($tglLahir)->format('Y-m-d');
                }
                
                // Create student data
                DataSiswa::create([
                    'user_id' => $user->id,
                    'sekolah_id' => $this->sekolahId,
                    'kelas_id' => $this->kelasId,
                    'nisn' => $row['nisn'],
                    'nis' => $row['nis'],
                    'nik' => $row['nik'],
                    'nama_lengkap' => $row['nama_lengkap'],
                    'foto' => null, // Excel import doesn't handle files
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'tmp_lahir' => $row['tmp_lahir'],
                    'tgl_lahir' => $tglLahir,
                    'agama' => $row['agama'],
                    'province_id' => $row['province_id'],
                    'city_id' => $row['city_id'],
                    'district_id' => $row['district_id'],
                    'village_id' => $row['village_id'],
                    'kode_pos' => $row['kode_pos'],
                    'tinggal' => $row['tinggal'],
                    'transport' => $row['transport'],
                    'hp' => $row['hp'] ?? null,
                    'ayah' => $row['ayah'],
                    'kerja_ayah' => $row['kerja_ayah'] ?? null,
                    'ibu' => $row['ibu'],
                    'kerja_ibu' => $row['kerja_ibu'] ?? null,
                    'wali' => $row['wali'] ?? null,
                    'kerja_wali' => $row['kerja_wali'] ?? null,
                    'tb' => $row['tb'] ?? null,
                    'bb' => $row['bb'] ?? null,
                    'kks' => $row['kks'] ?? null,
                    'kph' => $row['kph'] ?? null,
                    'kip' => $row['kip'] ?? null,
                ]);
                
                // Add to successful imports
                $this->newUsers[] = [
                    'name' => $row['nama_lengkap'],
                    'nisn' => $row['nisn'],
                    'email' => $row['email'],
                    'password' => $password
                ];
                
                $this->successCount++;
            } catch (\Exception $e) {
                $this->addFailedImport($rowNum, $row, $e->getMessage());
                
                // Optionally delete the user if student creation failed
                if (isset($user)) {
                    $user->delete();
                }
            }
            
            $rowNum++;
        }
    }

    public function rules(): array
    {
        return [
            'nisn' => 'required|string|max:10|unique:data_siswa',
            'nis' => 'required|string|max:10|unique:data_siswa',
            'nik' => 'required|string|max:16|unique:data_siswa',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tmp_lahir' => 'required|string',
            'tgl_lahir' => 'required',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' =>'required|exists:villages,id',
            'kode_pos' => 'required|string|max:5',
            'tinggal' => 'required|string',
            'transport' => 'required|string',
            'hp' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users',
            'ayah' => 'required|string',
            'kerja_ayah' => 'nullable|string',
            'ibu' => 'required|string',
            'kerja_ibu' => 'nullable|string',
            'wali' => 'nullable|string',
            'kerja_wali' => 'nullable|string',
            'tb' => 'nullable|numeric',
            'bb' => 'nullable|numeric',
            'kks' => 'nullable|string',
            'kph' => 'nullable|string',
            'kip' => 'nullable|string',
        ];
    }

    private function addFailedImport($rowNum, $row, $errorMessage)
    {
        $this->failedImports[] = [
            'row' => $rowNum,
            'data' => $row->toArray(),
            'error' => $errorMessage,
        ];

        Log::error("Import Gagal di Baris {$rowNum}: {$errorMessage}");
        $this->failedCount++;
    }

    public function getImportSummary()
    {
        return [
            'success' => $this->successCount,
            'failed' => $this->failedCount,
            'new_users' => $this->newUsers,
            'failed_imports' => $this->failedImports,
        ];
    }
}
