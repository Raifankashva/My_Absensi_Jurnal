<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class GuruExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $data;

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
            'NIP',
            'NUPTK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIK',
            'Status Kepegawaian',
            'Pendidikan Terakhir',
            'Jurusan',
            'TMT Kerja',
            'Mata Pelajaran',
            'Sekolah',
            'Alamat',
            'No HP'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        $mapel = json_decode($row->mata_pelajaran, true);
        $mapelString = is_array($mapel) ? implode(', ', $mapel) : $row->mata_pelajaran;
        
        return [
            static::$counter++,
            $row->nip ?? '-',
            $row->nuptk ?? '-',
            $row->nama_lengkap,
            $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $row->tempat_lahir,
            Carbon::parse($row->tanggal_lahir)->format('d/m/Y'),
            $row->nik,
            $row->status_kepegawaian,
            $row->pendidikan_terakhir,
            $row->jurusan_pendidikan,
            Carbon::parse($row->tmt_kerja)->format('d/m/Y'),
            $mapelString,
            $row->sekolah->nama_sekolah ?? '-',
            $row->alamat,
            $row->no_hp
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (header row) as bold
            1 => ['font' => ['bold' => true]],
        ];
    }

    private static $counter = 1;
}