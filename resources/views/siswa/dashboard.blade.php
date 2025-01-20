@extends('layouts.app')

@section('title', 'Siswa Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2>Siswa Dashboard</h2>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Profile Info
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Quick Access
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-grid">
                            <button class="btn btn-primary mb-2">Lihat Nilai</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <button class="btn btn-success mb-2">Jadwal Pelajaran</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <button class="btn btn-info mb-2">Tugas</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection