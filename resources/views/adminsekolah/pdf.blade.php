<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Sekolah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 10px;
        }
        table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <h2>DAFTAR SEKOLAH</h2>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NPSN</th>
                <th>Nama Sekolah</th>
                <th>Jenjang</th>
                <th>Status</th>
                <th>Provinsi</th>
                <th>Kabupaten/Kota</th>
                <th>Alamat</th>
                <th>Kepala Sekolah</th>
                <th>Status Aktif</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schools as $index => $school)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $school->npsn }}</td>
                <td>{{ $school->nama_sekolah }}</td>
                <td>{{ $school->jenjang }}</td>
                <td>{{ $school->status }}</td>
                <td>{{ $school->province ? $school->province->name : '-' }}</td>
                <td>{{ $school->city ? $school->city->name : '-' }}</td>
                <td>{{ $school->alamat }}</td>
                <td>{{ $school->kepala_sekolah }}</td>
                <td>{{ $school->is_active ? 'Aktif' : 'Nonaktif' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>