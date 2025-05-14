<!-- resources/views/absensi/scan.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-lg p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Scan QR Code Absensi - {{$userSchool->nama_sekolah}}</h2>
    
    <div class="mb-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded shadow-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="font-bold">Jadwal Hari {{ $dayName }}</p>
                <p class="text-sm">Jam Masuk: {{ $settingDaily->jam_masuk }}</p>
                <p class="text-sm">Batas Terlambat: {{ $settingDaily->batas_terlambat }}</p>
                <p class="text-sm">Jam Pulang: {{ $settingDaily->jam_pulang }}</p>
                <p class="text-sm font-medium mt-1">
                    Status Sekarang: 
                    <span id="currentStatusBadge" class="px-2 py-1 rounded text-xs font-semibold {{ $currentStatus == 'Hadir' ? 'bg-green-200 text-green-800' : ($currentStatus == 'Terlambat' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                        {{ $currentStatus }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div id="camera-container" class="relative mb-4">
        <div id="reader" class="w-full h-64 overflow-hidden rounded-lg shadow-inner border-2 border-gray-300"></div>
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-70">
            <div class="w-48 h-48 border-2 border-blue-500 rounded-lg"></div>
        </div>
        <div id="camera-toggle" class="absolute bottom-2 right-2 bg-gray-800 text-white p-2 rounded-full cursor-pointer hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
    </div>
    
    <div id="scanner-status" class="text-center mb-4 text-gray-600">
        <span id="status-message">Memulai kamera...</span>
    </div>
    
    <div id="result" class="mt-4 hidden">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="font-bold">QR Code terdeteksi!</p>
                    <p id="siswaInfo" class="text-sm"></p>
                    <p id="absensiStatus" class="text-sm font-medium mt-1"></p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('absensi.store') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="nisn" id="nisn">
        <button type="submit" id="submitBtn" class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-lg w-full font-bold transition duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            Konfirmasi Absensi
        </button>
    </form>
    
    <button id="scanAgainBtn" class="mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 p-3 rounded-lg w-full font-bold transition duration-200 hidden">
        Scan QR Code Lagi
    </button>
</div>

<!-- Audio elements for scan feedback -->
<audio id="scanSuccessSound" preload="auto">
    <source src="{{ asset('sounds/success-beep.mp3') }}" type="audio/mpeg">
</audio>
<audio id="scanErrorSound" preload="auto">
    <source src="{{ asset('sounds/error-beep.mp3') }}" type="audio/mpeg">
</audio>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const html5QrCode = new Html5Qrcode("reader");
        const scanSuccessSound = document.getElementById("scanSuccessSound");
        const scanErrorSound = document.getElementById("scanErrorSound");
        const statusMessage = document.getElementById("status-message");
        const cameraToggleBtn = document.getElementById("camera-toggle");
        const scanAgainBtn = document.getElementById("scanAgainBtn");
        let currentCamera = 'environment'; // Default to back camera
        
        // Get time settings for status calculation
        const jamMasuk = "{{ $settingDaily->jam_masuk }}";
        const batasTerlambat = "{{ $settingDaily->batas_terlambat }}";
        const jamPulang = "{{ $settingDaily->jam_pulang }}";
        
        const config = { 
            fps: 10,
            qrbox: { width: 250, height: 250 },
            experimentalFeatures: {
                useBarCodeDetectorIfSupported: true
            }
        };
        
        // Function to determine attendance status based on current time
        function getAttendanceStatus() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const currentTime = `${hours}:${minutes}:${seconds}`;
            
            // Convert time strings to Date objects for comparison
            const currentDate = new Date(`1970-01-01T${currentTime}`);
            const masukDate = new Date(`1970-01-01T${jamMasuk}`);
            const terlambatDate = new Date(`1970-01-01T${batasTerlambat}`);
            const batasTidakHadirDate = new Date(terlambatDate);
            batasTidakHadirDate.setHours(batasTidakHadirDate.getHours() + 1);
            
            if (currentDate <= masukDate) {
                return { status: 'Hadir', color: 'green' };
            } else if (currentDate <= terlambatDate) {
                return { status: 'Terlambat', color: 'yellow' };
            } else if (currentDate <= batasTidakHadirDate) {
                return { status: 'Terlambat', color: 'yellow' };
            } else {
                return { status: 'Tidak Hadir', color: 'red' };
            }
        }
        
        function startScanner() {
            statusMessage.textContent = "Memulai kamera...";
            
            // Reset UI
            document.getElementById("result").classList.add("hidden");
            document.getElementById("submitBtn").disabled = true;
            scanAgainBtn.classList.add("hidden");
            
            html5QrCode.start(
                { facingMode: currentCamera }, // Use specified camera
                config,
                (decodedText) => {
                    try {
                        // Play success sound
                        scanSuccessSound.play().catch(e => console.error("Could not play sound:", e));
                        
                        // Parse the JSON data from QR
                        const data = JSON.parse(decodedText);
                        
                        // Set the NISN value in the form
                        document.getElementById("nisn").value = data.nisn;
                        
                        // Get current attendance status
                        const attendanceStatus = getAttendanceStatus();
                        
                        // Display student info
                        document.getElementById("siswaInfo").textContent = 
                            `Nama: ${data.nama}, NISN: ${data.nisn}, Kelas: ${data.kelas}`;
                        
                        // Add attendance status
                        const absensiStatusEl = document.getElementById("absensiStatus");
                        absensiStatusEl.innerHTML = `Status Kehadiran: <span class="px-2 py-1 rounded text-xs font-semibold bg-${attendanceStatus.color}-200 text-${attendanceStatus.color}-800">${attendanceStatus.status}</span>`;
                        
                        // Show result and enable submit button
                        document.getElementById("result").classList.remove("hidden");
                        document.getElementById("submitBtn").disabled = false;
                        scanAgainBtn.classList.remove("hidden");
                        
                        // Update status
                        statusMessage.textContent = "QR Code berhasil dipindai!";
                        
                        // Stop scanning after successful detection
                        html5QrCode.stop();
                    } catch (e) {
                        console.error("Error parsing QR code data:", e);
                        // Play error sound
                        scanErrorSound.play().catch(e => console.error("Could not play sound:", e));
                        statusMessage.textContent = "QR Code tidak valid. Silakan coba lagi.";
                        
                        // Continue scanning
                        setTimeout(() => {
                            statusMessage.textContent = "Memindai...";
                        }, 2000);
                    }
                },
                (errorMessage) => {
                    // On Error - just log, don't display to user
                    console.log(errorMessage);
                }
            ).catch((err) => {
                console.log(`Unable to start scanning: ${err}`);
                statusMessage.textContent = "Gagal mengakses kamera. Pastikan kamera Anda diaktifkan dan izin telah diberikan.";
            });
            
            // Update status when scanner starts successfully
            setTimeout(() => {
                if (statusMessage.textContent === "Memulai kamera...") {
                    statusMessage.textContent = "Memindai...";
                }
            }, 2000);
        }
        
        // Start scanner when page loads
        startScanner();
        
        // Handle camera toggle button
        cameraToggleBtn.addEventListener('click', () => {
            // Stop current scanner
            html5QrCode.stop().then(() => {
                // Toggle camera
                currentCamera = currentCamera === 'environment' ? 'user' : 'environment';
                // Restart scanner with new camera
                startScanner();
            }).catch(err => {
                console.error("Error stopping scanner:", err);
            });
        });
        
        // Handle scan again button
        scanAgainBtn.addEventListener('click', () => {
            startScanner();
        });
        
        // Update current status badge every minute
        setInterval(() => {
            const currentStatusBadge = document.getElementById('currentStatusBadge');
            const newStatus = getAttendanceStatus();
            
            currentStatusBadge.textContent = newStatus.status;
            currentStatusBadge.className = `px-2 py-1 rounded text-xs font-semibold bg-${newStatus.color}-200 text-${newStatus.color}-800`;
        }, 60000); // Update every minute
    });
</script>
@endsection