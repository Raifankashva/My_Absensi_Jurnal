@extends('layouts.app3')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header with profile actions -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-white">Profil Guru</h1>
            <a href="{{ route('guru.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 text-sm font-medium rounded-md shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Profil
            </a>
        </div>
        
        <!-- Success message -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 m-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif
        
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Profile image and name section -->
                <div class="md:w-1/3 flex flex-col items-center">
                    <div class="mb-4 relative">
                        @if($guru->foto)
                            <img src="{{ asset('storage/guru-photos/' . $guru->foto) }}" alt="Foto {{ $guru->nama_lengkap }}" 
                                class="w-48 h-48 rounded-full object-cover border-4 border-indigo-100 shadow-md">
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile" 
                                class="w-48 h-48 rounded-full object-cover border-4 border-indigo-100 shadow-md">
                        @endif
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $guru->nama_lengkap }}</h2>
                    <p class="text-indigo-600 text-sm mt-1">{{ implode(', ', $guru->mata_pelajaran_array ?? []) }}</p>
                </div>
                
                <!-- Profile details section -->
                <div class="md:w-2/3">
                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">
                            Informasi Guru
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">NIP</p>
                                <p class="font-medium text-gray-800">{{ $guru->nip ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">NUPTK</p>
                                <p class="font-medium text-gray-800">{{ $guru->nuptk ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">NIK</p>
                                <p class="font-medium text-gray-800">{{ $guru->nik ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Jenis Kelamin</p>
                                <p class="font-medium text-gray-800">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Tempat, Tanggal Lahir</p>
                                <p class="font-medium text-gray-800">{{ $guru->tempat_lahir }}, {{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d F Y') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Status Kepegawaian</p>
                                <p class="font-medium text-gray-800">{{ $guru->status_kepegawaian }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">TMT Kerja</p>
                                <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($guru->tmt_kerja)->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Education -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">
                            Pendidikan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Pendidikan Terakhir</p>
                                <p class="font-medium text-gray-800">{{ $guru->pendidikan_terakhir }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Jurusan Pendidikan</p>
                                <p class="font-medium text-gray-800">{{ $guru->jurusan_pendidikan }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">
                            Kontak
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Email</p>
                                <p class="font-medium text-gray-800">{{ $user->email }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">No. HP</p>
                                <p class="font-medium text-gray-800">{{ $guru->no_hp }}</p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500 mb-1">Alamat</p>
                                <p class="font-medium text-gray-800">{{ $guru->alamat }}</p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500 mb-1">Sekolah</p>
                                <p class="font-medium text-gray-800">{{ $guru->sekolah->nama_sekolah ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
