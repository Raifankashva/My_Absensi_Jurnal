@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Custom Leaflet Controls Styling */
    .leaflet-control-zoom {
        border: none !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }
    .leaflet-control-zoom a {
        background-color: white !important;
        color: #4b5563 !important;
        transition: all 0.3s ease;
    }
    .leaflet-control-zoom a:hover {
        background-color: #f3f4f6 !important;
        color: #1f2937 !important;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 1rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    .leaflet-popup-content {
        margin: 1rem 1.25rem !important;
    }
    .leaflet-container a.leaflet-popup-close-button {
        color: #6b7280 !important;
        transition: color 0.2s ease;
        top: 12px !important;
        right: 12px !important;
    }
    .leaflet-container a.leaflet-popup-close-button:hover {
        color: #1f2937 !important;
    }
    
    /* Animation for stats */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    /* Pulse animation for map marker */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(59, 130, 246, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
        }
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
</style>

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header with breadcrumbs -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                    <li class="inline-flex items-center">
                        <a href="{{ route('school.dashboard') }}" class="text-gray-500 hover:text-indigo-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 font-medium text-indigo-700">Profil Sekolah</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Notification -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm transition-all duration-500 ease-in-out" 
                 x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button @click="show = false" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors duration-200">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
            <!-- Header with title and edit button -->
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 opacity-90"></div>
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')] bg-cover bg-center mix-blend-overlay opacity-20"></div>
                <div class="relative flex justify-between items-center px-6 py-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Profil Sekolah</h1>
                    <a href="{{ route('sekolah.edit') }}" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm border border-white border-opacity-20 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30 active:bg-opacity-40 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-40 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>

            <!-- School Info -->
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- School Image -->
                    <div class="w-full md:w-1/3 lg:w-1/4">
                        <div class="bg-gray-50 rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group">
                            @if ($sekolah->foto)
                                <img src="{{ asset('storage/' . $sekolah->foto) }}" 
                                    alt="Foto {{ $sekolah->nama_sekolah }}" 
                                    class="w-full h-auto object-cover aspect-square group-hover:scale-105 transition-transform duration-500">
                            @else
                                <img src="{{ asset('images/school-default.png') }}" 
                                    alt="Default School" 
                                    class="w-full h-auto object-cover aspect-square group-hover:scale-105 transition-transform duration-500">
                            @endif
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="mt-4 flex justify-center">
                            @if ($sekolah->is_active)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-green-500 mr-2 pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                                    Belum Aktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- School Details -->
                    <div class="w-full md:w-2/3 lg:w-3/4">
                        <div class="flex flex-col h-full">
                            <div class="mb-6">
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ $sekolah->nama_sekolah }}</h2>
                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                    <span class="px-3 py-1.5 bg-indigo-100 text-indigo-800 rounded-lg text-sm font-medium border border-indigo-200 shadow-sm">
                                        NPSN: {{ $sekolah->npsn }}
                                    </span>
                                    @if ($sekolah->akreditasi)
                                        <span class="px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-medium border border-yellow-200 shadow-sm">
                                            Akreditasi {{ $sekolah->akreditasi }}
                                        </span>
                                    @endif
                                    <span class="px-3 py-1.5 bg-blue-100 text-blue-800 rounded-lg text-sm font-medium border border-blue-200 shadow-sm">
                                        {{ $sekolah->jenjang }}
                                    </span>
                                    <span class="px-3 py-1.5 bg-green-100 text-green-800 rounded-lg text-sm font-medium border border-green-200 shadow-sm">
                                        {{ $sekolah->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                                <div class="space-y-4">
                                    <div class="flex items-start p-4 bg-gray-50 rounded-xl border border-gray-100 shadow-sm transition-all duration-200 hover:shadow-md hover:bg-white">
                                        <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Kepala Sekolah</p>
                                            <p class="text-base font-semibold text-indigo-700">{{ $sekolah->kepala_sekolah }}</p>
                                            @if ($sekolah->nip_kepala_sekolah)
                                                <p class="text-xs text-gray-500 mt-1">NIP: {{ $sekolah->nip_kepala_sekolah }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-start p-4 bg-gray-50 rounded-xl border border-gray-100 shadow-sm transition-all duration-200 hover:shadow-md hover:bg-white">
                                        <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Telepon</p>
                                            <p class="text-base font-semibold text-indigo-700">{{ $sekolah->no_telp }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-start p-4 bg-gray-50 rounded-xl border border-gray-100 shadow-sm transition-all duration-200 hover:shadow-md hover:bg-white">
                                        <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Email</p>
                                            <p class="text-base font-semibold text-indigo-700">{{ $sekolah->email }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start p-4 bg-gray-50 rounded-xl border border-gray-100 shadow-sm transition-all duration-200 hover:shadow-md hover:bg-white">
                                        <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Website</p>
                                            @if ($sekolah->website)
                                                <a href="{{ $sekolah->website }}" target="_blank" class="text-base font-semibold text-indigo-700 hover:text-indigo-800 hover:underline transition-colors duration-200">
                                                    {{ $sekolah->website }}
                                                </a>
                                            @else
                                                <p class="text-base text-gray-500">-</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="mt-10">
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 border-b">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Alamat Sekolah
                            </h3>
                        </div>
                        <div class="p-6">
 
            <!-- Address Information -->
            <div class="mt-8">
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Alamat Sekolah
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-700 mb-2">{{ $sekolah->alamat }}</p>
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div>
                                            <p class="text-gray-500">Desa/Kelurahan:</p>
                                            <p class="font-medium">{{ $village->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Kecamatan:</p>
                                            <p class="font-medium">{{ $district->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Kabupaten/Kota:</p>
                                            <p class="font-medium">{{ $city->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Provinsi:</p>
                                            <p class="font-medium">{{ $province->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Kode Pos:</p>
                                            <p class="font-medium">{{ $sekolah->kode_pos }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3">
        <h5 class="text-white font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Lokasi Sekolah
        </h5>
    </div>
    <div class="p-4">
        @if($hasCoordinates)
            <div id="school-map" class="h-80 w-full rounded-lg shadow-inner border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg"></div>
            
            <div class="mt-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <p class="text-sm font-semibold text-gray-700">Koordinat:</p>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <div class="flex items-center space-x-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm"><span class="font-medium">Latitude:</span> {{ $sekolah->latitude }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm"><span class="font-medium">Longitude:</span> {{ $sekolah->longitude }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-semibold text-gray-700">Alamat:</p>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-sm text-gray-700">
                                    {{ $sekolah->alamat }}, 
                                    {{ $village->name }}, 
                                    {{ $district->name }}, 
                                    {{ $city->name }}, 
                                    {{ $province->name }}, 
                                    {{ $sekolah->kode_pos }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2 mt-4">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $sekolah->latitude }},{{ $sekolah->longitude }}" 
                       target="_blank" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-blue-500 rounded-lg text-sm font-medium text-blue-600 hover:bg-blue-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Buka di Google Maps
                    </a>
                    
                    @if(Auth::user()->role === 'sekolah')
                        <a href="{{ route('sekolah.edit') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Perbarui Lokasi
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Belum ada data lokasi yang tersimpan untuk sekolah ini.
                        </p>
                        @if(Auth::user()->role === 'sekolah')
                            <div class="mt-3">
                                <a href="{{ route('sekolah.edit') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Tambahkan Lokasi Sekolah
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
                        </div>
                    </div>
                </div>
            </div>

 <!-- Additional Information -->
 <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Statistics Card -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 border-b">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Statistik
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gradient-to-br from-indigo-50 to-white p-4 rounded-xl text-center border border-indigo-100 shadow-sm transform transition-all duration-300 hover:shadow-md hover:-translate-y-1" x-data="{show: false}" x-init="setTimeout(() => show = true, 200)" x-bind:class="{'animate-fadeInUp': show}">
                                    <p class="text-gray-500 text-sm mb-1">Jumlah Siswa</p>
                                    <p class="text-2xl font-bold text-indigo-600">{{ $sekolah->jumlah_siswa ?? '0' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-blue-50 to-white p-4 rounded-xl text-center border border-blue-100 shadow-sm transform transition-all duration-300 hover:shadow-md hover:-translate-y-1" x-data="{show: false}" x-init="setTimeout(() => show = true, 400)" x-bind:class="{'animate-fadeInUp': show}">
                                    <p class="text-gray-500 text-sm mb-1">Jumlah Guru</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $sekolah->jumlah_guru ?? '0' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-purple-50 to-white p-4 rounded-xl text-center border border-purple-100 shadow-sm transform transition-all duration-300 hover:shadow-md hover:-translate-y-1" x-data="{show: false}" x-init="setTimeout(() => show = true, 600)" x-bind:class="{'animate-fadeInUp': show}">
                                    <p class="text-gray-500 text-sm mb-1">Jumlah Kelas</p>
                                    <p class="text-2xl font-bold text-purple-600">{{ $sekolah->jumlah_kelas ?? '0' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-green-50 to-white p-4 rounded-xl text-center border border-green-100 shadow-sm transform transition-all duration-300 hover:shadow-md hover:-translate-y-1" x-data="{show: false}" x-init="setTimeout(() => show = true, 800)" x-bind:class="{'animate-fadeInUp': show}">
                                    <p class="text-gray-500 text-sm mb-1">Tahun Berdiri</p>
                                    <p class="text-2xl font-bold text-green-600">{{ $sekolah->tahun_berdiri ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Facilities Card -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 border-b">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Fasilitas
                            </h3>
                        </div>
                        <div class="p-6">
                            @if(!empty($fasilitas) && $fasilitas->count())
                                <ul class="space-y-2">
                                    @foreach($fasilitas as $item)
                                        <li class="flex items-center p-2 bg-gray-50 rounded-lg border border-gray-100 shadow-sm transition-all duration-200 hover:bg-white hover:shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-gray-700">{{ $item->nama_fasilitas }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="flex items-center justify-center h-40 bg-gray-50 rounded-lg border border-gray-100">
                                    <p class="text-gray-500 text-center">Belum ada data fasilitas.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Achievement Card -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600 border-b">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                Prestasi
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($prestasis->count())
                                <ul class="space-y-3">
                                    @foreach($prestasis as $prestasi)
                                        <li class="p-3 bg-gray-50 rounded-lg border border-gray-100 shadow-sm transition-all duration-200 hover:bg-white hover:shadow-md">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-purple-100 p-1.5 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">{{ $prestasi->nama_prestasi }}</p>
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                            {{ $prestasi->tingkat }}
                                                        </span>
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $prestasi->tahun }}
                                                        </span>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">Penyelenggara: {{ $prestasi->penyelenggara }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="flex items-center justify-center h-40 bg-gray-50 rounded-lg border border-gray-100">
                                    <p class="text-gray-500 text-center">Belum ada data prestasi.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js for notifications -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@if($hasCoordinates)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the map centered on the school's location
        var schoolMap = L.map('school-map', {
            zoomControl: true,
            scrollWheelZoom: false // Disable scroll wheel zoom for better UX
        }).setView([{{ $sekolah->latitude }}, {{ $sekolah->longitude }}], 16);
        
        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(schoolMap);
        
        // Custom icon for the marker
        var schoolIcon = L.divIcon({
            html: `<div class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full shadow-lg border-2 border-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                  </div>`,
            className: '',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });
        
        // Add a marker for the school's location with custom icon
        var marker = L.marker([{{ $sekolah->latitude }}, {{ $sekolah->longitude }}], {
            icon: schoolIcon
        }).addTo(schoolMap)
            .bindPopup(`
                <div class="min-w-[250px]">
                    <h6 class="text-base font-semibold text-gray-900 mb-1">{{ $sekolah->nama_sekolah }}</h6>
                    <p class="text-xs text-blue-600 font-medium mb-2">{{ $sekolah->jenjang }} {{ $sekolah->status }}</p>
                    <div class="h-px bg-gray-200 my-2"></div>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p>{{ $sekolah->alamat }}</p>
                        <p>{{ $village->name }}, {{ $district->name }}</p>
                        <p>{{ $city->name }}, {{ $province->name }}</p>
                    </div>
                </div>
            `)
            .openPopup();
        
        // Add a circle to indicate the area with a pulsing animation
        var circle = L.circle([{{ $sekolah->latitude }}, {{ $sekolah->longitude }}], {
            color: '#3b82f6',
            fillColor: '#60a5fa',
            fillOpacity: 0.2,
            radius: 200,
            weight: 2
        }).addTo(schoolMap);
        
        // Add a second pulsing circle for effect
        var pulsingCircle = L.circle([{{ $sekolah->latitude }}, {{ $sekolah->longitude }}], {
            color: 'rgba(59, 130, 246, 0.5)',
            fillColor: 'rgba(96, 165, 250, 0.3)',
            fillOpacity: 0.3,
            radius: 200,
            weight: 1
        }).addTo(schoolMap);
        
        // Pulsing animation for the circle
        function pulseCircle() {
            var radius = 200;
            var opacity = 0.3;
            
            var interval = setInterval(function() {
                radius += 5;
                opacity -= 0.01;
                
                if (radius > 300) {
                    clearInterval(interval);
                    pulsingCircle.setRadius(200);
                    pulsingCircle.setStyle({
                        fillOpacity: 0.3,
                        opacity: 0.5
                    });
                    setTimeout(pulseCircle, 2000);
                } else {
                    pulsingCircle.setRadius(radius);
                    pulsingCircle.setStyle({
                        fillOpacity: opacity > 0 ? opacity : 0,
                        opacity: opacity > 0 ? opacity + 0.2 : 0
                    });
                }
            }, 50);
        }
        
        pulseCircle();
        
        // Enable map interaction on click/touch
        schoolMap.on('focus', function() {
            schoolMap.scrollWheelZoom.enable();
        });
        
        // Disable scroll wheel zoom when mouse leaves the map
        schoolMap.on('blur', function() {
            schoolMap.scrollWheelZoom.disable();
        });
        
        // Make the map resize properly when shown
        setTimeout(function() {
            schoolMap.invalidateSize();
        }, 0);
        
        // Add a fullscreen control
        schoolMap.on('click', function() {
            setTimeout(function() {
                schoolMap.invalidateSize();
            }, 100);
        });
    });
</script>
@endif
@endsection
