<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $sekolah_id;
    protected $kelas_id;
    protected $filter_type;
    protected $tanggal_mulai;
    protected $tanggal_akhir;
    protected $bulan;
    protected $tahun;

    public function __construct($sekolah_id, $kelas_id = null, $filter_type = 'date_range', 
                               $tanggal_mulai = null, $tanggal_akhir = null, 
                               $bulan = null, $tahun = null)
    {
        $this->sekolah_id = $sekolah_id;
        $this->kelas_id = $kelas_id;
        $this->filter_type = $filter_type;
        $this->tanggal_mulai = $tanggal_mulai ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_akhir = $tanggal_akhir ?? Carbon::now()->format('Y-m-d');
        $this->bulan = $bulan ?? Carbon::now()->month;
        $this->tahun = $tahun ?? Carbon::now()->year;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Absensi::with(['siswa.kelas', 'siswa.sekolah'])
            ->whereHas('siswa', function($q) {
                $q->where('sekolah_id', $this->sekolah_id);
            });
        
        if ($this->kelas_id) {
            $query->whereHas('siswa', function($q) {
                $q->where('kelas_id', $this->kelas_id);
            });
        }
        
        // Apply date filters
        switch ($this->filter_type) {
            case 'date_range':
                $query->whereDate('waktu_scan', '>=', $this->tanggal_mulai)
                      ->whereDate('waktu_scan', '<=', $this->tanggal_akhir);
                break;
            case 'month':
                $query->whereMonth('waktu_scan', $this->bulan)
                      ->whereYear('waktu_scan', $this->tahun);
                break;
            case 'year':
                $query->whereYear('waktu_scan', $this->tahun);
                break;
        }
        
        return $query->orderBy('waktu_scan', 'desc')->get();
    }
    
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'NISN',
            'Nama Siswa',
            'Kelas',
            'Tanggal',
            'Waktu',
            'Status',
        ];
    }
    
    /**
     * @param Absensi $absensi
     * @return array
     */
    public function map($absensi): array
    {
        static $row = 0;
        $row++;
        
        return [
            $row,
            $absensi->siswa->nisn,
            $absensi->siswa->nama_lengkap,
            $absensi->siswa->kelas->nama_kelas ?? 'N/A',
            Carbon::parse($absensi->waktu_scan)->format('d/m/Y'),
            Carbon::parse($absensi->waktu_scan)->format('H:i:s'),
            $absensi->status,
        ];
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        switch ($this->filter_type) {
            case 'date_range':
                return 'Absensi ' . Carbon::parse($this->tanggal_mulai)->format('d/m/Y') . ' - ' . 
                       Carbon::parse($this->tanggal_akhir)->format('d/m/Y');
            case 'month':
                return 'Absensi ' . Carbon::createFromDate($this->tahun, $this->bulan, 1)->translatedFormat('F Y');
            case 'year':
                return 'Absensi Tahun ' . $this->tahun;
            default:
                return 'Data Absensi';
        }
    }
    
    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Auto-size columns
        foreach(range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Add conditional formatting for status column
        $lastRow = $sheet->getHighestRow();
        
        // Set color for "Hadir" status (Green)
        $sheet->getStyle('G2:G'.$lastRow)
            ->getConditionalStyles()
            ->addConditionalStyle(
                new \PhpOffice\PhpSpreadsheet\Style\Conditional(
                    \PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_EQUAL,
                    'Hadir',
                    ['font' => ['color' => ['rgb' => '008000']]]
                )
            );
        
        // Set color for "Terlambat" status (Orange)
        $sheet->getStyle('G2:G'.$lastRow)
            ->getConditionalStyles()
            ->addConditionalStyle(
                new \PhpOffice\PhpSpreadsheet\Style\Conditional(
                    \PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_EQUAL,
                    'Terlambat',
                    ['font' => ['color' => ['rgb' => 'FFA500']]]
                )
            );
        
        // Set color for "Tidak Hadir" status (Red)
        $sheet->getStyle('G2:G'.$lastRow)
            ->getConditionalStyles()
            ->addConditionalStyle(
                new \PhpOffice\PhpSpreadsheet\Style\Conditional(
                    \PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_EQUAL,
                    'Tidak Hadir',
                    ['font' => ['color' => ['rgb' => 'FF0000']]]
                )
            );
    }
}