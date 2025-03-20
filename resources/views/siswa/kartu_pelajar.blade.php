<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pelajar</title>
    <style>
        @page {
            size: 85.6mm 53.98mm;
            margin: 0;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .card-container {
            width: 85.6mm;
            height: 53.98mm;
            position: relative;
            margin: 0 auto;
        }
        .card {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            color: #334155;
        }
        .card-header {
            background-color: #64748b;
            color: white;
            padding: 5px 10px;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-header-title {
            margin: 0;
        }
        .card-content {
            display: flex;
            padding: 8px;
            height: calc(100% - 50px);
        }
        .left-section {
            width: 30%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-right: 8px;
        }
        .photo-container {
            width: 60px;
            height: 75px;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .middle-section {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 5px;
        }
        .info-row {
            display: flex;
            margin-bottom: 4px;
            font-size: 8px;
        }
        .info-label {
            width: 35%;
            font-weight: bold;
            color: #475569;
        }
        .info-value {
            width: 65%;
            color: #1e293b;
        }
        .right-section {
            width: 20%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .qr-code {
            width: 45px;
            height: 45px;
            background: white;
            padding: 2px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .card-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #64748b;
            padding: 3px 0;
            text-align: center;
            font-size: 7px;
            color: white;
        }
        .accent-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: #64748b;
        }
        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }
            .card-container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card">
            <div class="accent-line"></div>
            <div class="card-header">
                <h2 class="card-header-title">Kartu Pelajar</h2>
                <span>{{ now()->format('Y') }}</span>
            </div>
            <div class="card-content">
                <div class="left-section">
                    <div class="photo-container">
                        <img class="photo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $dataSiswa->foto))) }}" alt="Foto Siswa">
                    </div>
                </div>
                <div class="middle-section">
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $dataSiswa->nama_lengkap }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">NISN</div>
                        <div class="info-value">{{ $dataSiswa->nisn }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kelas</div>
                        <div class="info-value">{{ $dataSiswa->kelas->nama_kelas }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Sekolah</div>
                        <div class="info-value">{{ $dataSiswa->sekolah->nama_sekolah }}</div>
                    </div>
                </div>
                <div class="right-section">
                    <img src="{{ public_path($qrCodePath) }}" class="qr-code" alt="QR Code">
                </div>
            </div>
            <div class="card-footer">
                Berlaku sampai: {{ now()->addYears(1)->format('d/m/Y') }}
            </div>
        </div>
    </div>
</body>
</html>