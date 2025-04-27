<?php

namespace App\Exports;

use App\Models\DataSiswa;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    protected $sekolah_id;
    protected $kelas_id;
    protected $bulan;
    protected $tahun;
    
    public function __construct($sekolah_id, $kelas_id = null, $bulan = null, $tahun = null)
    {
        $this->sekolah_id = $sekolah_id;
        $this->kelas_id = $kelas_id;
        $this->bulan = $bulan ?? Carbon::now()->format('m');
        $this->tahun = $tahun ?? Carbon::now()->format('Y');
    }
    
    public function collection()
    {
        $siswas = DataSiswa::where('sekolah_id', $this->sekolah_id)
            ->when($this->kelas_id, function($query) {
                return $query->where('kelas_id', $this->kelas_id);
            })
            ->get();
        
        $data = [];
        $index = 1;
        
        foreach ($siswas as $siswa) {
            $absensiData = Absensi::where('siswa_id', $siswa->id)
                ->whereYear('waktu_scan', $this->tahun)
                ->whereMonth('waktu_scan', $this->bulan)
                ->get();
            
            $hadir = $absensiData->where('status', 'Hadir')->count();
            $terlambat = $absensiData->where('status', 'Terlambat')->count();
            $sakit = $absensiData->where('status', 'Sakit')->count();
            $izin = $absensiData->where('status', 'Izin')->count();
            $alpa = $absensiData->where('status', 'Alpa')->count();
            
            // Calculate school days
            $daysInMonth = Carbon::createFromDate($this->tahun, $this->bulan, 1)->daysInMonth;
            $totalSchoolDays = 0;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::createFromDate($this->tahun, $this->bulan, $day);
                $dayOfWeek = $date->dayOfWeek;
                
                if ($dayOfWeek !== 0 && $dayOfWeek !== 6) {
                    $totalSchoolDays++;
                }
            }
            
            // Calculate missing records
            $totalRecorded = $hadir + $terlambat + $sakit + $izin + $alpa;
            $tidakAda = $totalSchoolDays - $totalRecorded;
            if ($tidakAda < 0) $tidakAda = 0;
            
            // Calculate attendance percentage
            $totalKehadiran = $hadir + $terlambat;
            $persentase = $totalSchoolDays > 0 
                ? round(($totalKehadiran / $totalSchoolDays) * 100, 2)
                : 0;
            
            $data[] = [
                'No' => $index++,
                'NISN' => $siswa->nisn,
                'Nama Siswa' => $siswa->nama_lengkap,
                'Kelas' => $siswa->kelas->nama_kelas ?? 'Tidak ada kelas',
                'Hadir' => $hadir,
                'Terlambat' => $terlambat,
                'Sakit' => $sakit,
                'Izin' => $izin,
                'Alpa' => $alpa,
                'Tidak Ada Data' => $tidakAda,
                'Total Hari Sekolah' => $totalSchoolDays,
                'Persentase Kehadiran' => $persentase . '%'
            ];
        }
        
        return collect($data);
    }
    
    public function headings(): array
    {
        return [
            'No',
            'NISN',
            'Nama Siswa',
            'Kelas',
            'Hadir',
            'Terlambat',
            'Sakit',
            'Izin',
            'Alpa',
            'Tidak Ada Data',
            'Total Hari Sekolah',
            'Persentase Kehadiran'
        ];
    }
    
    public function title(): string
    {
        $bulanName = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ][$this->bulan];
        
        $kelas = $this->kelas_id ? Kelas::find($this->kelas_id)->nama_kelas : 'Semua Kelas';
        
        return "Laporan Absensi {$kelas} - {$bulanName} {$this->tahun}";
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (headers) as bold text with a background
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4285F4']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF']]
            ]
        ];
    }
}