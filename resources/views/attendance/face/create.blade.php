@extends('attendance.layouts.app')

@section('title', 'Daftar Wajah Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Wajah - {{ $student->nama_lengkap }}</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <video id="video" width="640" height="480" class="border" autoplay></video>
                    <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>
                </div>
                
                <form action="{{ route('face.store', $student) }}" method="POST" id="faceForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="foto_wajah" id="foto_wajah">
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" id="capture">Ambil Foto</button>
                        <button type="submit" class="btn btn-success mt-2" id="submit" style="display: none;">Simpan Data Wajah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let captureButton = document.getElementById('capture');
let submitButton = document.getElementById('submit');
let context = canvas.getContext('2d');

navigator.mediaDevices.getUserMedia({ video: true })
    .then(function(stream) {
        video.srcObject = stream;
    })
    .catch(function(err) {
        console.log("Error: " + err);
    });

captureButton.addEventListener('click', function() {
    context.drawImage(video, 0, 0, 640, 480);
    let image = canvas.toDataURL('image/jpeg');
    document.getElementById('foto_wajah').value = image;
    submitButton.style.display = 'block';
    captureButton.textContent = 'Ambil Ulang';
});
</script>
@endsection