<?php

namespace App\Imports;

use App\Models\DataSiswa;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;
    
    private $rowCount = 0;
    private $failures = [];

    public function model(array $row)
    {
        $this->rowCount++;
        
        // Find or create user first
        $user = User::create([
            'name' => $row['nama_lengkap'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? Str::random(8)),
            'alamat' => $row['alamat'] ?? '',
            'no_hp' => $row['hp'] ?? '',
            'role' => 'siswa',
        ]);
        
        // Find sekolah and kelas
        $sekolah = Sekolah::where('id', $row['sekolah_id'])->first();
        $kelas = Kelas::where('id', $row['kelas_id'])->first();
        
        // Create data siswa record
        return new DataSiswa([
            'user_id' => $user->id,
            'sekolah_id' => $sekolah->id,
            'kelas_id' => $kelas->id,
            'nisn' => $row['nisn'],
            'nis' => $row['nis'],
            'nik' => $row['nik'],
            'nama_lengkap' => $row['nama_lengkap'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tmp_lahir' => $row['tempat_lahir'],
            'tgl_lahir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']),
            'agama' => $row['agama'],
            'province_id' => $row['province_id'],
            'city_id' => $row['city_id'],
            'district_id' => $row['district_id'],
            'village_id' => $row['village_id'],
            'kode_pos' => $row['kode_pos'],
            'tinggal' => $row['tinggal'],
            'transport' => $row['transport'] ?? '',
            'hp' => $row['hp'] ?? null,
            'ayah' => $row['nama_ayah'] ?? '',
            'email_ayah' => $row['email_ayah'] ?? null,
            'kerja_ayah' => $row['pekerjaan_ayah'] ?? null,
            'ibu' => $row['nama_ibu'] ?? '',
            'email_ibu' => $row['email_ibu'] ?? null,
            'kerja_ibu' => $row['pekerjaan_ibu'] ?? null,
            'wali' => $row['nama_wali'] ?? null,
            'email_wali' => $row['email_wali'] ?? null,
            'kerja_wali' => $row['pekerjaan_wali'] ?? null,
            'tb' => $row['tinggi_badan'] ?? null,
            'bb' => $row['berat_badan'] ?? null,
            'kks' => $row['kks'] ?? null,
            'kph' => $row['kph'] ?? null,
            'kip' => $row['kip'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nama_lengkap' => 'required|string',
            '*.email' => 'required|string|email|unique:users,email',
            '*.nisn' => 'required|string|unique:data_siswa,nisn',
            '*.nis' => 'required|string|unique:data_siswa,nis',
            '*.nik' => 'required|string|size:16|unique:data_siswa,nik',
            '*.jenis_kelamin' => 'required|in:laki-laki,Perempuan',
            '*.tempat_lahir' => 'required|string',
            '*.tanggal_lahir' => 'required',
            '*.agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            '*.sekolah_id' => 'required|exists:sekolahs,id',
            '*.kelas_id' => 'required|exists:kelas,id',
            '*.province_id' => 'required|exists:provinces,id',
            '*.city_id' => 'required|exists:regencies,id',
            '*.district_id' => 'required|exists:districts,id',
            '*.village_id' => 'required|exists:villages,id',
            '*.kode_pos' => 'required|string|size:5',
            '*.tinggal' => 'required|in:Ortu,Wali,Kost,Asrama,Panti',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $this->failures = $failures;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getFailures(): array
    {
        return $this->failures;
    }
}