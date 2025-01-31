@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Absensi {{ $school->nama_sekolah }}</h2>
                    <p class="text-gray-600">Periode: {{ ucfirst($periode) }}</p>
                </div>

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="max-w-md mx-auto">
                    <div class="mb-6">
                        <div id="camera-container" class="relative">
                            <video id="camera" class="w-full h-64 bg-gray-100 rounded-lg border-2 border-gray-300"></video>
                            <canvas id="canvas" class="hidden"></canvas>
                        </div>
                    </div>

                    <form action="{{ route('attendance.process') }}" method="POST" id="attendance-form">
                        @csrf
                        <input type="hidden" name="face_image" id="face_image">
                        
                        <div class="flex space-x-4">
                            <button type="button" id="capture" 
                                    class="flex-1 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Ambil Foto
                            </button>
                            
                            <button type="submit" id="submit" disabled
                                    class="flex-1 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                Absen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let camera_stream = null;
    let video = null;
    let canvas = null;

    window.addEventListener('DOMContentLoaded', async function() {
        video = document.querySelector("#camera");
        canvas = document.querySelector("#canvas");
        
        try {
            camera_stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
            video.srcObject = camera_stream;
            await video.play();
        } catch (err) {
            alert('Error accessing camera: ' + err.message);
        }
    });

    document.querySelector("#capture").addEventListener('click', function() {
        if (!camera_stream) {
            alert('Camera not initialized');
            return;
        }

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        
        const image_data_url = canvas.toDataURL('image/jpeg');
        document.querySelector('#face_image').value = image_data_url;
        document.querySelector('#submit').disabled = false;
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (camera_stream) {
            camera_stream.getTracks().forEach(track => track.stop());
        }
    });
</script>

@endsection