@extends('layouts.app')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.8.0/dist/geosearch.css" />
<style>
    /* Custom Leaflet Controls Styling */
    .leaflet-control-zoom {
        border: none !important;
        box-shadow: 0 1px 5px rgba(0,0,0,0.2) !important;
    }
    .leaflet-control-zoom a {
        background-color: white !important;
        color: #4b5563 !important;
        transition: all 0.2s ease;
    }
    .leaflet-control-zoom a:hover {
        background-color: #f3f4f6 !important;
        color: #1f2937 !important;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }
    .leaflet-popup-content {
        margin: 0.75rem 1rem !important;
    }
    .leaflet-container a.leaflet-popup-close-button {
        color: #6b7280 !important;
        transition: color 0.2s ease;
    }
    .leaflet-container a.leaflet-popup-close-button:hover {
        color: #1f2937 !important;
    }
    
    /* Custom marker pulse animation */
    .map-marker-pulse {
        animation: map-marker-pulse 1.5s ease-out infinite;
    }
    @keyframes map-marker-pulse {
        0% {
            opacity: 1;
            transform: scale(1);
        }
        100% {
            opacity: 0;
            transform: scale(1.6);
        }
    }
    
    /* Search results styling */
    .leaflet-geosearch-bar {
        z-index: 1000 !important;
    }
    .leaflet-control-geosearch form {
        border-radius: 0.375rem !important;
        overflow: hidden !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;
    }
    .leaflet-control-geosearch form input {
        border-radius: 0.375rem !important;
        border: 1px solid #d1d5db !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem !important;
    }
    .leaflet-control-geosearch form input:focus {
        outline: none !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2) !important;
    }
</style>
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

                <!-- Location Map Section -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lokasi Sekolah
                    </h2>
                    
                    <div class="space-y-4" x-data="locationPicker()">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Klik pada peta untuk menentukan lokasi sekolah atau masukkan koordinat secara manual.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Interactive Map -->
                        <div class="h-96 w-full rounded-lg shadow-md overflow-hidden border border-gray-200" id="location-map"></div>
                        
                        <!-- Search Location -->
                        <div class="flex flex-col md:flex-row gap-4 mt-4">
                            <div class="flex-grow">
                                <div class="relative">
                                    <input type="text" id="search-location" placeholder="Cari lokasi..." 
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="search-button" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cari
                            </button>
                            <button type="button" id="current-location" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                Lokasi Saya
                            </button>
                        </div>
                        
                        <!-- Coordinates Input -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" id="latitude" name="latitude" x-model="latitude" required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" id="longitude" name="longitude" x-model="longitude" required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Preview -->
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200" x-show="hasLocation">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Alamat dari Koordinat:</h3>
                            <p class="text-sm text-gray-600" id="reverse-geocode-result">Memuat alamat...</p>
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
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Leaflet GeoSearch -->
<script src="https://unpkg.com/leaflet-geosearch@3.8.0/dist/geosearch.umd.js"></script>

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
    
    // Location Picker with Alpine.js
    function locationPicker() {
        return {
            latitude: "{{ old('latitude', $sekolah->latitude ?? '-6.2088') }}",
            longitude: "{{ old('longitude', $sekolah->longitude ?? '106.8456') }}",
            map: null,
            marker: null,
            searchControl: null,
            hasLocation: {{ !empty($sekolah->latitude) && !empty($sekolah->longitude) ? 'true' : 'false' }},
            
            init() {
                // Initialize map
                this.initMap();
                
                // Watch for manual coordinate changes
                this.$watch('latitude', value => {
                    if (value && this.longitude && this.marker) {
                        const newLatLng = [parseFloat(value), parseFloat(this.longitude)];
                        this.marker.setLatLng(newLatLng);
                        this.map.setView(newLatLng, 16);
                        this.reverseGeocode(newLatLng[0], newLatLng[1]);
                    }
                });
                
                this.$watch('longitude', value => {
                    if (value && this.latitude && this.marker) {
                        const newLatLng = [parseFloat(this.latitude), parseFloat(value)];
                        this.marker.setLatLng(newLatLng);
                        this.map.setView(newLatLng, 16);
                        this.reverseGeocode(newLatLng[0], newLatLng[1]);
                    }
                });
                
                // Set up search functionality
                document.getElementById('search-button').addEventListener('click', () => {
                    const searchText = document.getElementById('search-location').value;
                    if (searchText) {
                        this.searchLocation(searchText);
                    }
                });
                
                // Search on Enter key
                document.getElementById('search-location').addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const searchText = document.getElementById('search-location').value;
                        if (searchText) {
                            this.searchLocation(searchText);
                        }
                    }
                });
                
                // Current location button
                document.getElementById('current-location').addEventListener('click', () => {
                    this.getCurrentLocation();
                });
            },
            
            initMap() {
                // Create map
                this.map = L.map('location-map').setView(
                    [parseFloat(this.latitude), parseFloat(this.longitude)], 
                    16
                );
                
                // Add tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(this.map);
                
                // Create custom icon
                const schoolIcon = L.divIcon({
                    html: `<div class="relative">
                            <div class="absolute w-6 h-6 bg-indigo-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <div class="w-24 h-24 rounded-full bg-indigo-500 opacity-20 map-marker-pulse absolute -top-9 -left-9"></div>
                          </div>`,
                    className: '',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
                
                // Add marker if coordinates exist
                if (this.latitude && this.longitude) {
                    this.marker = L.marker(
                        [parseFloat(this.latitude), parseFloat(this.longitude)], 
                        { icon: schoolIcon, draggable: true }
                    ).addTo(this.map);
                    
                    // Update coordinates when marker is dragged
                    this.marker.on('dragend', (event) => {
                        const marker = event.target;
                        const position = marker.getLatLng();
                        this.latitude = position.lat.toFixed(6);
                        this.longitude = position.lng.toFixed(6);
                        this.hasLocation = true;
                        this.reverseGeocode(position.lat, position.lng);
                    });
                    
                    // Initial reverse geocoding
                    this.reverseGeocode(parseFloat(this.latitude), parseFloat(this.longitude));
                }
                
                // Click on map to set marker
                this.map.on('click', (e) => {
                    const { lat, lng } = e.latlng;
                    
                    // Update or create marker
                    if (this.marker) {
                        this.marker.setLatLng([lat, lng]);
                    } else {
                        this.marker = L.marker([lat, lng], { 
                            icon: schoolIcon, 
                            draggable: true 
                        }).addTo(this.map);
                        
                        // Update coordinates when marker is dragged
                        this.marker.on('dragend', (event) => {
                            const marker = event.target;
                            const position = marker.getLatLng();
                            this.latitude = position.lat.toFixed(6);
                            this.longitude = position.lng.toFixed(6);
                            this.hasLocation = true;
                            this.reverseGeocode(position.lat, position.lng);
                        });
                    }
                    
                    // Update form values
                    this.latitude = lat.toFixed(6);
                    this.longitude = lng.toFixed(6);
                    this.hasLocation = true;
                    
                    // Get address from coordinates
                    this.reverseGeocode(lat, lng);
                });
                
                // Add GeoSearch control
                const provider = new GeoSearch.OpenStreetMapProvider();
                
                const searchControl = new GeoSearch.GeoSearchControl({
                    provider: provider,
                    style: 'bar',
                    showMarker: false,
                    showPopup: false,
                    autoClose: true,
                    retainZoomLevel: false,
                    animateZoom: true,
                    keepResult: true,
                    searchLabel: 'Cari lokasi...'
                });
                
                this.map.addControl(searchControl);
                
                // Handle search result selection
                this.map.on('geosearch/showlocation', (e) => {
                    const { location } = e;
                    
                    // Update or create marker
                    if (this.marker) {
                        this.marker.setLatLng([location.y, location.x]);
                    } else {
                        this.marker = L.marker([location.y, location.x], { 
                            icon: schoolIcon, 
                            draggable: true 
                        }).addTo(this.map);
                        
                        // Update coordinates when marker is dragged
                        this.marker.on('dragend', (event) => {
                            const marker = event.target;
                            const position = marker.getLatLng();
                            this.latitude = position.lat.toFixed(6);
                            this.longitude = position.lng.toFixed(6);
                            this.hasLocation = true;
                            this.reverseGeocode(position.lat, position.lng);
                        });
                    }
                    
                    // Update form values
                    this.latitude = location.y.toFixed(6);
                    this.longitude = location.x.toFixed(6);
                    this.hasLocation = true;
                    
                    // Get address from coordinates
                    this.reverseGeocode(location.y, location.x);
                });
            },
            
            searchLocation(query) {
                const provider = new GeoSearch.OpenStreetMapProvider();
                
                provider.search({ query: query }).then(results => {
                    if (results.length > 0) {
                        const result = results[0];
                        
                        // Update map view
                        this.map.setView([result.y, result.x], 16);
                        
                        // Update or create marker
                        if (this.marker) {
                            this.marker.setLatLng([result.y, result.x]);
                        } else {
                            const schoolIcon = L.divIcon({
                                html: `<div class="relative">
                                        <div class="absolute w-6 h-6 bg-indigo-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                        </div>
                                        <div class="w-24 h-24 rounded-full bg-indigo-500 opacity-20 map-marker-pulse absolute -top-9 -left-9"></div>
                                      </div>`,
                                className: '',
                                iconSize: [24, 24],
                                iconAnchor: [12, 12]
                            });
                            
                            this.marker = L.marker([result.y, result.x], { 
                                icon: schoolIcon, 
                                draggable: true 
                            }).addTo(this.map);
                            
                            // Update coordinates when marker is dragged
                            this.marker.on('dragend', (event) => {
                                const marker = event.target;
                                const position = marker.getLatLng();
                                this.latitude = position.lat.toFixed(6);
                                this.longitude = position.lng.toFixed(6);
                                this.hasLocation = true;
                                this.reverseGeocode(position.lat, position.lng);
                            });
                        }
                        
                        // Update form values
                        this.latitude = result.y.toFixed(6);
                        this.longitude = result.x.toFixed(6);
                        this.hasLocation = true;
                        
                        // Get address from coordinates
                        this.reverseGeocode(result.y, result.x);
                    }
                });
            },
            
            getCurrentLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            
                            // Update map view
                            this.map.setView([lat, lng], 16);
                            
                            // Update or create marker
                            if (this.marker) {
                                this.marker.setLatLng([lat, lng]);
                            } else {
                                const schoolIcon = L.divIcon({
                                    html: `<div class="relative">
                                            <div class="absolute w-6 h-6 bg-indigo-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                </svg>
                                            </div>
                                            <div class="w-24 h-24 rounded-full bg-indigo-500 opacity-20 map-marker-pulse absolute -top-9 -left-9"></div>
                                          </div>`,
                                    className: '',
                                    iconSize: [24, 24],
                                    iconAnchor: [12, 12]
                                });
                                
                                this.marker = L.marker([lat, lng], { 
                                    icon: schoolIcon, 
                                    draggable: true 
                                }).addTo(this.map);
                                
                                // Update coordinates when marker is dragged
                                this.marker.on('dragend', (event) => {
                                    const marker = event.target;
                                    const position = marker.getLatLng();
                                    this.latitude = position.lat.toFixed(6);
                                    this.longitude = position.lng.toFixed(6);
                                    this.hasLocation = true;
                                    this.reverseGeocode(position.lat, position.lng);
                                });
                            }
                            
                            // Update form values
                            this.latitude = lat.toFixed(6);
                            this.longitude = lng.toFixed(6);
                            this.hasLocation = true;
                            
                            // Get address from coordinates
                            this.reverseGeocode(lat, lng);
                        },
                        (error) => {
                            console.error("Error getting current location:", error);
                            alert("Tidak dapat mengakses lokasi Anda. Pastikan Anda telah memberikan izin lokasi.");
                        }
                    );
                } else {
                    alert("Geolocation tidak didukung oleh browser Anda.");
                }
            },
            
            reverseGeocode(lat, lng) {
                // Use Nominatim for reverse geocoding
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('reverse-geocode-result').textContent = data.display_name;
                        } else {
                            document.getElementById('reverse-geocode-result').textContent = "Alamat tidak ditemukan";
                        }
                    })
                    .catch(error => {
                        console.error("Error in reverse geocoding:", error);
                        document.getElementById('reverse-geocode-result').textContent = "Gagal mendapatkan alamat";
                    });
            }
        };
    }
</script>

@endsection