<!DOCTYPE html>
<html>
<head>
    <title>Data Guru</title>
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
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>DATA GURU</h2>
        <h3>{{ $schoolName }}</h3>
        <p>Periode: {{ $month }} {{ $year }}</p>
    </div>
    
    @if($data->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP/NUPTK</th>
                <th>Nama Lengkap</th>
                <th>JK</th>
                <th>Status</th>
                <th>Pendidikan</th>
                <th>TMT Kerja</th>
                <th>Mata Pelajaran</th>
                @if($schoolName == 'Semua Sekolah')
                <th>Sekolah</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $guru)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $guru->nip ?? $guru->nuptk ?? '-' }}</td>
                <td>{{ $guru->nama_lengkap }}</td>
                <td style="text-align: center;">{{ $guru->jenis_kelamin }}</td>
                <td>{{ $guru->status_kepegawaian }}</td>
                <td>{{ $guru->pendidikan_terakhir }} {{ $guru->jurusan_pendidikan }}</td>
                <td>{{ \Carbon\Carbon::parse($guru->tmt_kerja)->format('d/m/Y') }}</td>
                <td>
                    @php
                        $mapel = json_decode($guru->mata_pelajaran, true);
                        echo is_array($mapel) ? implode(', ', $mapel) : $guru->mata_pelajaran;
                    @endphp
                </td>
                @if($schoolName == 'Semua Sekolah')
                <td>{{ $guru->sekolah->nama_sekolah ?? '-' }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p>Tidak ada data guru yang ditemukan untuk periode ini.</p>
    </div>
    @endif
    
    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}</p>
    </div>
</body>
</html>