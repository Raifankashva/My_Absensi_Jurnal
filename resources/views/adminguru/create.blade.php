@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Tambah Guru Baru</h1>
                    
                    <a href="{{ route('adminguru.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-200">
                        Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('adminguru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Hidden field for school info -->
                    <div class="bg-blue-50 p-4 rounded mb-4">
                        <p class="text-blue-700">Data guru akan ditambahkan ke sekolah: <strong>{{ $sekolah->nama_sekolah }}</strong></p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Dasar -->
                        <div class="space-y-4">
                            <div>
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            </div>
                            
                            <div>
                                <label for="nip" class="block text-sm font-medium text-gray-700">NIP (18 Digit)</label>
                                <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" maxlength="18">
                            </div>
                            
                            <div>
                                <label for="nuptk" class="block text-sm font-medium text-gray-700">NUPTK (16 Digit)</label>
                                <input type="text" name="nuptk" id="nuptk" value="{{ old('nuptk') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" maxlength="16">
                            </div>
                            
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK (16 Digit)</label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" maxlength="16" required>
                            </div>
                            
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            </div>
                            
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            </div>
                        </div>
                        
                        <!-- Informasi Profesional & Kontak -->
                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            </div>
                            
                            <div>
                                <label for="status_kepegawaian" class="block text-sm font-medium text-gray-700">Status Kepegawaian</label>
                                <select name="status_kepegawaian" id="status_kepegawaian" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="">Pilih Status</option>
                                    <option value="PNS" {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="PPPK" {{ old('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                    <option value="Honorer" {{ old('status_kepegawaian') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                                    <option value="GTY" {{ old('status_kepegawaian') == 'GTY' ? 'selected' : '' }}>GTY</option>
                                    <option value="GTT" {{ old('status_kepegawaian') == 'GTT' ? 'selected' : '' }}>GTT</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="SMA/SMK" {{ old('pendidikan_terakhir') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                    <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="jurusan_pendidikan" class="block text-sm font-medium text-gray-700">Jurusan Pendidikan</label>
                                <input type="text" name="jurusan_pendidikan" id="jurusan_pendidikan" value="{{ old('jurusan_pendidikan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            </div>
                            
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>{{ old('alamat') }}</textarea>
                            </div>
                            
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mata Pelajaran & TMT -->
                    <div class="space-y-4">
                        <div>
                            <label for="tmt_kerja" class="block text-sm font-medium text-gray-700">TMT Kerja</label>
                            <input type="date" name="tmt_kerja" id="tmt_kerja" value="{{ old('tmt_kerja') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                            <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-3">
                                @php
                                    $mataPelajaran = [
                                        'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 
                                        'PKn', 'Agama', 'PJOK', 'Seni Budaya', 'Prakarya', 
                                        'TIK', 'Bahasa Daerah', 'Fisika', 'Kimia', 'Biologi', 
                                        'Ekonomi', 'Sosiologi', 'Sejarah', 'Geografi'
                                    ];
                                    $oldMataPelajaran = old('mata_pelajaran', []);
                                @endphp
                                
                                @foreach($mataPelajaran as $mapel)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="mata_pelajaran[]" id="mapel_{{ $loop->index }}" value="{{ $mapel }}" 
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                            {{ in_array($mapel, $oldMataPelajaran) ? 'checked' : '' }}>
                                        <label for="mapel_{{ $loop->index }}" class="ml-2 block text-sm text-gray-700">
                                            {{ $mapel }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                            <input type="file" name="foto" id="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/jpeg,image/png,image/jpg">
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-5">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-200">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection