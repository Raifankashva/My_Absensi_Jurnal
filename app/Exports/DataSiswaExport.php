<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataSiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithDrawings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DataSiswa::with(['sekolah', 'kelas', 'province', 'city', 'district', 'village'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NISN',
            'NIS',
            'NIK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Sekolah',
            'Kelas',
            'Provinsi',
            'Kota/Kabupaten',
            'Kecamatan',
            'Desa/Kelurahan',
            'Kode Pos',
            'Tinggal Dengan',
            'Transportasi',
            'No. HP',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Nama Wali',
            'Pekerjaan Wali',
            'Tinggi Badan',
            'Berat Badan',
            'No. KKS',
            'No. KPH',
            'No. KIP',
            'QR Code'  // Tambah kolom QR Code
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->nisn,
            $row->nis,
            $row->nik,
            $row->nama_lengkap,
            $row->jenis_kelamin,
            $row->tmp_lahir,
            $row->tgl_lahir,
            $row->agama,
            $row->sekolah->nama_sekolah ?? '',
            $row->kelas->nama_kelas ?? '',
            $row->province->name ?? '',
            $row->city->name ?? '',
            $row->district->name ?? '',
            $row->village->name ?? '',
            $row->kode_pos,
            $row->tinggal,
            $row->transport,
            $row->hp,
            $row->ayah,
            $row->kerja_ayah,
            $row->ibu,
            $row->kerja_ibu,
            $row->wali,
            $row->kerja_wali,
            $row->tb,
            $row->bb,
            $row->kks,
            $row->kph,
            $row->kip,
            $row->qr_code // Kolom kosong untuk QR Code
        ];
    }

    /**
     * @return array
     */
    public function drawings()
    {
        $drawings = [];
        $rows = $this->collection();
        
        foreach ($rows as $index => $row) {
            $qrPath = storage_path('app/public/qrcodes/siswa-' . $row->id . '.png');
            
            if (file_exists($qrPath)) {
                $drawing = new Drawing();
                $drawing->setName('QR Code');
                $drawing->setDescription('QR Code');
                $drawing->setPath($qrPath);
                $drawing->setHeight(50);
                $drawing->setCoordinates('AD' . ($index + 2)); // Kolom AD, baris sesuai data
                $drawings[] = $drawing;
            }
        }
        
        return $drawings;
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Set lebar kolom QR Code
        $sheet->getColumnDimension('AD')->setWidth(15);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}