<?php
namespace App\Exports;

use App\Models\DataSiswa;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AbsensiExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithEvents
{
    protected $sekolah_id;
    protected $kelas_id;
    protected $bulan;
    protected $tahun;
    protected $semester;
    
    public function __construct($sekolah_id, $kelas_id, $bulan, $tahun, $semester = 'none')
    {
        $this->sekolah_id = $sekolah_id;
        $this->kelas_id = $kelas_id;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->semester = $semester;
    }
    
    public function collection()
    {
        $siswas = DataSiswa::where('sekolah_id', $this->sekolah_id)
            ->when($this->kelas_id, function($query) {
                return $query->where('kelas_id', $this->kelas_id);
            })
            ->get();
            
        $data = [];
        $no = 1;
        
        foreach ($siswas as $siswa) {
            // Check filter type
            $isAllMonths = $this->bulan === 'all';
            $isSemester = $this->semester !== 'none';
            
            // Get all attendance records based on filter
            $absensiQuery = Absensi::where('siswa_id', $siswa->id);
            
            if ($isSemester) {
                // Filter by semester (academic year, not calendar year)
                $absensiQuery->whereYear('waktu_scan', $this->tahun);
                
                if ($this->semester === 'semester1') {
                    // Semester 1: July-December
                    $absensiQuery->whereIn('waktu_scan', function($query) {
                        $query->selectRaw('waktu_scan')
                              ->from('absensi')
                              ->whereMonth('waktu_scan', '>=', 7)
                              ->whereMonth('waktu_scan', '<=', 12)
                              ->whereYear('waktu_scan', $this->tahun);
                    });
                } else if ($this->semester === 'semester2') {
                    // Semester 2: January-June
                    $absensiQuery->whereIn('waktu_scan', function($query) {
                        $query->selectRaw('waktu_scan')
                              ->from('absensi')
                              ->whereMonth('waktu_scan', '>=', 1)
                              ->whereMonth('waktu_scan', '<=', 6)
                              ->whereYear('waktu_scan', $this->tahun);
                    });
                }
            } else {
                // Filter by year
                $absensiQuery->whereYear('waktu_scan', $this->tahun);
                
                // Filter by month if not "all months"
                if (!$isAllMonths) {
                    $absensiQuery->whereMonth('waktu_scan', $this->bulan);
                }
            }
            
            $absensiData = $absensiQuery->get();
            
            $hadir = $absensiData->where('status', 'Hadir')->count();
            $terlambat = $absensiData->where('status', 'Terlambat')->count();
            $sakit = $absensiData->where('status', 'Sakit')->count();
            $izin = $absensiData->where('status', 'Izin')->count();
            $alpa = $absensiData->where('status', 'Alpa')->count();
            
            // Calculate total school days based on filter
            $totalSchoolDays = 0;
            
            // Define months to process based on filter
            $monthsToProcess = [];
            
            if ($isSemester) {
                if ($this->semester === 'semester1') {
                    // Semester 1: July-December
                    $monthsToProcess = range(7, 12);
                } else if ($this->semester === 'semester2') {
                    // Semester 2: January-June
                    $monthsToProcess = range(1, 6);
                }
            } else if ($isAllMonths) {
                // All months
                $monthsToProcess = range(1, 12);
            } else {
                // Specific month
                $monthsToProcess = [(int)$this->bulan];
            }
            
            // Calculate school days for the selected months
            foreach ($monthsToProcess as $monthNum) {
                $daysInMonth = Carbon::createFromDate($this->tahun, $monthNum, 1)->daysInMonth;
                
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $date = Carbon::createFromDate($this->tahun, $monthNum, $day);
                    $dayOfWeek = $date->dayOfWeek;
                    
                    // If day is not Saturday (6) or Sunday (0)
                    if ($dayOfWeek !== 0 && $dayOfWeek !== 6) {
                        $totalSchoolDays++;
                    }
                }
            }
            
            // Count total recorded attendance
            $totalRecorded = $hadir + $terlambat + $sakit + $izin + $alpa;
            
            // Calculate missing attendance records
            $tidakAda = $totalSchoolDays - $totalRecorded;
            if ($tidakAda < 0) $tidakAda = 0;
            
            // Get kelas name
            $kelasName = $siswa->kelas ? $siswa->kelas->nama_kelas : '-';
            
            $data[] = [
                'No' => $no++,
                'NIS' => $siswa->nis,
                'Nama' => $siswa->nama,
                'Kelas' => $kelasName,
                'Hadir' => $hadir,
                'Terlambat' => $terlambat,
                'Sakit' => $sakit,
                'Izin' => $izin,
                'Alpa' => $alpa,
                'Tanpa Kehadiran' => $tidakAda,
                'Total Hari Sekolah' => $totalSchoolDays
            ];
        }
        
        return collect($data);
    }
    
    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama',
            'Kelas',
            'Hadir',
            'Terlambat',
            'Sakit',
            'Izin',
            'Alpa',
            'Tanpa Kehadiran',  
            'Total Hari Sekolah'
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
        // Determine sheet title based on filters
        if ($this->semester !== 'none') {
            if ($this->semester === 'semester1') {
                $periodLabel = "Semester 1 ({$this->tahun})";
            } else {
                $periodLabel = "Semester 2 ({$this->tahun})";
            }
        } else if ($this->bulan === 'all') {
            $periodLabel = "Tahun {$this->tahun}";
        } else {
            $bulanName = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            ][$this->bulan];
            $periodLabel = "{$bulanName} {$this->tahun}";
        }
        
        $kelas = $this->kelas_id ? Kelas::find($this->kelas_id)->nama_kelas : 'Semua Kelas';
        
        return "Absensi {$kelas} - {$periodLabel}";
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(15);
                $event->sheet->getColumnDimension('C')->setWidth(30);
                $event->sheet->getColumnDimension('D')->setWidth(15);
                $event->sheet->getColumnDimension('E')->setWidth(10);
                $event->sheet->getColumnDimension('F')->setWidth(10);
                $event->sheet->getColumnDimension('G')->setWidth(10);
                $event->sheet->getColumnDimension('H')->setWidth(10);
                $event->sheet->getColumnDimension('I')->setWidth(10);
                $event->sheet->getColumnDimension('J')->setWidth(18);
                $event->sheet->getColumnDimension('K')->setWidth(18);
                
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:K'.$lastRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:A'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('E1:K'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}   