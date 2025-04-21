<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SchoolsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $schools;

    public function __construct($schools)
    {
        $this->schools = $schools;
    }

    public function collection()
    {
        return $this->schools;
    }

    public function headings(): array
    {
        return [
            'NPSN',
            'Nama Sekolah',
            'Jenjang',
            'Status',
            'Alamat',
            'Provinsi',
            'Kabupaten/Kota',
            'Kecamatan',
            'Desa/Kelurahan',
            'Kode Pos',
            'Nomor Telepon',
            'Email',
            'Website',
            'Akreditasi',
            'Kepala Sekolah',
            'NIP',
            'Status Aktif'
        ];
    }

    public function map($school): array
    {
        return [
            $school->npsn,
            $school->nama_sekolah,
            $school->jenjang,
            $school->status,
            $school->alamat,
            $school->province ? $school->province->name : '',
            $school->city ? $school->city->name : '',
            $school->district ? $school->district->name : '',
            $school->village ? $school->village->name : '',
            $school->kode_pos,
            $school->no_telp,
            $school->email,
            $school->website,
            $school->akreditasi,
            $school->kepala_sekolah,
            $school->nip_kepala_sekolah,
            $school->is_active ? 'Aktif' : 'Nonaktif'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}