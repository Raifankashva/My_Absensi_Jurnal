<!-- resources/views/absensi/scan.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Scan QR Code Absensi</h2>
    
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif
    
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div id="reader" class="w-full"></div>
    
    <div id="result" class="mt-4 hidden">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <p class="font-bold">QR Code terdeteksi!</p>
            <p id="siswaInfo"></p>
        </div>
    </div>

    <form action="{{ route('absensi.store') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="nisn" id="nisn">
        <button type="submit" id="submitBtn" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded w-full" disabled>
            Absen
        </button>
    </form>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const html5QrCode = new Html5Qrcode("reader");
    const config = { 
        fps: 10,
        qrbox: { width: 250, height: 250 }
    };

    html5QrCode.start(
        { facingMode: "environment" }, // Use back camera
        config,
        (decodedText) => {
            try {
                // Parse the JSON data from QR
                const data = JSON.parse(decodedText);
                
                // Set the NISN value in the form
                document.getElementById("nisn").value = data.nisn;
                
                // Display student info
                document.getElementById("siswaInfo").textContent = 
                    `Nama: ${data.nama}, NISN: ${data.nisn}, Kelas: ${data.kelas}`;
                
                // Show result and enable submit button
                document.getElementById("result").classList.remove("hidden");
                document.getElementById("submitBtn").disabled = false;
                
                // Optional: Stop scanning after successful detection
                html5QrCode.stop();
            } catch (e) {
                console.error("Error parsing QR code data:", e);
                alert("QR Code tidak valid. Silakan coba lagi.");
            }
        },
        (errorMessage) => {
            // On Error
            console.log(errorMessage);
        }
    ).catch((err) => {
        console.log(`Unable to start scanning: ${err}`);
    });
</script>
@endsection