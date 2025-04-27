@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="max-w-7xl mx-auto mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-white">Detail Data Siswa</h1>
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-3">
                            <a href="{{ route('adminsiswa.index') }}" 
                               class="inline-flex items-center px-5 py-2.5 rounded-lg bg-white text-blue-600 hover:bg-blue-50 font-medium transition duration-300 ease-in-out shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </a>
                            <a href="{{ route('adminsiswa.edit', $dataSiswa->id) }}" 
                               class="inline-flex items-center px-5 py-2.5 rounded-lg bg-amber-400 text-white hover:bg-amber-500 font-medium transition duration-300 ease-in-out shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-12 gap-8">
                <!-- Left Column - Profile Photo & QR Code -->
                <div class="md:col-span-4 space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-b from-blue-500/30 to-blue-500/10"></div>
                            <div class="p-8 flex justify-center">
                                <div class="relative">
                                    @if($dataSiswa->foto)
                                        <img src="{{ asset('storage/' . $dataSiswa->foto) }}" 
                                             alt="Foto {{ $dataSiswa->nama_lengkap }}" 
                                             class="w-48 h-48 object-cover rounded-full border-4 border-white shadow-lg">
                                    @else
                                        <div class="w-48 h-48 rounded-full bg-gray-200 border-4 border-white shadow-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-2 -right-2 bg-blue-500 text-white rounded-full p-2 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $dataSiswa->nama_lengkap }}</h2>
                            <p class="text-blue-600 font-medium">NISN: {{ $dataSiswa->nisn }}</p>
                            <p class="text-gray-500 mt-1">{{ $dataSiswa->kelas->nama_kelas }} (Tingkat {{ $dataSiswa->kelas->tingkat }})</p>
                            <p class="text-gray-500">{{ $dataSiswa->sekolah->nama_sekolah }}</p>
                        </div>
                    </div>

                    <!-- QR Code Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                QR Code Siswa
                            </h3>
                            <div class="flex flex-col items-center">
                                @if(isset($qrCodeUrl))
                                    <div class="bg-white p-3 rounded-lg shadow-md mb-4">
                                        <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-48 h-48 object-contain">
                                    </div>
                                    <a href="{{ route('adminsiswa.download-qr', $dataSiswa->id) }}" 
                                       class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 font-medium transition duration-300 ease-in-out shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download QR Code
                                    </a>
                                @else
                                    <div class="bg-gray-100 p-8 rounded-lg flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-gray-500">QR Code tidak tersedia</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Student Information -->
                <div class="md:col-span-8 space-y-6">
                    <!-- Data Pribadi Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Pribadi</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">NISN</span>
                                        <span class="font-medium text-gray-900 bg-gray-100 px-3 py-1 rounded-full">{{ $dataSiswa->nisn }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Nama Lengkap</span>
                                        <span class="font-medium text-gray-900">{{ $dataSiswa->nama_lengkap }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Jenis Kelamin</span>
                                        <span class="font-medium text-gray-900">{{ ucfirst($dataSiswa->jenis_kelamin) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Email</span>
                                        <span class="font-medium text-gray-900">{{ $dataSiswa->user->email }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">No Telepon</span>
                                        <span class="font-medium text-gray-900">{{ $dataSiswa->user->no_hp }}</span>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Tempat Lahir</span>
                                        <span class="font-medium text-gray-900">{{ $dataSiswa->tmp_lahir }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Tanggal Lahir</span>
                                        <span class="font-medium text-gray-900">{{ $dataSiswa->tgl_lahir->format('d F Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Agama</span>
                                        <span class="font-medium text-gray-900">{{ $dataSiswa->agama }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Alamat</span>
                                        <span class="font-medium text-gray-900">{{ $dataSiswa->user->alamat }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Akademik Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-amber-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Akademik</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-gray-600 text-sm mb-1">Sekolah</div>
                                    <div class="font-semibold text-gray-900 text-lg">{{ $dataSiswa->sekolah->nama_sekolah }}</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-gray-600 text-sm mb-1">Kelas</div>
                                    <div class="font-semibold text-gray-900 text-lg">
                                        {{ $dataSiswa->kelas->nama_kelas }} 
                                        <span class="text-blue-600">(Tingkat {{ $dataSiswa->kelas->tingkat }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Orang Tua/Wali</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-800">Data Ayah</h4>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <span class="text-gray-600">Nama</span>
                                            <span class="font-medium text-gray-900">{{ $dataSiswa->ayah }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <span class="text-gray-600">Pekerjaan</span>
                                            <span class="font-medium text-gray-900">{{ $dataSiswa->kerja_ayah ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <span class="text-gray-600">Email Ayah</span><span class="font-medium text-gray-900">{{ $dataSiswa->email_ayah ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-pink-100 p-2 rounded-full mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-800">Data Ibu</h4>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <span class="text-gray-600">Nama</span>
                                            <span class="font-medium text-gray-900">{{ $dataSiswa->ibu }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <span class="text-gray-600">Pekerjaan</span>
                                            <span class="font-medium text-gray-900">{{ $dataSiswa->kerja_ibu ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                            <span class="text-gray-600">Email Ibu</span>
                                            <span class="font-medium text-gray-900">{{ $dataSiswa->email_ibu ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
