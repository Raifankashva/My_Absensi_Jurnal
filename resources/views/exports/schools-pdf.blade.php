<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Sekolah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .footer {
            font-size: 10px;
            text-align: right;
            margin-top: 20px;
        }
        .location-info {
            margin-bottom: 20px;
            width: 100%;
            border: none;
        }
        .location-info td {
            border: none;
            padding: 3px;
            font-size: 12px;
        }
        .location-info td:first-child {
            width: 120px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>DATA SEKOLAH</h1>
    <p class="subtitle">Tanggal: {{ date('d-m-Y') }}</p>
    
    @if($locations['province'] || $locations['city'] || $locations['district'] || $locations['village'])
        <table class="location-info">
            <tbody>
                @if($locations['province'])
                <tr>
                    <td>Provinsi</td>
                    <td>: {{ $locations['province'] }}</td>
                </tr>
                @endif
                
                @if($locations['city'])
                <tr>
                    <td>Kota/Kabupaten</td>
                    <td>: {{ $locations['city'] }}</td>
                </tr>
                @endif
                
                @if($locations['district'])
                <tr>
                    <td>Kecamatan</td>
                    <td>: {{ $locations['district'] }}</td>
                </tr>
                @endif
                
                @if($locations['village'])
                <tr>
                    <td>Kelurahan/Desa</td>
                    <td>: {{ $locations['village'] }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    @endif
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NPSN</th>
                <th>Nama Sekolah</th>
                <th>Jenjang</th>
                <th>Status</th>
                <th>Akre-ditasi</th>
                <th>Alamat</th>
                <th>Kecamatan</th>
                <th>Kota/Kabupaten</th>
                <th>Kepala Sekolah</th>
                <th>No. Telepon</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schools as $index => $school)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $school->npsn }}</td>
                    <td>{{ $school->nama_sekolah }}</td>
                    <td>{{ $school->jenjang }}</td>
                    <td>{{ $school->status }}</td>
                    <td>{{ $school->akreditasi }}</td>
                    <td>{{ $school->alamat }}</td>
                    <td>{{ $school->district->name ?? '-' }}</td>
                    <td>{{ $school->city->name ?? '-' }}</td>
                    <td>{{ $school->kepala_sekolah }}</td>
                    <td>{{ $school->no_telp }}</td>
                    <td>{{ $school->email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" style="text-align: center;">Tidak ada data sekolah</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>