@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with actions -->
        <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
            <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Sekolah</h1>
                    <p class="text-sm text-gray-500">Informasi lengkap tentang {{ $school->nama_sekolah }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('adminsekolah.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('adminsekolah.edit', $school->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('adminsekolah.toggle-active', $school->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white {{ $school->is_active ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $school->is_active ? 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                            </svg>
                            {{ $school->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Alert -->
        @if (session('success'))
        <div class="rounded-md bg-green-50 p-4 mb-6 border border-green-200" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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

        <!-- School Profile -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/4 flex justify-center">
                        <div class="relative group">
                            @if($school->foto)
                                <img src="{{ asset('storage/' . $school->foto) }}" alt="{{ $school->nama_sekolah }}" class="rounded-lg shadow-md object-cover w-full max-w-xs h-auto transition duration-300 group-hover:shadow-lg">
                            @else
                                <img src="{{ asset('images/school-placeholder.png') }}" alt="No Image" class="rounded-lg shadow-md object-cover w-full max-w-xs h-auto transition duration-300 group-hover:shadow-lg">
                            @endif
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center transition-all duration-300 rounded-lg">
                                <span class="text-white opacity-0 group-hover:opacity-100 font-medium">Lihat Foto</span>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-3/4">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $school->nama_sekolah }}</h2>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $school->status == 'Negeri' ? 'bg-blue-100 text-blue-800' : 'bg-indigo-100 text-indigo-800' }}">
                                {{ $school->status }}
                            </span>
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                {{ $school->jenjang }}
                            </span>
                            @if($school->akreditasi)
                                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Akreditasi {{ $school->akreditasi }}
                                </span>
                            @endif
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $school->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $school->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">NPSN</p>
                                <p class="font-medium text-gray-900">{{ $school->npsn }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Kepala Sekolah</p>
                                <p class="font-medium text-gray-900">{{ $school->kepala_sekolah }}</p>
                            </div>
                            @if($school->nip_kepala_sekolah)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">NIP Kepala Sekolah</p>
                                <p class="font-medium text-gray-900">{{ $school->nip_kepala_sekolah }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div x-data="{ activeTab: 'info' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button @click="activeTab = 'info'" :class="{'border-blue-500 text-blue-600': activeTab === 'info', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'info'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Informasi Kontak
                    </button>
                    <button @click="activeTab = 'user'" :class="{'border-blue-500 text-blue-600': activeTab === 'user', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'user'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Akun Pengguna
                    </button>
                    <button @click="activeTab = 'address'" :class="{'border-blue-500 text-blue-600': activeTab === 'address', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'address'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Alamat
                    </button>
                    
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="mt-6">
                <!-- Info Tab -->
                <div x-show="activeTab === 'info'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Kontak</h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <a href="mailto:{{ $school->email }}" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $school->email }}</a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <a href="tel:{{ $school->no_telp }}" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $school->no_telp }}</a>
                                    </dd>
                                </div>
                                @if($school->website)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Website</dt>
                                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                        <a href="{{ $school->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $school->website }}</a>
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- User Tab -->
                <div x-show="activeTab === 'user'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Akun Pengguna</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xl font-semibold mr-4">
                                    {{ strtoupper(substr($school->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">{{ $school->user->name }}</h4>
                                    <p class="text-sm text-gray-500">Pengguna Terdaftar</p>
                                </div>
                            </div>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $school->user->email }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">No HP</dt>
                                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        {{ $school->user->no_hp }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terdaftar pada</dt>
                                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $school->created_at->format('d M Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Address Tab -->
                <div x-show="activeTab === 'address'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Alamat</h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <p class="text-gray-700">{{ $school->alamat }}</p>
                            </div>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Provinsi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $school->province->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kabupaten/Kota</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $school->city->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kecamatan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $school->district->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Desa/Kelurahan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $school->village->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kode Pos</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $school->kode_pos }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                
                            
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js and Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
