<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - {{ $dataSiswa->nama_lengkap }}</title>
    <style>
        /* PDF-friendly styles with system fonts and simpler CSS */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            color: #000000;
            line-height: 1.5;
            font-size: 12pt;
        }
        
        .document {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #cccccc;
        }
        
        .header {
            text-align: center;
            padding: 20px;
            background-color: #3366cc !important; /* Important for PDF rendering */
            color: #ffffff !important; /* Important for PDF rendering */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        .title {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .school-info {
            font-size: 12pt;
            margin-top: 5px;
        }
        
        .content {
            padding: 20px;
        }
        
        .profile-section {
            margin-bottom: 30px;
            border: 1px solid #cccccc;
            padding: 15px;
            background-color: #f5f5f5 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
            overflow: hidden; /* Clearfix for floats */
        }
        
        .photo-container {
            float: left;
            width: 25%;
            padding-right: 15px;
        }
        
        .photo {
            width: 3cm;
            height: 4cm;
            border: 2px solid #000000;
        }
        
        .student-basic-info {
            float: left;
            width: 50%;
        }
        
        .qr-container {
            float: right;
            width: 25%;
            text-align: right;
        }
        
        .qr-code {
            width: 100px;
            height: 100px;
            border: 1px solid #cccccc;
        }
        
        .info-section {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 1px solid #3366cc;
            padding: 15px;
            clear: both;
        }
        
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #3366cc;
            color: #3366cc;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table tr:nth-child(even) {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        .info-table td {
            padding: 8px;
            vertical-align: top;
            border-bottom: 1px solid #dddddd;
        }
        
        .label {
            width: 35%;
            font-weight: bold;
            color: #333333;
        }
        
        .value {
            width: 65%;
        }
        
        .footer {
            margin-top: 30px;
            padding: 15px;
            border-top: 1px solid #cccccc;
        }
        
        .date-printed {
            text-align: right;
            font-size: 9pt;
            font-style: italic;
            color: #666666;
            margin-bottom: 10px;
        }
        
        .signature-area {
            text-align: right;
            margin-top: 40px;
            margin-bottom: 10px;
            padding: 15px;
            background-color: #f5f5f5 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        .signature-name {
            font-weight: bold;
            margin-top: 30px;
            border-bottom: 1px solid #000000;
            display: inline-block;
            padding-bottom: 2px;
        }
        
        /* Table header styling */
        .table-header {
            background-color: #3366cc !important;
            color: #ffffff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
            font-weight: bold;
            padding: 8px;
        }
        
        /* Clear floats */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        
        /* Page break control */
        .page-break {
            page-break-after: always;
        }
        
        /* Ensure background colors print */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
    </style>
</head>
<body>
    <div class="document">
        <div class="header">
            <div class="title">DATA SISWA</div>
            <div class="subtitle">{{ $dataSiswa->sekolah->nama_sekolah }}</div>
            <div class="school-info">
                {{ $dataSiswa->sekolah->alamat }}<br>
                Telp: {{ $dataSiswa->sekolah->telepon ?? '-' }} | Email: {{ $dataSiswa->sekolah->email ?? '-' }}
            </div>
        </div>

        <div class="content">
            <div class="profile-section clearfix">
                <div class="photo-container">
                    <img src="{{ $fotoPath }}" alt="Foto Siswa" class="photo">
                </div>
                <div class="student-basic-info">
                    <table class="info-table">
                        <tr>
                            <td class="label">Nama Lengkap</td>
                            <td class="value">: {{ $dataSiswa->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="label">NISN</td>
                            <td class="value">: {{ $dataSiswa->nisn }}</td>
                        </tr>
                        <tr>
                            <td class="label">NIS</td>
                            <td class="value">: {{ $dataSiswa->nis }}</td>
                        </tr>
                        <tr>
                            <td class="label">Kelas</td>
                            <td class="value">: {{ $dataSiswa->kelas->nama_kelas }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tahun Ajaran</td>
                            <td class="value">: {{ $dataSiswa->kelas->tahun_ajaran ?? 'Belum diatur' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="qr-container">
                    <img src="{{ $qrCodeFullPath }}" alt="QR Code" class="qr-code">
                </div>
            </div>

            <div class="info-section">
                <div class="section-title">Data Pribadi</div>
                <table class="info-table">
                    <tr>
                        <td class="label">NIK</td>
                        <td class="value">: {{ $dataSiswa->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tempat, Tanggal Lahir</td>
                        <td class="value">: {{ $dataSiswa->tmp_lahir }}, {{ \Carbon\Carbon::parse($dataSiswa->tgl_lahir)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td class="value">: {{ $dataSiswa->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td class="label">Agama</td>
                        <td class="value">: {{ $dataSiswa->agama }}</td>
                    </tr>
                    <tr>
                        <td class="label">Alamat</td>
                        <td class="value">: {{ $dataSiswa->user->alamat }}</td>
                    </tr>
                    <tr>
                        <td class="label">Provinsi</td>
                        <td class="value">: {{ $dataSiswa->province->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kota</td>
                        <td class="value">: {{ $dataSiswa->city->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kecamatan</td>
                        <td class="value">: {{ $dataSiswa->district->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kelurahan</td>
                        <td class="value">: {{ $dataSiswa->village->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kode Pos</td>
                        <td class="value">: {{ $dataSiswa->kode_pos ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nomor HP</td>
                        <td class="value">: {{ $dataSiswa->user->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Transportasi</td>
                        <td class="value">: {{ $dataSiswa->transport }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tinggal Dengan</td>
                        <td class="value">: {{ $dataSiswa->tinggal }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tinggi Badan / Berat Badan</td>
                        <td class="value">: {{ $dataSiswa->tb ?? '-' }} cm / {{ $dataSiswa->bb ?? '-' }} kg</td>
                    </tr>
                </table>
            </div>

            <div class="info-section">
                <div class="section-title">Data Orang Tua / Wali</div>
                <table class="info-table">
                    <tr>
                        <td class="label">Nama Ayah</td>
                        <td class="value">: {{ $dataSiswa->ayah }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pekerjaan Ayah</td>
                        <td class="value">: {{ $dataSiswa->kerja_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email Ayah</td>
                        <td class="value">: {{ $dataSiswa->email_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama Ibu</td>
                        <td class="value">: {{ $dataSiswa->ibu }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pekerjaan Ibu</td>
                        <td class="value">: {{ $dataSiswa->kerja_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email Ibu</td>
                        <td class="value">: {{ $dataSiswa->email_ibu ?? '-' }}</td>
                    </tr>
                    @if($dataSiswa->wali)
                    <tr>
                        <td class="label">Nama Wali</td>
                        <td class="value">: {{ $dataSiswa->wali }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pekerjaan Wali</td>
                        <td class="value">: {{ $dataSiswa->kerja_wali ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email Wali</td>
                        <td class="value">: {{ $dataSiswa->email_wali ?? '-' }}</td>
                    </tr>
                    @endif
                </table>
            </div>

            <div class="info-section">
                <div class="section-title">Data Program Bantuan (Jika Ada)</div>
                <table class="info-table">
                    <tr>
                        <td class="label">Nomor KKS</td>
                        <td class="value">: {{ $dataSiswa->kks ?? 'Tidak Ada' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nomor KPH</td>
                        <td class="value">: {{ $dataSiswa->kph ?? 'Tidak Ada' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nomor KIP</td>
                        <td class="value">: {{ $dataSiswa->kip ?? 'Tidak Ada' }}</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <div class="date-printed">Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</div>
                <div class="signature-area">
                    {{ $dataSiswa->sekolah->kabupaten ?? '' }}, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>
                    Kepala Sekolah,<br><br><br><br>
                    <div class="signature-name">{{ $dataSiswa->sekolah->kepala_sekolah ?? 'Kepala Sekolah' }}</div>
                    NIP. {{ $dataSiswa->sekolah->nip_kepsek ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>