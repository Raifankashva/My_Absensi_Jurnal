@extends('layouts.app')

@section('content')
<div class="p-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="border-b pb-4 mb-6">
                    <h1 class="text-xl font-bold flex items-center gap-2 text-gray-800">
                        <i class="fas fa-school text-blue-500"></i> Edit Data Sekolah
                    </h1>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <div class="text-red-600 font-semibold">Periksa kembali isian Anda:</div>
                        <ul class="list-disc list-inside text-red-500 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sekolah.update', $sekolah->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NPSN -->
                        <div>
                            <label for="npsn" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-id-card text-blue-500 mr-2"></i> NPSN
                            </label>
                            <input type="text" id="npsn" name="npsn" value="{{ old('npsn', $sekolah->npsn) }}" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Nomor Pokok Sekolah Nasional">
                        </div>

                        <!-- Nama Sekolah -->
                        <div>
                            <label for="nama_sekolah" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-school text-blue-500 mr-2"></i> Nama Sekolah
                            </label>
                            <input type="text" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Masukkan nama lengkap sekolah">
                        </div>

                        <!-- Jenjang -->
                        <div>
                            <label for="jenjang" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-graduation-cap text-blue-500 mr-2"></i> Jenjang
                            </label>
                            <select id="jenjang" name="jenjang" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Jenjang</option>
                                <option value="SD" {{ old('jenjang', $sekolah->jenjang) == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('jenjang', $sekolah->jenjang) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('jenjang', $sekolah->jenjang) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ old('jenjang', $sekolah->jenjang) == 'SMK' ? 'selected' : '' }}>SMK</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i> Status
                            </label>
                            <select id="status" name="status" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Status</option>
                                <option value="Negeri" {{ old('status', $sekolah->status) == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                <option value="Swasta" {{ old('status', $sekolah->status) == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                            </select>
                        </div>

                        <!-- Provinsi -->
                        <div>
                            <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i> Provinsi
                            </label>
                            <select id="provinsi" name="provinsi" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Provinsi</option>
                                <option value="{{ $sekolah->provinsi }}" selected>{{ $sekolah->provinsi }}</option>
                                <!-- Add more provinces as needed -->
                            </select>
                        </div>

                        <!-- Kota/Kabupaten -->
                        <div>
                            <label for="kota" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-city text-blue-500 mr-2"></i> Kota/Kabupaten
                            </label>
                            <select id="kota" name="kota" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Kota/Kabupaten</option>
                                <option value="{{ $sekolah->kota }}" selected>{{ $sekolah->kota }}</option>
                                <!-- Add more cities as needed -->
                            </select>
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-map text-blue-500 mr-2"></i> Kecamatan
                            </label>
                            <select id="kecamatan" name="kecamatan" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Kecamatan</option>
                                <option value="{{ $sekolah->kecamatan }}" selected>{{ $sekolah->kecamatan }}</option>
                                <!-- Add more districts as needed -->
                            </select>
                        </div>

                        <!-- Kelurahan/Desa -->
                        <div>
                            <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-home text-blue-500 mr-2"></i> Kelurahan/Desa
                            </label>
                            <select id="kelurahan" name="kelurahan" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Kelurahan/Desa</option>
                                <option value="{{ $sekolah->kelurahan }}" selected>{{ $sekolah->kelurahan }}</option>
                                <!-- Add more villages as needed -->
                            </select>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-map-marked-alt text-blue-500 mr-2"></i> Alamat
                            </label>
                            <textarea id="alamat" name="alamat" rows="3" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Alamat lengkap sekolah">{{ old('alamat', $sekolah->alamat) }}</textarea>
                        </div>

                        <!-- Kode Pos -->
                        <div>
                            <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-mailbox text-blue-500 mr-2"></i> Kode Pos
                            </label>
                            <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $sekolah->kode_pos) }}" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- No. Telepon -->
                        <div>
                            <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-phone text-blue-500 mr-2"></i> No Telepon
                            </label>
                            <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp', $sekolah->no_telp) }}" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i> Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $sekolah->email) }}" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-globe text-blue-500 mr-2"></i> Website
                            </label>
                            <input type="url" id="website" name="website" value="{{ old('website', $sekolah->website) }}" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Akreditasi -->
                        <div>
                            <label for="akreditasi" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-award text-blue-500 mr-2"></i> Akreditasi
                            </label>
                            <select id="akreditasi" name="akreditasi" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Akreditasi</option>
                                <option value="A" {{ old('akreditasi', $sekolah->akreditasi) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('akreditasi', $sekolah->akreditasi) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('akreditasi', $sekolah->akreditasi) == 'C' ? 'selected' : '' }}>C</option>
                                <option value="Belum Terakreditasi" {{ old('akreditasi', $sekolah->akreditasi) == 'Belum Terakreditasi' ? 'selected' : '' }}>Belum Terakreditasi</option>
                            </select>
                        </div>

                        <!-- Kepala Sekolah -->
                        <div>
                            <label for="kepala_sekolah" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-user-tie text-blue-500 mr-2"></i> Nama Kepala Sekolah
                            </label>
                            <input type="text" id="kepala_sekolah" name="kepala_sekolah" value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah) }}" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- NIP Kepala Sekolah -->
                        <div>
                            <label for="nip_kepala_sekolah" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-id-badge text-blue-500 mr-2"></i> NIP Kepala Sekolah
                            </label>
                            <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $sekolah->nip_kepala_sekolah) }}" 
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Foto Sekolah -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Sekolah (Opsional)</label>
                            <div class="mt-1 flex items-center">
                                <input type="file" name="foto_sekolah" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100">
                            </div>
                            @if(isset($sekolah->foto_sekolah))
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $sekolah->foto_sekolah) }}" alt="Foto Sekolah" class="h-20 w-auto mt-1 border rounded">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('sekolahs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection