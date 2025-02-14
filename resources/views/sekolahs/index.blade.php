@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 transform transition-all animate-fade-in-down">
                <div class="bg-green-500 text-white px-4 py-3 rounded-xl shadow-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bx bx-check-circle text-2xl mr-3"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button class="focus:outline-none">
                        <i class="bx bx-x text-2xl"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 transform transition-all animate-fade-in-down">
                <div class="bg-red-500 text-white px-4 py-3 rounded-xl shadow-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bx bx-error-circle text-2xl mr-3"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button class="focus:outline-none">
                        <i class="bx bx-x text-2xl"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Main Content Card -->
        <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-2xl border border-blue-100">
            <!-- Header Section -->
            <div class="p-6 border-b border-blue-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-blue-900 flex items-center">
                        <i class="bx bxs-school text-blue-600 mr-3"></i>
                        Daftar Sekolah
                    </h2>
                    
                    <!-- Search and Add Button Group -->
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <form action="{{ route('sekolahs.index') }}" method="GET" 
                              class="flex-1 sm:flex-initial">
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       placeholder="Cari sekolah..." 
                                       value="{{ request('search') }}"
                                       class="w-full sm:w-64 pl-4 pr-10 py-2 border border-blue-200 rounded-xl 
                                              focus:ring-2 focus:ring-blue-300 focus:border-blue-300 
                                              transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <button type="submit" 
                                        class="absolute right-2 top-1/2 transform -translate-y-1/2 
                                               text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                    <i class="bx bx-search text-xl"></i>
                                </button>
                            </div>
                        </form>
                        
                        <a href="{{ route('sekolahs.create') }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 
                                  hover:bg-blue-700 text-white font-semibold rounded-xl 
                                  transition-all duration-200 transform hover:scale-105 
                                  shadow-md hover:shadow-lg space-x-2">
                            <i class="bx bx-plus text-xl"></i>
                            <span>Tambah Sekolah</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Schools Grid -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($sekolahs as $sekolah)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl border border-blue-50 
                                  transition-all duration-300 hover:scale-102 group relative 
                                  overflow-hidden">
                            <div class="p-6">
                                <!-- School Status Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                               {{ $sekolah->status === 'Negeri' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $sekolah->status }}
                                    </span>
                                </div>

                                <!-- School Header -->
                                <div class="flex items-start space-x-4 mb-6">
                                    <div class="w-16 h-16 flex-shrink-0 bg-blue-100 rounded-xl 
                                                flex items-center justify-center group-hover:bg-blue-200 
                                                transition-colors duration-200">
                                        <i class="bx bxs-school text-3xl text-blue-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xl font-bold text-blue-900 truncate mb-1">
                                            {{ $sekolah->nama_sekolah }}
                                        </h3>
                                        <p class="text-sm text-gray-600">NPSN: {{ $sekolah->npsn }}</p>
                                    </div>
                                </div>

                                <!-- School Details -->
                                <div class="space-y-2 mb-6">
                                    <div class="flex items-start space-x-3 text-sm text-gray-600">
                                        <i class="bx bx-map text-blue-600 mt-1"></i>
                                        <span>{{ $sekolah->alamat }}</span>
                                    </div>
                                    <div class="flex items-start space-x-3 text-sm text-gray-600">
                                        <i class="bx bx-buildings text-blue-600 mt-1"></i>
                                        <span>{{ $sekolah->village->name }}, {{ $sekolah->district->name }}</span>
                                    </div>
                                    <div class="flex items-start space-x-3 text-sm text-gray-600">
                                        <i class="bx bx-globe text-blue-600 mt-1"></i>
                                        <span>{{ $sekolah->city->name }}, {{ $sekolah->province->name }}</span>
                                    </div>
                                </div>

                                <!-- Footer Section -->
                                <div class="flex items-center justify-between pt-4 border-t border-blue-50">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="bx bxs-user-detail text-blue-600 mr-2"></i>
                                        <span>{{ number_format($sekolah->total_siswa) }} Siswa</span>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('sekolahs.show', $sekolah) }}" 
                                           class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                           title="Lihat Detail">
                                            <i class="bx bx-show text-xl"></i>
                                        </a>
                                        <a href="{{ route('sekolahs.edit', $sekolah) }}" 
                                           class="text-green-600 hover:text-green-800 transition-colors duration-200"
                                           title="Edit">
                                            <i class="bx bx-edit text-xl"></i>
                                        </a>
                                        <form action="{{ route('sekolahs.destroy', $sekolah) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 transition-colors duration-200"
                                                    title="Hapus">
                                                <i class="bx bx-trash text-xl"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- QR Code -->
                                <div class="absolute bottom-3 right-3 opacity-40 group-hover:opacity-100 transition-opacity duration-200">
                                    <img src="data:image/png;base64,{{ base64_encode($sekolah->qr_code_url) }}" 
                                         alt="QR Code" 
                                         class="w-12 h-12">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="flex flex-col items-center justify-center py-12 bg-blue-50 rounded-xl">
                                <i class="bx bx-search-alt text-6xl text-blue-300 mb-4"></i>
                                <p class="text-gray-600 text-lg">Tidak ada data sekolah yang ditemukan</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $sekolahs->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection