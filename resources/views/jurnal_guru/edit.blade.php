@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Jurnal Pembelajaran</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('jurnal-guru.update', $jurnal->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group row mb-3">
                            <label for="jadwal_pelajaran_id" class="col-md-4 col-form-label text-md-right">Jadwal Pelajaran</label>
                            <div class="col-md-8">
                                <select name="jadwal_pelajaran_id" id="jadwal_pelajaran_id" class="form-control @error('jadwal_pelajaran_id') is-invalid @enderror" required>
                                    <option value="">Pilih Jadwal</option>
                                    @foreach($jadwalPelajaran as $jadwal)
                                        <option value="{{ $jadwal->id }}" {{ (old('jadwal_pelajaran_id', $jurnal->jadwal_pelajaran_id) == $jadwal->id) ? 