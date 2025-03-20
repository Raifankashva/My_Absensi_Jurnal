@extends('layouts.app2')

@section('content')
<style>
    /* Custom animations */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    /* Decorative elements */
    .decoration-dot {
        position: absolute;
        border-radius: 50%;
        z-index: 0;
        opacity: 0.6;
    }
    
    /* Shimmer effect */
    @keyframes shimmer {
        0% { background-position: -100% 0; }
        100% { background-position: 200% 0; }
    }
    
    .shimmer {
        background: linear-gradient(90deg, 
            rgba(255,255,255,0) 0%, 
            rgba(255,255,255,0.2) 50%, 
            rgba(255,255,255,0) 100%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }
    
    /* Card hover effect */
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
    }
    
    /* Print styles */
    @media print {
        .no-print {
            display: none !important;
        }
        
        .print-break-inside-avoid {
            break-inside: avoid;
        }
        
        body {
            background: white !important;
        }
        
        .print-shadow-none {
            box-shadow: none !important;
        }
        
        .print-border {
            border: 1px solid #e5e7eb !important;
        }
    }
</style>

<div class="min-h-screen py-4 md:py-8 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="decoration-dot bg-blue-300 w-32 h-32 -top-10 -left-10 animate-float no-print" style="animation-delay: 0s;"></div>
    <div class="decoration-dot bg-blue-400 w-24 h-24 top-1/4 -right-10 animate-float no-print" style="animation-delay: 1s;"></div>
    <div class="decoration-dot bg-blue-200 w-40 h-40 bottom-1/3 -left-20 animate-float no-print" style="animation-delay: 2s;"></div>
    <div class="decoration-dot bg-blue-300 w-20 h-20 bottom-10 right-10 animate-float no-print" style="animation-delay: 3s;"></div>
    
    <div class="max-w-5xl mx-auto px-4 relative z-10">
        <!-- Action buttons -->
        <div class="flex justify-end mb-4 no-print">
            <button onclick="window.print()" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition-colors duration-200 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak</span>
            </button>
            <a href="#" class="flex items-center space-x-2 bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg shadow transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit</span>
            </a>
        </div>
        
        <div class="bg-white rounded-xl shadow-xl overflow-hidden print-shadow-none print-border">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 md:p-6 text-white relative overflow-hidden">
                <!-- Decorative circles in header -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full transform translate-x-10 -translate-y-10"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full transform -translate-x-10 translate-y-10"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Data Siswa
                        </h2>
                        <p class="text-blue-100 mt-1 md:mt-2 ml-9">Informasi lengkap data diri siswa</p>
                    </div>
                    
                    <div class="mt-4 md:mt-0 ml-9 md:ml-0">
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-800 bg-opacity-50 text-sm font-medium">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            Aktif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 md:p-6">
                <!-- Profile header -->
                <div class="flex flex-col md:flex-row items-center md:items-start mb-8 print-break-inside-avoid">
                    <div class="relative mb-4 md:mb-0 md:mr-6">
                        @if($dataSiswa->foto)
                            <img src="{{ asset('storage/'.$dataSiswa->foto) }}" alt="Foto Profil" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center border-4 border-white shadow-lg">
                                <span class="text-4xl text-white font-bold">{{ substr($dataSiswa->nama_lengkap, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="text-center md:text-left flex-1">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $dataSiswa->nama_lengkap }}</h1>
                        <p class="text-gray-500 mt-1">NISN: {{ $dataSiswa->nisn }}</p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-3">
                            <div class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full border border-blue-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                NIS: {{ $dataSiswa->nis ?? '-' }}
                            </div>
                            <div class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full border border-blue-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                                Kelas {{ $dataSiswa->kelas_id ?? '-' }}
                            </div>
                            <div class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full border border-blue-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $dataSiswa->hp ?? 'Belum diisi' }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Data sections -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden card-hover print-break-inside-avoid">
                        <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                            <h3 class="font-semibold text-blue-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Informasi Pribadi
                            </h3>
                        </div>
                        <div class="p-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->nama_lengkap }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">NIK</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->nik ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($dataSiswa->jenis_kelamin) ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Agama</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($dataSiswa->agama) ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Tempat Lahir</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->tmp_lahir ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($dataSiswa->tgl_lahir)
                                            {{ \Carbon\Carbon::parse($dataSiswa->tgl_lahir)->format('d F Y') }}
                                        @else
                                            -
                                        @endif
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Tinggi Badan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->tb ? $dataSiswa->tb . ' cm' : '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Berat Badan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->bb ? $dataSiswa->bb . ' kg' : '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden card-hover print-break-inside-avoid">
                        <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                            <h3 class="font-semibold text-blue-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Kontak & Alamat
                            </h3>
                        </div>
                        <div class="p-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-3">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nomor HP</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->hp ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->user->alamat ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Provinsi / Kota</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $provinsi ?? '-' }} / {{ $kota ?? '-' }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Kecamatan / Desa</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $kecamatan ?? '-' }} / {{ $desa ?? '-' }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Kode Pos</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->kode_pos ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Status Tinggal</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucwords($dataSiswa->tinggal) ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Transportasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucwords($dataSiswa->transport) ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    
                    <!-- Family Information -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden card-hover print-break-inside-avoid">
                        <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                            <h3 class="font-semibold text-blue-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Informasi Keluarga
                            </h3>
                        </div>
                        <div class="p-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nama Ayah</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->ayah ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Pekerjaan Ayah</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->kerja_ayah ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nama Ibu</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->ibu ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Pekerjaan Ibu</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->kerja_ibu ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nama Wali</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->wali ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Pekerjaan Wali</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->kerja_wali ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden card-hover print-break-inside-avoid">
                        <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                            <h3 class="font-semibold text-blue-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Informasi Tambahan
                            </h3>
                        </div>
                        <div class="p-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nomor KKS</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->kks ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nomor KPH</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->kph ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nomor KIP</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $dataSiswa->kip ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Sekolah</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $sekolah ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                
                <!-- Academic Summary -->
                <div class="mt-6 bg-white rounded-lg border border-gray-200 overflow-hidden card-hover print-break-inside-avoid">
                    <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                        <h3 class="font-semibold text-blue-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                            Ringkasan Akademik
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-4 md:mb-0">
                                <h4 class="text-sm font-medium text-gray-700">Kelas Saat Ini</h4>
                                <p class="text-lg font-semibold text-blue-700">{{ $kelas ?? 'Belum ditentukan' }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div class="bg-blue-50 p-3 rounded-lg text-center">
                                    <p class="text-xs text-gray-500">Semester</p>
                                    <p class="text-lg font-semibold text-blue-700">{{ $semester ?? '-' }}</p>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-lg text-center">
                                    <p class="text-xs text-gray-500">Tahun Ajaran</p>
                                    <p class="text-lg font-semibold text-blue-700">{{ $tahun_ajaran ?? '-' }}</p>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-lg text-center col-span-2 md:col-span-1">
                                    <p class="text-xs text-gray-500">Status</p>
                                    <p class="text-lg font-semibold text-blue-700">Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="mt-6 text-center text-gray-500 text-sm print-break-inside-avoid">
                    <p>Data terakhir diperbarui: {{ now()->format('d F Y, H:i') }}</p>
                    <p class="mt-1 no-print">Silahkan klik tombol Edit untuk mengubah data</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Card hover animations
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('opacity-100', 'translate-y-0');
            card.classList.remove('opacity-0', 'translate-y-4');
        }, 100 * index);
    });
    
    // Print button tooltip
    const printButton = document.querySelector('button[onclick="window.print()"]');
    if (printButton) {
        printButton.addEventListener('mouseenter', () => {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 transition-opacity duration-300';
            tooltip.textContent = 'Cetak data siswa';
            tooltip.id = 'print-tooltip';
            
            printButton.style.position = 'relative';
            printButton.appendChild(tooltip);
            
            setTimeout(() => {
                document.getElementById('print-tooltip').classList.remove('opacity-0');
                document.getElementById('print-tooltip').classList.add('opacity-100');
            }, 50);
        });
        
        printButton.addEventListener('mouseleave', () => {
            const tooltip = document.getElementById('print-tooltip');
            if (tooltip) {
                tooltip.classList.remove('opacity-100');
                tooltip.classList.add('opacity-0');
                
                setTimeout(() => {
                    tooltip.remove();
                }, 300);
            }
        });
    }
});
</script>
@endsection