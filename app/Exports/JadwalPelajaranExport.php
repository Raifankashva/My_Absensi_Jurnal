<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JadwalPelajaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $jadwalPelajaran;

    /**
     * @param $jadwalPelajaran
     */
    public function __construct($jadwalPelajaran)
    {
        $this->jadwalPelajaran = $jadwalPelajaran;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->jadwalPelajaran;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Kelas',
            'Mata Pelajaran',
            'Guru',
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $row->kelas->nama_kelas,
            $row->mata_pelajaran,
            $row->guru->nama_lengkap,
            $row->hari,
            $row->jam_mulai,
            $row->jam_selesai,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}