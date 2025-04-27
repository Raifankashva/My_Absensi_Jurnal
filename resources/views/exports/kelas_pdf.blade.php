<!-- resources/views/exports/kelas_pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Data Kelas</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin-bottom: 5px;
        }
        .sub-header {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            padding: 8px;
            font-size: 12px;
        }
        td {
            padding: 6px;
            font-size: 11px;
        }
        .no-data {
            text-align: center;
            padding: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 11px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>DATA KELAS</h2>
        <h3>{{ $sekolah->nama_sekolah }}</h3>
    </div>
    
    <div class="sub-header">
        <p>
            Tahun Ajaran: {{ $tahunAjaran }} | 
            Semester: {{ $semester }} | 
            Tingkat: {{ $tingkat }}
        </p>
    </div>
    
    @if($data->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Tingkat</th>
                <th>Jurusan</th>
                <th>Wali Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Semester</th>
                <th>Kapasitas</th>
                <th>Jumlah Siswa</th>
                <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $kelas)
            @php
                $jumlahSiswa = $kelas->siswa->count();
                $sisaKapasitas = $kelas->kapasitas - $jumlahSiswa;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $kelas->nama_kelas }}</td>
                <td>{{ $kelas->tingkat }}</td>
                <td>{{ $kelas->jurusan ?? '-' }}</td>
                <td>{{ $kelas->wali_kelas ?? '-' }}</td>
                <td>{{ $kelas->tahun_ajaran }}</td>
                <td>{{ $kelas->semester }}</td>
                <td class="text-center">{{ $kelas->kapasitas }}</td>
                <td class="text-center">{{ $jumlahSiswa }}</td>
                <td class="text-center">{{ $sisaKapasitas }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p>Tidak ada data kelas yang ditemukan untuk filter yang dipilih.</p>
    </div>
    @endif
    
    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>