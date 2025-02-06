@extends('layouts.app')
@section('title', 'Settings')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">QR Code Scanner</h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div id="reader"></div>
                        <div id="camera-container" class="hidden">
                            <video id="camera" playsinline class="w-full"></video>
                            <button id="capture" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                                Capture Photo
                            </button>
                            <canvas id="canvas" class="hidden"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");
        const token = "{{ $setting->token }}";
        
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            async (decodedText) => {
                html5QrCode.stop();
                document.getElementById('camera-container').classList.remove('hidden');
                initCamera();
            },
            (error) => {}
        );

        async function initCamera() {
            const video = document.getElementById('camera');
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            video.play();
        }

        document.getElementById('capture').addEventListener('click', async () => {
            const video = document.getElementById('camera');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            
            canvas.toBlob(async (blob) => {
                const formData = new FormData();
                formData.append('photo', blob, 'photo.jpg');
                formData.append('nisn', decodedText);
                formData.append('token', token);
                
                try {
                    const response = await fetch('/attendance/process-qr', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const result = await response.json();
                    alert(result.message);
                    location.reload();
                } catch (error) {
                    alert('Error processing attendance');
                }
            }, 'image/jpeg');
        });
    </script>
@endsection