<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KelasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $data;
    private static $counter = 1;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Kelas',
            'Tingkat',
            'Jurusan',
            'Wali Kelas',
            'Tahun Ajaran',
            'Semester',
            'Kapasitas',
            'Jumlah Siswa',
            'Sisa Kapasitas',
            'Sekolah'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        // Calculate remaining capacity and student count
        $jumlahSiswa = $row->siswa->count();
        $sisaKapasitas = $row->kapasitas - $jumlahSiswa;

        return [
            static::$counter++,
            $row->nama_kelas,
            $row->tingkat,
            $row->jurusan ?? '-',
            $row->wali_kelas ?? '-',
            $row->tahun_ajaran,
            $row->semester,
            $row->kapasitas,
            $jumlahSiswa,
            $sisaKapasitas,
            $row->sekolah->nama_sekolah
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (header row) as bold with background color
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2EFDA']
                ]
            ],
        ];
    }
}