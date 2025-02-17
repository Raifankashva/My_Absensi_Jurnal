@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Isi Jurnal Pembelajaran</h5>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if(count($jadwalHariIni) > 0)
                    <form action="{{ route('jurnal-guru.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group row mb-3">
                            <label for="jadwal_pelajaran_id" class="col-md-4 col-form-label text-md-right">Jadwal Pelajaran</label>
                            <div class="col-md-8">
                                <select name="jadwal_pelajaran_id" id="jadwal_pelajaran_id" class="form-control @error('jadwal_pelajaran_id') is-invalid @enderror" required>
                                    <option value="">Pilih Jadwal</option>
                                    @foreach($jadwalHariIni as $jadwal)
                                        <option value="{{ $jadwal->id }}" {{ old('jadwal_pelajaran_id') == $jadwal->id ? 'selected' : '' }}>
                                            {{ $jadwal->mata_pelajaran }} - {{ $jadwal->kelas->nama_kelas }} 
                                            ({{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('jadwal_pelajaran_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="tanggal" class="col-md-4 col-form-label text-md-right">Tanggal</label>
                            <div class="col-md-8">
                                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="materi_yang_disampaikan" class="col-md-4 col-form-label text-md-right">Materi yang Disampaikan</label>
                            <div class="col-md-8">
                                <textarea name="materi_yang_disampaikan" id="materi_yang_disampaikan" class="form-control @error('materi_yang_disampaikan') is-invalid @enderror" rows="4" required>{{ old('materi_yang_disampaikan') }}</textarea>
                                @error('materi_yang_disampaikan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="status_pertemuan" class="col-md-4 col-form-label text-md-right">Status Pertemuan</label>
                            <div class="col-md-8">
                                <select name="status_pertemuan" id="status_pertemuan" class="form-control @error('status_pertemuan') is-invalid @enderror" required>
                                    <option value="Terlaksana" {{ old('status_pertemuan') == 'Terlaksana' ? 'selected' : '' }}>Terlaksana</option>
                                    <option value="Diganti" {{ old('status_pertemuan') == 'Diganti' ? 'selected' : '' }}>Diganti</option>
                                    <option value="Dibatalkan" {{ old('status_pertemuan') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status_pertemuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="jumlah_siswa_hadir" class="col-md-4 col-form-label text-md-right">Jumlah Siswa Hadir</label>
                            <div class="col-md-8">
                                <input type="number" name="jumlah_siswa_hadir" id="jumlah_siswa_hadir" class="form-control @error('jumlah_siswa_hadir') is-invalid @enderror" value="{{ old('jumlah_siswa_hadir') }}" min="0" required>
                                @error('jumlah_siswa_hadir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="jumlah_siswa_tidak_hadir" class="col-md-4 col-form-label text-md-right">Jumlah Siswa Tidak Hadir</label>
                            <div class="col-md-8">
                                <input type="number" name="jumlah_siswa_tidak_hadir" id="jumlah_siswa_tidak_hadir" class="form-control @error('jumlah_siswa_tidak_hadir') is-invalid @enderror" value="{{ old('jumlah_siswa_tidak_hadir') }}" min="0" required>
                                @error('jumlah_siswa_tidak_hadir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3" id="siswa-tidak-hadir-container">
                            <label for="data_siswa_tidak_hadir" class="col-md-4 col-form-label text-md-right">Data Siswa Tidak Hadir</label>
                            <div class="col-md-8" id="siswa-tidak-hadir-list">
                                <div class="siswa-input mb-2">
                                    <input type="text" name="data_siswa_tidak_hadir[]" class="form-control mb-2" placeholder="Nama siswa dan alasan tidak hadir">
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="tambah-siswa-btn">
                                    <i class="fas fa-plus"></i> Tambah Siswa
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="catatan_pembelajaran" class="col-md-4 col-form-label text-md-right">Catatan Pembelajaran</label>
                            <div class="col-md-8">
                                <textarea name="catatan_pembelajaran" id="catatan_pembelajaran" class="form-control @error('catatan_pembelajaran') is-invalid @enderror" rows="3">{{ old('catatan_pembelajaran') }}</textarea>
                                @error('catatan_pembelajaran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan Jurnal
                                </button>
                                <a href="{{ route('jurnal-guru.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">Tidak ada jadwal mengajar untuk hari ini. Silakan pilih hari lain atau hubungi admin jika ada kesalahan jadwal.</p>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('jurnal-guru.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tambahSiswaBtn = document.getElementById('tambah-siswa-btn');
        const siswaContainer = document.getElementById('siswa-tidak-hadir-list');
        
        if (tambahSiswaBtn) {
            tambahSiswaBtn.addEventListener('click', function() {
                const siswaInput = document.createElement('div');
                siswaInput.className = 'siswa-input mb-2';
                siswaInput.innerHTML = `
                    <div class="input-group">
                        <input type="text" name="data_siswa_tidak_hadir[]" class="form-control" placeholder="Nama siswa dan alasan tidak hadir">
                        <button type="button" class="btn btn-outline-danger hapus-siswa-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                siswaContainer.insertBefore(siswaInput, tambahSiswaBtn);
                
                // Add event listener to new delete button
                const deleteButton = siswaInput.querySelector('.hapus-siswa-btn');
                deleteButton.addEventListener('click', function() {
                    siswaInput.remove();
                });
            });
        }
        
        // Show/hide tidak hadir section based on input
        const jumlahTidakHadir = document.getElementById('jumlah_siswa_tidak_hadir');
        const siswaContainer = document.getElementById('siswa-tidak-hadir-container');
        
        function toggleSiswaTidakHadir() {
            if (parseInt(jumlahTidakHadir.value) > 0) {
                siswaContainer.style.display = 'flex';
            } else {
                siswaContainer.style.display = 'none';
            }
        }
        
        if (jumlahTidakHadir) {
            toggleSiswaTidakHadir(); // Initial check
            jumlahTidakHadir.addEventListener('input', toggleSiswaTidakHadir);
        }
    });
</script>

@endsection