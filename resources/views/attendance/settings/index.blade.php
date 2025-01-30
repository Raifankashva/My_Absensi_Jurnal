@extends('attendance.layouts.app')

@section('title', 'Pengaturan Absensi')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Pengaturan Waktu Absensi</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('attendance.settings.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Jam Masuk</label>
                        <input type="time" name="jam_masuk" class="form-control" value="{{ old('jam_masuk', $settings->jam_masuk ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Batas Telat</label>
                        <input type="time" name="batas_telat" class="form-control" value="{{ old('batas_telat', $settings->batas_telat ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Jam Pulang</label>
                        <input type="time" name="jam_pulang" class="form-control" value="{{ old('jam_pulang', $settings->jam_pulang ?? '') }}" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
