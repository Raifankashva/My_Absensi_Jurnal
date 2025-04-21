<!-- resources/views/siswa/kartu-pelajar.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pelajar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .card-container {
            width: 85.6mm;
            height: 54mm;
            position: relative;
            border: 1px solid #000;
            border-radius: 3mm;
            overflow: hidden;
        }
        .card-header {
            height: 15mm;
            background-color: #01579B;
            color: white;
            text-align: center;
            position: relative;
            padding-top: 2mm;
        }
        .logo {
            position: absolute;
            top: 2mm;
            left: 3mm;
            width: 10mm;
            height: 10mm;
        }
        .header-text {
            margin: 0;
            font-size: 10pt;
            line-height: 1.2;
        }
        .card-body {
            padding: 2mm;
            position: relative;
            height: 39mm;
        }
        .photo {
            position: absolute;
            top: 2mm;
            left: 2mm;
            width: 25mm;
            height: 30mm;
            border: 0.5mm solid #ccc;
        }
        .student-info {
            position: absolute;
            top: 2mm;
            left: 29mm;
            font-size: 7pt;
            line-height: 1.3;
            width: 35mm;
        }
        .info-row {
            margin-bottom: 1mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 10mm;
        }
        .qr-code {
            position: absolute;
            bottom: 2mm;
            right: 2mm;
            width: 20mm;
            height: 20mm;
        }
        .valid-until {
            position: absolute;
            bottom: 2mm;
            left: 2mm;
            font-size: 6pt;
            font-style: italic;
        }
        .card-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: #01579B;
            color: white;
            font-size: 6pt;
            padding: 1mm 0;
        }
        .signature {
            position: absolute;
            bottom: 7mm;
            left: 30mm;
            text-align: center;
            font-size: 6pt;
            width: 25mm;
        }
        .signature-line {
            width: 25mm;
            border-bottom: 0.2mm solid #000;
            margin: 7mm auto 1mm;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <!-- Card Header -->
        <div class="card-header">
            <img src="{{ public_path('images/logo-pendidikan.png') }}" alt="Logo" class="logo">
            <h3 class="header-text">KARTU PELAJAR</h3>
            <p class="header-text">{{ $dataSiswa->sekolah->nama_sekolah }}</p>
        </div>
        
        <!-- Card Body -->
        <div class="card-body">
            <!-- Student Photo -->
            <img src="{{ $fotoPath }}" alt="Foto Siswa" class="photo">
            
            <!-- Student Information -->
            <div class="student-info">
                <div class="info-row">
                    <span class="label">Nama:</span> {{ $dataSiswa->nama_lengkap }}
                </div>
                <div class="info-row">
                    <span class="label">NISN:</span> {{ $dataSiswa->nisn }}
                </div>
                <div class="info-row">
                    <span class="label">NIS:</span> {{ $dataSiswa->nis }}
                </div>
                <div class="info-row">
                    <span class="label">TTL:</span> {{ $dataSiswa->tmp_lahir }}, {{ \Carbon\Carbon::parse($dataSiswa->tgl_lahir)->format('d-m-Y') }}
                </div>
                <div class="info-row">
                    <span class="label">Kelas:</span> {{ $dataSiswa->kelas->nama_kelas }}
                </div>
                <div class="info-row">
                    <span class="label">Alamat:</span> {{ $dataSiswa->alamat }}
                </div>
            </div>
            
            <!-- QR Code -->
            <img src="{{ $qrCodeFullPath }}" alt="QR Code" class="qr-code">
            
            <!-- Principal Signature -->
            <div class="signature">
                <div>Kepala Sekolah</div>
                <div class="signature-line"></div>
                <div>{{ $dataSiswa->sekolah->kepala_sekolah }}</div>
            </div>
            
            <!-- Validity Information -->
            <div class="valid-until">
                Berlaku s/d: {{ \Carbon\Carbon::now()->addYears(3)->format('d-m-Y') }}
            </div>
        </div>
        
        <!-- Card Footer -->
        <div class="card-footer">
            Kartu ini adalah identitas resmi pelajar {{ $dataSiswa->sekolah->nama_sekolah }}
        </div>
    </div>
</body>
</html>