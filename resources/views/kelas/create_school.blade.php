@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Kelas Baru</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('kelas.school.store') }}" method="POST">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="nama_kelas" class="col-md-4 col-form-label text-md-right">Nama Kelas</label>
                            <div class="col-md-6">
                                <input id="nama_kelas" type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" value="{{ old('nama_kelas') }}" required>
                                @error('nama_kelas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="tingkat" class="col-md-4 col-form-label text-md-right">Tingkat</label>
                            <div class="col-md-6">
                                <select id="tingkat" class="form-control @error('tingkat') is-invalid @enderror" name="tingkat" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="1" {{ old('tingkat') == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ old('tingkat') == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ old('tingkat') == '3' ? 'selected' : '' }}>3</option>
                                </select>
                                @error('tingkat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="jurusan" class="col-md-4 col-form-label text-md-right">Jurusan</label>
                            <div class="col-md-6">
                                <input id="jurusan" type="text" class="form-control @error('jurusan') is-invalid @enderror" name="jurusan" value="{{ old('jurusan') }}">
                                @error('jurusan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="kapasitas" class="col-md-4 col-form-label text-md-right">Kapasitas</label>
                            <div class="col-md-6">
                                <input id="kapasitas" type="number" class="form-control @error('kapasitas') is-invalid @enderror" name="kapasitas" value="{{ old('kapasitas') }}" required>
                                @error('kapasitas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="tahun_ajaran" class="col-md-4 col-form-label text-md-right">Tahun Ajaran</label>
                            <div class="col-md-6">
                                <input id="tahun_ajaran" type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" required placeholder="Contoh: 2024/2025">
                                @error('tahun_ajaran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="semester" class="col-md-4 col-form-label text-md-right">Semester</label>
                            <div class="col-md-6">
                                <select id="semester" class="form-control @error('semester') is-invalid @enderror" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="wali_kelas" class="col-md-4 col-form-label text-md-right">Wali Kelas</label>
                            <div class="col-md-6">
                                <select id="wali_kelas" class="form-control @error('wali_kelas') is-invalid @enderror" name="wali_kelas">
                                    <option value="">Pilih Wali Kelas</option>
                                    @foreach($guru as $g)
                                        <option value="{{ $g->nama }}" {{ old('wali_kelas') == $g->nama ? 'selected' : '' }}>{{ $g->nama }}</option>
                                    @endforeach
                                </select>
                                @error('wali_kelas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                                <a href="{{ route('kelas.school.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection