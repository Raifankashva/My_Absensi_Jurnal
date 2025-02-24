@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Scan QR Code Absensi</h2>

    <video id="preview" class="w-full"></video>

    <form action="{{ route('absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="nisn" id="nisn">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Absen</button>
    </form>
</div>

<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<script>
    let scanner = new Html5QrcodeScanner("preview", { fps: 10, qrbox: 250 });
    scanner.render((decodedText) => {
        document.getElementById("nisn").value = decodedText;
    });
</script>
@endsection
