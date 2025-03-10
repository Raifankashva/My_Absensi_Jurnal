<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Absensi Siswa</title>
</head>
<body>
    <p>Kepada Orang Tua/Wali,</p>
    <p>Berikut adalah informasi absensi anak Anda:</p>

    <ul>
        <li><strong>Nama Siswa:</strong> {{ $siswa->nama_lengkap }}</li>
        <li><strong>NISN:</strong> {{ $siswa->nisn }}</li>
        <li><strong>Waktu Scan:</strong> {{ $waktu_scan }}</li>
        <li><strong>Status Kehadiran:</strong> {{ $status }}</li>
    </ul>

    <p>Terima kasih.</p>
</body>
</html>
