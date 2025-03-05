<!-- resources/views/siswa/qr-code.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4">QR Code Siswa</h2>
    
    <div class="text-center mb-4">
        <h3 class="font-bold text-xl">{{ $dataSiswa->nama_lengkap }}</h3>
        <p>NISN: {{ $dataSiswa->nisn }}</p>
        <p>Kelas: {{ $dataSiswa->kelas->nama_kelas ?? 'Belum ada kelas' }}</p>
    </div>
    
    <div class="flex justify-center mb-4">
        <div id="qrcode"></div>
    </div>
    
    <p class="text-sm text-gray-600 text-center">Tunjukkan QR code ini untuk absensi</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrContent = @json($qrContent);
        
        const typeNumber = 0;
        const errorCorrectionLevel = 'H';
        const qr = qrcode(typeNumber, errorCorrectionLevel);
        qr.addData(qrContent);
        qr.make();
        
        document.getElementById('qrcode').innerHTML = qr.createImgTag(5);
    });
</script>
@endsection