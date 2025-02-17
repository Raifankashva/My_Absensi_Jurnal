@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Jadwal Pelajaran Baru</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('jadwal-pelajaran.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group row mb-3">
                            <label for="kelas_id" class="col-md-4 col-form-label text-md-right">Kelas</label>
                            <div class="col-md-6">
                                <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }} ({{ $k->tingkat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="guru_id" class="col-md-4 col-form-label text-md-right">Guru</label>
                            <div class="col-md-6">
                                <select name="guru_id" id="guru_id" class="form-control @error('guru_id') is-invalid @enderror" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="mata_pelajaran" class="col-md-4 col-form-label text-md-right">Mata Pelajaran</label>
                            <div class="col-md-6">
                                <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control @error('mata_pelajaran') is-invalid @enderror" value="{{ old('mata_pelajaran') }}" required>
                                @error('mata_pelajaran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="hari" class="col-md-4 col-form-label text-md-right">Hari</label>
                            <div class="col-md-6">
                                <select name="hari" id="hari" class="form-control @error('hari') is-invalid @enderror" required>
                                    <option value="">Pilih Hari</option>
                                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                        <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                                            {{ $hari }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('hari')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="jam_mulai" class="col-md-4 col-form-label text-md-right">Jam Mulai</label>
                            <div class="col-md-6">
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai') }}" required>
                                @error('jam_mulai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="jam_selesai" class="col-md-4 col-form-label text-md-right">Jam Selesai</label>
                            <div class="col-md-6">
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai') }}" required>
                                @error('jam_selesai')
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
                                <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-secondary">
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