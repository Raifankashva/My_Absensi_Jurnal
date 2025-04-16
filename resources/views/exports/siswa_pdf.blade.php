<!-- resources/views/adminsiswa/pdf_export.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - {{ $sekolah->nama_sekolah }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            margin-bottom: 3px;
        }
        .meta {
            font-size: 12px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 10.5px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .summary {
            margin-top: 20px;
            text-align: right;
            font-size: 12px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">DATA SISWA</div>
        <div class="subtitle">{{ $sekolah->nama_sekolah }}</div>
        <div class="meta">Alamat: {{ $sekolah->alamat }}</div>
    </div>
    
    <div>
        <p><strong>Total Siswa:</strong> {{ $totalStudents }} orang (Laki-laki: {{ $maleCount }}, Perempuan: {{ $femaleCount }})</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>JK</th>
                <th>Kelas</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataSiswa as $index => $siswa)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $siswa->nisn }}</td>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $siswa->nama_lengkap }}</td>
                <td style="text-align: center;">{{ substr($siswa->jenis_kelamin, 0, 1) }}</td>
                <td>{{ $siswa->kelas ? $siswa->kelas->nama_kelas : '-' }}</td>
                <td>{{ $siswa->tmp_lahir }}, {{ date('d/m/Y', strtotime($siswa->tgl_lahir)) }}</td>
                <td>{{ $siswa->user->alamat ?? '-' }}</td>
                <td>{{ $siswa->hp ?? '-' }}</td>
                <td>{{ $siswa->ayah }}</td>
                <td>{{ $siswa->ibu }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align: center;">Tidak ada data siswa</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ $today }}</p>
        <p style="margin-top: 50px;">
            Kepala Sekolah<br><br><br><br>
            ___________________________<br>
            {{ $sekolah->kepala_sekolah ?? '.........................' }}
        </p>
    </div>
</body>
</html>