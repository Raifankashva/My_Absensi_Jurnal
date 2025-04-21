{{-- resources/views/absensi/pdf_export.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin-bottom: 5px;
        }
        .school-info {
            text-align: center;
            margin-bottom: 10px;
        }
        .filter-info {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-Hadir {
            color: green;
        }
        .status-Terlambat {
            color: orange;
        }
        .status-TidakHadir {
            color: red;
        }
        .status-Izin {
            color: blue;
        }
        .status-Sakit {
            color: purple;
        }
        .summary {
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .summary table {
            width: 50%;
            margin: 0 auto;
        }
        .summary h3 {
            text-align: center;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
            page-break-inside: avoid;
        }
        .page-break {
            page-break-after: always;
        }
        .footer {
            text-align: center;
            font-size: 10pt;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN ABSENSI SISWA</h1>
        <div class="school-info">
            <strong>{{ $authSchool->nama_sekolah }}</strong><br>
            {{ $authSchool->alamat }}<br>
            Telp: {{ $authSchool->telepon }}
        </div>
    </div>
    
    <div class="filter-info">
        {{ $period }}
        @if($kelasName)
        <br>Kelas: {{ $kelasName }}
        @endif
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">NISN</th>
                <th width="25%">Nama Siswa</th>
                <th width="15%">Kelas</th>
                <th width="15%">Tanggal</th>
                <th width="10%">Waktu</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @if(count($absensi) > 0)
                @php $no = 1; @endphp
                @foreach($absensi as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->siswa->nisn }}</td>
                        <td>{{ $item->siswa->nama_lengkap }}</td>
                        <td>{{ $item->siswa->kelas->nama_kelas ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->waktu_scan)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->waktu_scan)->format('H:i:s') }}</td>
                        <td class="status-{{ str_replace(' ', '', $item->status) }}">{{ $item->status }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data absensi</td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="summary">
        <h3>Rekapitulasi</h3>
        <table>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
            @php
                $total = $totalHadir + $totalTerlambat + $totalTidakHadir + $totalIzin + $totalSakit;
                $percentHadir = $total > 0 ? round(($totalHadir / $total) * 100, 1) : 0;
                $percentTerlambat = $total > 0 ? round(($totalTerlambat / $total) * 100, 1) : 0;
                $percentTidakHadir = $total > 0 ? round(($totalTidakHadir / $total) * 100, 1) : 0;
                $percentIzin = $total > 0 ? round(($totalIzin / $total) * 100, 1) : 0;
                $percentSakit = $total > 0 ? round(($totalSakit / $total) * 100, 1) : 0;
            @endphp
            <tr>
                <td>Hadir</td>
                <td>{{ $totalHadir }}</td>
                <td>{{ $percentHadir }}%</td>
            </tr>
            <tr>
                <td>Terlambat</td>
                <td>{{ $totalTerlambat }}</td>
                <td>{{ $percentTerlambat }}%</td>
            </tr>
            <tr>
                <td>Tidak Hadir</td>
                <td>{{ $totalTidakHadir }}</td>
                <td>{{ $percentTidakHadir }}%</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td>{{ $totalIzin }}</td>
                <td>{{ $percentIzin }}%</td>
            </tr>
            <tr>
                <td>Sakit</td>
                <td>{{ $totalSakit }}</td>
                <td>{{ $percentSakit }}%</td>
            </tr>
            <tr>
                <th>Total</th>
                <th>{{ $total }}</th>
                <th>100%</th>
            </tr>
        </table>
    </div>
    
    <div class="signature">
        <p>{{ $authSchool->kota }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Kepala Sekolah</p>
        <br><br><br>
        <p>____________________________</p>
        <p>{{ $authSchool->kepala_sekolah }}</p>
    </div>
    
    <div class="footer">
        Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}
    </div>
</body>
</html>