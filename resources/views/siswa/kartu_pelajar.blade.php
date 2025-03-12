<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pelajar</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e0e7ff;
        }
        .card {
            width: 85.6mm;
            height: 53.98mm;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            border: 2px solid #1e40af;
            overflow: hidden;
        }
        .left {
            width: 30%;
            text-align: center;
        }
        .left img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid white;
            object-fit: cover;
        }
        .middle {
            width: 50%;
            text-align: left;
        }
        .middle h2 {
            margin-bottom: 5px;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        .middle p {
            font-size: 9px;
            margin: 3px 0;
        }
        .right {
            width: 20%;
            text-align: center;
        }
        .qr-code {
            width: 40px;
            height: 40px;
            background: white;
            padding: 3px;
            border-radius: 5px;
            border: 1px solid #1e3a8a;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="left">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $dataSiswa->foto))) }}" alt="Foto Siswa">
        </div>
        <div class="middle">
            <h2>Kartu Pelajar</h2>
            <p><strong>Nama:</strong> {{ $dataSiswa->nama_lengkap }}</p>
            <p><strong>NISN:</strong> {{ $dataSiswa->nisn }}</p>
            <p><strong>Kelas:</strong> {{ $dataSiswa->kelas->nama_kelas }}</p>
            <p><strong>Sekolah:</strong> {{ $dataSiswa->sekolah->nama_sekolah }}</p>
        </div>
        <div class="right">
            <img src="{{ public_path($qrCodePath) }}" class="qr-code" alt="QR Code">
        </div>
    </div>
</body>
</html>
