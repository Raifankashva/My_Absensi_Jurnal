@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-300 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
        <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
            <div class="max-w-md mx-auto">
                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        <h2 class="text-3xl font-extrabold text-center text-gray-900">Attendance Check-In</h2>
                        
                        <form id="attendance-form" method="POST" action="{{ route('attendance.check-in') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="siswa_id" class="block text-sm font-medium text-gray-700">Pilih Siswa</label>
                                <select name="siswa_id" id="siswa_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                    @foreach($siswas as $siswa)
                                        <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }} - {{ $siswa->nisn }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="sekolah_id" class="block text-sm font-medium text-gray-700">Sekolah</label>
                                <select name="sekolah_id" id="sekolah_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                    @foreach($sekolahs as $sekolah)
                                        <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="attendance_token" class="block text-sm font-medium text-gray-700">Token Absensi</label>
                                <input type="text" name="attendance_token" id="attendance_token" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            </div>

                            <div class="mb-4">
                                <label for="check_in_photo" class="block text-sm font-medium text-gray-700">Foto Check-In</label>
                                <input type="file" name="check_in_photo" id="check_in_photo" accept="image/*" capture="camera" required
                                       class="mt-1 block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-full file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-50 file:text-blue-700
                                       hover:file:bg-blue-100">
                                
                                <!-- Live Camera Preview -->
                                <div id="camera-preview" class="mt-4 hidden">
                                    <video id="video" width="100%" height="auto" autoplay></video>
                                    <button type="button" id="capture-btn" class="mt-2 w-full bg-blue-500 text-white py-2 rounded-md">
                                        Ambil Foto
                                    </button>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Check-In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoElement = document.getElementById('video');
    const cameraPreview = document.getElementById('camera-preview');
    const captureButton = document.getElementById('capture-btn');
    const fileInput = document.getElementById('check_in_photo');

    // Toggle camera preview
    fileInput.addEventListener('click', function(e) {
        cameraPreview.classList.remove('hidden');
        
        // Access the device camera
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    videoElement.srcObject = stream;
                })
                .catch(function(error) {
                    console.log("Camera access denied", error);
                });
        }
    });

    // Capture photo from camera
    captureButton.addEventListener('click', function() {
        const canvas = document.createElement('canvas');
        canvas.width = videoElement.videoWidth;
        canvas.height = videoElement.videoHeight;
        canvas.getContext('2d').drawImage(videoElement, 0, 0);

        // Convert canvas to file
        canvas.toBlob(function(blob) {
            // Create a file from the blob
            const file = new File([blob], 'check_in_photo.jpg', { type: 'image/jpeg' });
            
            // Create a new FileList
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;

            // Stop video stream
            const tracks = videoElement.srcObject.getTracks();
            tracks.forEach(track => track.stop());

            // Hide camera preview
            cameraPreview.classList.add('hidden');
        }, 'image/jpeg');
    });
});
</script>

@endsection

