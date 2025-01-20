@extends('layouts.app')

@section('title', 'Guru Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2>Guru Dashboard</h2>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Total Siswa</h5>
                <p class="card-text display-4">{{ $totalSiswa }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                Quick Actions
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-grid">
                            <button class="btn btn-primary mb-2">Input Nilai</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <button class="btn btn-success mb-2">Absensi</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <button class="btn btn-info mb-2">Jadwal Mengajar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
