<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataSiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $dataSiswa;

    public function __construct($dataSiswa)
    {
        $this->dataSiswa = $dataSiswa;
    }

    public function collection()
    {
        return $this->dataSiswa;
    }

    public function headings(): array
    {
        return [
            'No',
            'NISN',
            'NIS',
            'NIK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Kelas',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Alamat',
            'Provinsi',
            'Kabupaten/Kota',
            'Kecamatan',
            'Desa/Kelurahan',
            'Kode Pos',
            'Tinggal Dengan',
            'Transportasi',
            'No. HP',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'email Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'email Ibu',
            'Nama Wali',
            'Pekerjaan Wali',
            'Tinggi Badan (cm)',
            'Berat Badan (kg)',
            'No. KKS',
            'No. KPH',
            'No. KIP',
        ];
    }

    public function map($siswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $siswa->nisn,
            $siswa->nis,
            $siswa->nik,
            $siswa->nama_lengkap,
            $siswa->jenis_kelamin,
            $siswa->kelas ? $siswa->kelas->nama_kelas : 'Belum Ada Kelas',
            $siswa->tmp_lahir,
            date('d/m/Y', strtotime($siswa->tgl_lahir)),
            $siswa->agama,
            $siswa->user->alamat ?? '',
            $siswa->province ? $siswa->province->name : '',
            $siswa->city ? $siswa->city->name : '',
            $siswa->district ? $siswa->district->name : '',
            $siswa->village ? $siswa->village->name : '',
            $siswa->kode_pos,
            $siswa->tinggal,
            $siswa->transport,
            $siswa->hp,
            $siswa->ayah,
            $siswa->kerja_ayah,
            $siswa->email_ayah,
            $siswa->ibu,
            $siswa->kerja_ibu,
            $siswa->email_ibu,
            $siswa->wali,
            $siswa->kerja_wali,
            $siswa->tb,
            $siswa->bb,
            $siswa->kks,
            $siswa->kph,
            $siswa->kip,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Data Siswa';
    }
}