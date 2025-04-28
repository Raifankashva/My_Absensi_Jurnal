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
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 font-medium text-gray-700">Profil Sekolah</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Notification -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm transition-all duration-500 ease-in-out" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none">
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
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header with title and edit button -->
        <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-indigo-50 to-white border-b">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">Profil Sekolah</h1>
            <a href="{{ route('sekolah.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Profil
            </a>
        </div>

        <!-- School Info -->
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- School Image -->
                <div class="w-full md:w-1/3 lg:w-1/4">
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm border">
                        @if ($sekolah->foto)
                            <img src="{{ asset('storage/' . $sekolah->foto) }}" 
                                alt="Foto {{ $sekolah->nama_sekolah }}" 
                                class="w-full h-auto object-cover aspect-square">
                        @else
                            <img src="{{ asset('images/school-default.png') }}" 
                                alt="Default School" 
                                class="w-full h-auto object-cover aspect-square">
                        @endif
                    </div>
                </div>

                <!-- School Details -->
                <div class="w-full md:w-2/3 lg:w-3/4">
                    <div class="flex flex-col h-full">
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $sekolah->nama_sekolah }}</h2>
                            <div class="flex items-center mt-1">
                                <span class="px-2.5 py-0.5 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                                    NPSN: {{ $sekolah->npsn }}
                                </span>
                                @if ($sekolah->akreditasi)
                                    <span class="ml-2 px-2.5 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                        Akreditasi {{ $sekolah->akreditasi }}
                                    </span>
                                @endif
                                <span class="ml-2 px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                    {{ $sekolah->jenjang }}
                                </span>
                                <span class="ml-2 px-2.5 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                    {{ $sekolah->status }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Kepala Sekolah</p>
                                        <p class="text-sm text-gray-600">{{ $sekolah->kepala_sekolah }}</p>
                                        @if ($sekolah->nip_kepala_sekolah)
                                            <p class="text-xs text-gray-500">NIP: {{ $sekolah->nip_kepala_sekolah }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Telepon</p>
                                        <p class="text-sm text-gray-600">{{ $sekolah->no_telp }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Email</p>
                                        <p class="text-sm text-gray-600">{{ $sekolah->email }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Website</p>
                                        @if ($sekolah->website)
                                            <a href="{{ $sekolah->website }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline">
                                                {{ $sekolah->website }}
                                            </a>
                                        @else
                                            <p class="text-sm text-gray-500">-</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-gray-900">Status Aktif:</p>
                                @if ($sekolah->is_active)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Belum Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                            <div class="h-48 md:h-full bg-gray-100 rounded-lg overflow-hidden">
                                <!-- Map placeholder - could be replaced with an actual map -->
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <div class="text-center p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600">Peta Lokasi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Statistics Card -->
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-white border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Statistik</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <p class="text-gray-500 text-sm">Jumlah Siswa</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $sekolah->jumlah_siswa ?? '0' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <p class="text-gray-500 text-sm">Jumlah Guru</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $sekolah->jumlah_guru ?? '0' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <p class="text-gray-500 text-sm">Jumlah Kelas</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $sekolah->jumlah_kelas ?? '0' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <p class="text-gray-500 text-sm">Tahun Berdiri</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $sekolah->tahun_berdiri ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facilities Card -->
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-white border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Fasilitas</h3>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-2">
                            @if(isset($sekolah->fasilitas) && is_array($sekolah->fasilitas))
                                @foreach($sekolah->fasilitas as $fasilitas)
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $fasilitas }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-gray-500 italic">Data fasilitas belum tersedia</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Achievement Card -->
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-white border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Prestasi</h3>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-2">
                            @if(isset($sekolah->prestasi) && is_array($sekolah->prestasi))
                                @foreach($sekolah->prestasi as $prestasi)
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span>{{ $prestasi }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-gray-500 italic">Data prestasi belum tersedia</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js for notifications -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection
