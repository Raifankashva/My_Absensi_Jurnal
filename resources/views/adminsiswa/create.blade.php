@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg border border-blue-300">
        <div class="bg-blue-500 text-white rounded-t-lg p-4">
            <h4 class="text-lg font-semibold">Tambah Data Siswa Baru</h4>
        </div>
        <div class="p-6">
            <form action="{{ route('adminsiswa.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="sekolah_id" class="block text-sm font-medium text-gray-700">Sekolah</label>
                        <select name="sekolah_id" id="sekolah_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('sekolah_id') border-red-500 @enderror" required>
                            <option value="">Pilih Sekolah</option>
                            @foreach($sekolahs as $sekolah)
                                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                            @endforeach
                        </select>
                        @error('sekolah_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('kelas_id') border-red-500 @enderror" required>
                            <option value="">Pilih Kelas</option>
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
                        <input type="text" name="nisn" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nisn') border-red-500 @enderror" value="{{ old('nisn') }}" required maxlength="10">
                        @error('nisn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                        <input type="text" name="nis" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nis') border-red-500 @enderror" value="{{ old('nis') }}" required maxlength="10">
                        @error('nis')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <input type="text" name="nik" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nik') border-red-500 @enderror" value="{{ old('nik') }}" required maxlength="16">
                        @error('nik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap') border-red-500 @enderror" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="jenis_kelamin" class="block text-sm font-medium text-blue-700 mb-2">Jenis Kelamin</label>
            <select 
                name="jenis_kelamin" 
                class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @enderror" 
                required
            >
                <option value="" class="text-gray-500">Pilih Jenis Kelamin</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }} class="text-blue-800">Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }} class="text-blue-800">Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="tempat_lahir" class="block text-sm font-medium text-blue-700 mb-2">Tempat Lahir</label>
            <input 
                type="text" 
                name="tempat_lahir" 
                class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tempat_lahir') border-red-500 @enderror" 
                value="{{ old('tempat_lahir') }}" 
                required
            >
            @error('tempat_lahir')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="tanggal_lahir" class="block text-sm font-medium text-blue-700 mb-2">Tanggal Lahir</label>
            <input 
                type="date" 
                name="tanggal_lahir" 
                class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_lahir') border-red-500 @enderror" 
                value="{{ old('tanggal_lahir') }}" 
                required
            >
            @error('tanggal_lahir')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="agama" class="block text-sm font-medium text-blue-700 mb-2">Agama</label>
        <select 
            name="agama" 
            class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('agama') border-red-500 @enderror" 
            required
        >
            <option value="" class="text-gray-500">Pilih Agama</option>
            @php 
            $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
            @endphp
            @foreach($agamas as $agama)
                <option value="{{ $agama }}" class="text-blue-800">{{ $agama }}</option>
            @endforeach
        </select>
        @error('agama')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="alamat" class="block text-sm font-medium text-blue-700 mb-2">Alamat</label>
        <textarea 
            name="alamat" 
            class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror" 
            required
        >{{ old('alamat') }}</textarea>
        @error('alamat')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="rt" class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt') }}" required maxlength="3">
                        @error('rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label for="rw" class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw') }}" required maxlength="3">
                        @error('rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label for="kelurahan" class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" value="{{ old('kelurahan') }}" required>
                        @error('kelurahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" value="{{ old('kecamatan') }}" required>
                        @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror" value="{{ old('kota') }}" required>
                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" value="{{ old('provinsi') }}" required>
                        @error('provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="kode_pos" class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos') }}" required maxlength="5">
                        @error('kode_pos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jenis_tinggal" class="form-label">Jenis Tinggal</label>
                        <select name="jenis_tinggal" class="form-control @error('jenis_tinggal') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Tinggal</option>
                            <option value="Rumah Pribadi">Rumah Pribadi</option>
                            <option value="Rumah Sewa">Rumah Sewa</option>
                            <option value="Kos">Kos</option>
                            <option value="Asrama">Asrama</option>
                        </select>
                        @error('jenis_tinggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="transportasi" class="form-label">Transportasi</label>
                        <select name="transportasi" class="form-control @error('transportasi') is-invalid @enderror" required>
                            <option value="">Pilih Transportasi</option>
                            <option value="Jalan Kaki">Jalan Kaki</option>
                            <option value="Sepeda">Sepeda</option>
                            <option value="Motor">Motor</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Angkutan Umum">Angkutan Umum</option>
                        </select>
                        @error('transportasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_hp" class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required maxlength="15">
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Ayah -->
                <h5 class="mt-4">Data Ayah</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah') }}" required>
                        @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="nik_ayah" class="form-label">NIK Ayah</label>
                        <input type="text" name="nik_ayah" class="form-control @error('nik_ayah') is-invalid @enderror" value="{{ old('nik_ayah') }}" required maxlength="16">
                        @error('nik_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tahun_lahir_ayah" class="form-label">Tahun Lahir Ayah</label>
                        <input type="number" name="tahun_lahir_ayah" class="form-control @error('tahun_lahir_ayah') is-invalid @enderror" value="{{ old('tahun_lahir_ayah') }}" required>
                        @error('tahun_lahir_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah</label>
                        <select name="pendidikan_ayah" class="form-control @error('pendidikan_ayah') is-invalid @enderror" required>
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                        @error('pendidikan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" value="{{ old('pekerjaan_ayah') }}" required>
                        @error('pekerjaan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="penghasilan_ayah" class="form-label">Penghasilan Ayah</label>
                        <input type="number" name="penghasilan_ayah" class="form-control @error('penghasilan_ayah') is-invalid @enderror" value="{{ old('penghasilan_ayah') }}" required>
                        @error('penghasilan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Ibu -->
                <h5 class="mt-4">Data Ibu</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu') }}" required>
                        @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="nik_ibu" class="form-label">NIK Ibu</label>
                        <input type="text" name="nik_ibu" class="form-control @error('nik_ibu') is-invalid @enderror" value="{{ old('nik_ibu') }}" required maxlength="16">
                        @error('nik_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tahun_lahir_ibu" class="form-label">Tahun Lahir Ibu</label>
                        <input type="number" name="tahun_lahir_ibu" class="form-control @error('tahun_lahir_ibu') is-invalid @enderror" value="{{ old('tahun_lahir_ibu') }}" required>
                        @error('tahun_lahir_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu</label>
                        <select name="pendidikan_ibu" class="form-control @error('pendidikan_ibu') is-invalid @enderror" required>
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                        @error('pendidikan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" value="{{ old('pekerjaan_ibu') }}" required>
                        @error('pekerjaan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="penghasilan_ibu" class="form-label">Penghasilan Ibu</label>
                        <input type="number" name="penghasilan_ibu" class="form-control @error('penghasilan_ibu') is-invalid @enderror" value="{{ old('penghasilan_ibu') }}" required>
                        @error('penghasilan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Wali (Opsional) -->
                <h5 class="mt-4">Data Wali (Opsional)</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_wali" class="form-label">Nama Wali</label>
                        <input type="text" name="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror" value="{{ old('nama_wali') }}">
                        @error('nama_wali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="nik_wali" class="form-label">NIK Wali</label>
                        <input type="text" name="nik_wali" class="form-control @error('nik_wali') is-invalid @enderror" value="{{ old('nik_wali') }}" maxlength="16">
                        @error('nik_wali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tahun_lahir_wali" class="form-label">Tahun Lahir Wali</label>
                        <input type="number" name="tahun_lahir_wali" class="form-control @error('tahun_lahir_wali') is-invalid @enderror" value="{{ old('tahun_lahir_wali') }}">
                        @error('tahun_lahir_wali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="pendidikan_wali" class="form-label">Pendidikan Wali</label>
                        <select name="pendidikan_wali" class="form-control @error('pendidikan_wali') is-invalid @enderror">
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                        @error('pendidikan_wali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="pekerjaan_wali" class="form-label">Pekerjaan Wali</label>
                        <input type="text" name="pekerjaan_wali" class="form-control @error('pekerjaan_wali') is-invalid @enderror" value="{{ old('pekerjaan_wali') }}">
                        @error('pekerjaan_wali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="penghasilan_wali" class="form-label">Penghasilan Wali</label>
                        <input type="number" name="penghasilan_wali" class="form-control @error('penghasilan_wali') is-invalid @enderror" value="{{ old('penghasilan_wali') }}">
                        @error('penghasilan_wali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Tambahan -->
                <h5 class="mt-4">Data Tambahan</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" class="form-control @error('tinggi_badan') is-invalid @enderror" value="{{ old('tinggi_badan') }}">
                        @error('tinggi_badan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" class="form-control @error('berat_badan') is-invalid @enderror" value="{{ old('berat_badan') }}">
                        @error('berat_badan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="jarak_rumah" class="form-label">Jarak Rumah (km)</label>
                        <input type="number" name="jarak_rumah" class="form-control @error('jarak_rumah') is-invalid @enderror" value="{{ old('jarak_rumah') }}" step="0.1">
                        @error('jarak_rumah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="waktu_tempuh" class="form-label">Waktu Tempuh</label>
                        <input type="text" name="waktu_tempuh" class="form-control @error('waktu_tempuh') is-invalid @enderror" value="{{ old('waktu_tempuh') }}" placeholder="Contoh: 30 menit">
                        @error('waktu_tempuh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="jumlah_saudara_kandung" class="form-label">Jumlah Saudara Kandung</label>
                        <input type="number" name="jumlah_saudara_kandung" class="form-control @error('jumlah_saudara_kandung') is-invalid @enderror" value="{{ old('jumlah_saudara_kandung') }}">
                        @error('jumlah_saudara_kandung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Kartu -->
                <h5 class="mt-4">Data Kartu</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kks" class="form-label">No. KKS</label>
                        <input type="text" name="kks" class="form-control @error('kks') is-invalid @enderror" value="{{ old('kks') }}">
                        @error('kks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="kph" class="form-label">No. KPH</label>
                        <input type="text" name="kph" class="form-control @error('kph') is-invalid @enderror" value="{{ old('kph') }}">
                        @error('kph')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="kip" class="form-label">No. KIP</label>
                        <input type="text" name="kip" class="form-control @error('kip') is-invalid @enderror" value="{{ old('kip') }}">
                        @error('kip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Login Information -->
                <h5 class="mt-4">Informasi Login</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('adminsiswa.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function loadKelas(sekolahId) {
        if (sekolahId) {
            $.ajax({
                url: "{{ route('api.kelas.by.sekolah', '') }}/" + sekolahId,
                type: 'GET',
                success: function(data) {
                    $('#kelas_id').empty();
                    $('#kelas_id').append('<option value="">Pilih Kelas</option>');
                    $.each(data, function(key, value) {
                        $('#kelas_id').append('<option value="' + value.id + '">' + value.nama_kelas + '</option>');
                    });

                    @if(old('kelas_id'))
                        $('#kelas_id').val("{{ old('kelas_id') }}");
                    @endif
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat data kelas');
                }
            });
        } else {
            $('#kelas_id').empty();
            $('#kelas_id').append('<option value="">Pilih Kelas</option>');
        }
    }

    @if(old('sekolah_id'))
        loadKelas("{{ old('sekolah_id') }}");
    @endif

    $('#sekolah_id').change(function() {
        var sekolahId = $(this).val();
        loadKelas(sekolahId);
    });
});
</script>

@endsection