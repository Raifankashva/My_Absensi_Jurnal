@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header with breadcrumbs -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('school.dashboard') }}" class="text-gray-500 hover:text-indigo-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('sekolah.profile') }}" class="ml-1 text-gray-500 hover:text-indigo-600">Profil Sekolah</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 font-medium text-gray-700">Edit Profil</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header with title and back button -->
        <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-indigo-50 to-white border-b">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">Edit Profil Sekolah</h1>
            <a href="{{ route('sekolah.profile') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form Content -->
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
                            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('sekolah.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Basic Information Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- School Photo -->
                    <div class="lg:col-span-1">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="text-center">
                                <div class="mb-4 relative mx-auto w-40 h-40 rounded-lg overflow-hidden bg-gray-100 border-2 border-gray-200">
                                    @if ($sekolah->foto)
                                        <img src="{{ asset('storage/' . $sekolah->foto) }}" 
                                            alt="Foto Sekolah" class="w-full h-full object-cover" id="preview-foto">
                                    @else
                                        <img src="{{ asset('images/school-default.png') }}" 
                                            alt="Default School" class="w-full h-full object-cover" id="preview-foto">
                                    @endif
                                </div>
                                
                                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Foto Sekolah</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-300 transition-colors duration-150">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload foto</span>
                                                <input id="foto" name="foto" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, JPEG hingga 2MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- School Basic Info -->
                    <div class="lg:col-span-2">
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Informasi Dasar</h2>
                            
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="nama_sekolah" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                                    <div class="mt-1">
                                        <input type="text" id="nama_sekolah" name="nama_sekolah" 
                                            value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" required
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="npsn" class="block text-sm font-medium text-gray-700">NPSN</label>
                                    <div class="mt-1">
                                        <input type="text" id="npsn" name="npsn" 
                                            value="{{ old('npsn', $sekolah->npsn) }}" required maxlength="8"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Nomor Pokok Sekolah Nasional (8 digit)</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="akreditasi" class="block text-sm font-medium text-gray-700">Akreditasi</label>
                                    <div class="mt-1">
                                        <select id="akreditasi" name="akreditasi" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Belum Terakreditasi</option>
                                            <option value="A" {{ old('akreditasi', $sekolah->akreditasi) == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('akreditasi', $sekolah->akreditasi) == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="C" {{ old('akreditasi', $sekolah->akreditasi) == 'C' ? 'selected' : '' }}>C</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jenjang" class="block text-sm font-medium text-gray-700">Jenjang</label>
                                    <div class="mt-1">
                                        <select id="jenjang" name="jenjang" required
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="SD" {{ old('jenjang', $sekolah->jenjang) == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('jenjang', $sekolah->jenjang) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ old('jenjang', $sekolah->jenjang) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                            <option value="SMK" {{ old('jenjang', $sekolah->jenjang) == 'SMK' ? 'selected' : '' }}>SMK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-1">
                                        <select id="status" name="status" required
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="Negeri" {{ old('status', $sekolah->status) == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                            <option value="Swasta" {{ old('status', $sekolah->status) == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Informasi Kontak
                    </h2>
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" 
                                    value="{{ old('email', $sekolah->email) }}" required
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="no_telp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <input type="text" id="no_telp" name="no_telp" 
                                    value="{{ old('no_telp', $sekolah->no_telp) }}" required
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                                <input type="url" id="website" name="website" 
                                    value="{{ old('website', $sekolah->website) }}"
                                    placeholder="https://www.example.com"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Contoh: https://www.namasekolah.sch.id</p>
                        </div>
                    </div>
                </div>

                <!-- Principal Information Section -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Kepala Sekolah
                    </h2>
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="kepala_sekolah" class="block text-sm font-medium text-gray-700">Nama Kepala Sekolah</label>
                            <div class="mt-1">
                                <input type="text" id="kepala_sekolah" name="kepala_sekolah" 
                                    value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah) }}" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="nip_kepala_sekolah" class="block text-sm font-medium text-gray-700">NIP Kepala Sekolah</label>
                            <div class="mt-1">
                                <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" 
                                    value="{{ old('nip_kepala_sekolah', $sekolah->nip_kepala_sekolah) }}" maxlength="18"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Opsional, maksimal 18 digit</p>
                        </div>
                    </div>
                </div>

                <!-- Address Information Section -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Alamat Sekolah
                    </h2>
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <div class="mt-1">
                                <textarea id="alamat" name="alamat" rows="3" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('alamat', $sekolah->alamat) }}</textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Masukkan alamat lengkap tanpa kecamatan, kabupaten/kota, dan provinsi</p>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <div class="mt-1">
                                <select id="province_id" name="province_id" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" 
                                            {{ old('province_id', $sekolah->province_id) == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="city_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                            <div class="mt-1">
                                <select id="city_id" name="city_id" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" 
                                            {{ old('city_id', $sekolah->city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="district_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                            <div class="mt-1">
                                <select id="district_id" name="district_id" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" 
                                            {{ old('district_id', $sekolah->district_id) == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="village_id" class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                            <div class="mt-1">
                                <select id="village_id" name="village_id" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Pilih Desa/Kelurahan</option>
                                    @foreach($villages as $village)
                                        <option value="{{ $village->id }}" 
                                            {{ old('village_id', $sekolah->village_id) == $village->id ? 'selected' : '' }}>
                                            {{ $village->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                            <div class="mt-1">
                                <input type="text" id="kode_pos" name="kode_pos" 
                                    value="{{ old('kode_pos', $sekolah->kode_pos) }}" required maxlength="5"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">5 digit kode pos</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Tambahan
                    </h2>
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="tahun_berdiri" class="block text-sm font-medium text-gray-700">Tahun Berdiri</label>
                            <div class="mt-1">
                                <input type="number" id="tahun_berdiri" name="tahun_berdiri" 
                                    value="{{ old('tahun_berdiri', $sekolah->tahun_berdiri ?? '') }}" min="1900" max="{{ date('Y') }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="is_active" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                            <div class="mt-1">
                                <select id="is_active" name="is_active" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="1" {{ old('is_active', $sekolah->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $sekolah->is_active) == 0 ? 'selected' : '' }}>Belum Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('sekolah.profile') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Alpine.js for interactive components -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

<!-- Image preview script -->
<script>
    document.getElementById('foto').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('preview-foto').src = event.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    // Drag and drop functionality for image upload
    const dropArea = document.querySelector('label[for="foto"]').closest('div');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropArea.classList.add('border-indigo-300', 'bg-indigo-50');
    }
    
    function unhighlight() {
        dropArea.classList.remove('border-indigo-300', 'bg-indigo-50');
    }
    
    dropArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        document.getElementById('foto').files = files;
        
        if (files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview-foto').src = event.target.result;
            }
            reader.readAsDataURL(files[0]);
        }
    }

    // Cascading dropdown for regions
    $(document).ready(function() {
        // When province changes
        $('#province_id').change(function() {
            var provinceId = $(this).val();
            if(provinceId) {
                $.ajax({
                    url: '{{ route("sekolah.getCities") }}',
                    type: 'GET',
                    data: { province_id: provinceId },
                    success: function(data) {
                        $('#city_id').empty();
                        $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>');
                        $.each(data, function(key, value) {
                            $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        // Reset dependent dropdowns
                        $('#district_id').empty();
                        $('#district_id').append('<option value="">Pilih Kecamatan</option>');
                        $('#village_id').empty();
                        $('#village_id').append('<option value="">Pilih Desa/Kelurahan</option>');
                    }
                });
            } else {
                $('#city_id').empty();
                $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>');
                $('#district_id').empty();
                $('#district_id').append('<option value="">Pilih Kecamatan</option>');
                $('#village_id').empty();
                $('#village_id').append('<option value="">Pilih Desa/Kelurahan</option>');
            }
        });
        
        // When city changes
        $('#city_id').change(function() {
            var cityId = $(this).val();
            if(cityId) {
                $.ajax({
                    url: '{{ route("sekolah.getDistricts") }}',
                    type: 'GET',
                    data: { city_id: cityId },
                    success: function(data) {
                        $('#district_id').empty();
                        $('#district_id').append('<option value="">Pilih Kecamatan</option>');
                        $.each(data, function(key, value) {
                            $('#district_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        // Reset dependent dropdown
                        $('#village_id').empty();
                        $('#village_id').append('<option value="">Pilih Desa/Kelurahan</option>');
                    }
                });
            } else {
                $('#district_id').empty();
                $('#district_id').append('<option value="">Pilih Kecamatan</option>');
                $('#village_id').empty();
                $('#village_id').append('<option value="">Pilih Desa/Kelurahan</option>');
            }
        });
        
        // When district changes
        $('#district_id').change(function() {
            var districtId = $(this).val();
            if(districtId) {
                $.ajax({
                    url: '{{ route("sekolah.getVillages") }}',
                    type: 'GET',
                    data: { district_id: districtId },
                    success: function(data) {
                        $('#village_id').empty();
                        $('#village_id').append('<option value="">Pilih Desa/Kelurahan</option>');
                        $.each(data, function(key, value) {
                            $('#village_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#village_id').empty();
                $('#village_id').append('<option value="">Pilih Desa/Kelurahan</option>');
            }
        });
    });
</script>
@endsection
