@extends('layouts.app2')

@section('content')
<div class="px-4 py-4 max-w-3xl mx-auto">
    <!-- Student Profile Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
        <!-- Header with gradient background -->
        <div class="p-4 bg-gradient-to-r from-primary-600 to-primary-800">
            <div class="flex items-center gap-4">
                <!-- Student photo -->
                <div class="flex-shrink-0 h-20 w-20 rounded-full ring-2 ring-white/90 overflow-hidden bg-white">
                    <img src="{{ asset('storage/' . $user->dataSiswa->foto) }}" 
                         alt="Foto {{ $user->dataSiswa->nama_lengkap }}" 
                         class="h-full w-full object-cover">
                </div>
                
                <!-- Student information -->
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-bold text-white truncate">
                        {{ $user->dataSiswa->nama_lengkap }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-500/30 text-white border border-white/20">
                            Siswa Aktif
                        </span>
                        <span class="text-sm text-white/90">
                            Kelas {{ $user->dataSiswa->kelas->nama_kelas }}
                        </span>
                    </div>
                    
                    <!-- NISN Badge -->
                    <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/90 text-primary-800">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        NISN: {{ $user->dataSiswa->nisn }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- QR Code Section -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-between">
            <div>
                <h5 class="text-sm font-medium text-gray-800">QR Code Absensi</h5>
                <p class="text-xs text-gray-500">Tunjukkan saat absensi</p>
            </div>
            <div class="bg-gray-50 p-2 rounded-lg">
                <img src="{{ $qrCodeUrl }}" alt="QR Code {{ $user->dataSiswa->nama_lengkap }}" class="h-20 w-20">
            </div>
        </div>
        
        <!-- Student ID Card Download -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-between">
            <div>
                <h5 class="text-sm font-medium text-gray-800">Kartu Pelajar</h5>
                <p class="text-xs text-gray-500">Unduh kartu pelajar resmi</p>
            </div>
            
            <!-- Add this in resources/views/siswa/profile.blade.php where appropriate -->
<div class="mt-4">
    <a href="{{ route('siswa.cetak-kartu-pelajar') }}" class="btn btn-primary" target="_blank">
        <i class="fas fa-id-card mr-1"></i> Cetak Kartu Pelajar
    </a>
</div>
<!-- Add this in resources/views/siswa/profile.blade.php where appropriate -->
<div class="mt-4">
    <a href="{{ route('siswa.cetak-data-siswa') }}" class="btn btn-primary" target="_blank">
        <i class="fas fa-print mr-1"></i> Cetak Data Siswa
    </a>
</div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        <div class="bg-white rounded-xl shadow-sm p-4 transition-all duration-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="p-2.5 rounded-lg bg-primary-50 text-primary-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-gray-500 font-medium">Sekolah</p>
                    <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $user->dataSiswa->sekolah->nama_sekolah }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 transition-all duration-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="p-2.5 rounded-lg bg-green-50 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-gray-500 font-medium">Semester</p>
                    <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $user->dataSiswa->semester_aktif ?? 'Ganjil 2024/2025' }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 transition-all duration-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="p-2.5 rounded-lg bg-purple-50 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-gray-500 font-medium">Total Mapel</p>
                    <h3 class="text-sm font-semibold text-gray-800">{{ $user->dataSiswa->kelas->jadwalPelajaran->unique('mata_pelajaran')->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 transition-all duration-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="p-2.5 rounded-lg bg-yellow-50 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-gray-500 font-medium">Hari Ini</p>
                    <h3 class="text-sm font-semibold text-gray-800 truncate">{{ now()->isoFormat('dddd') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Section - Mobile Optimized -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-4 py-3.5 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-800">Jadwal Pelajaran</h2>
            <p class="text-xs text-gray-500">
                {{ $user->dataSiswa->semester_aktif ?? 'Ganjil' }} {{ $user->dataSiswa->tahun_ajaran ?? '2024/2025' }}
            </p>
        </div>

        <!-- Day Tabs - Scrollable on mobile -->
        <div class="border-b border-gray-200 overflow-x-auto schedule-tabs">
            <div class="flex whitespace-nowrap" aria-label="Tabs" x-data="{ activeDay: '{{ now()->locale('id')->dayName }}' }">
                @php
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $currentDay = now()->locale('id')->dayName;
                @endphp

                @foreach($days as $hari)
                    <button 
                        @click="activeDay = '{{ $hari }}'"
                        class="py-2.5 px-5 text-center border-b-2 transition-colors duration-200 text-xs font-medium"
                        :class="activeDay === '{{ $hari }}' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    >
                        <span class="inline-flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="activeDay === '{{ $hari }}' ? 'bg-primary-500' : 'bg-transparent'"></span>
                            {{ $hari }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Schedule Content -->
        <div x-data="{ activeDay: '{{ now()->locale('id')->dayName }}' }">
            @foreach($days as $hari)
                <div 
                    x-show="activeDay === '{{ $hari }}'"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                >
                    @if(isset($jadwalPerHari[$hari]) && $jadwalPerHari[$hari]->count() > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach($jadwalPerHari[$hari]->sortBy('waktu_mulai') as $jadwal)
                                @php
                                    $isCurrentClass = Carbon\Carbon::now()->format('l') == $hari && 
                                        Carbon\Carbon::now()->between(
                                            Carbon\Carbon::parse($jadwal->waktu_mulai),
                                            Carbon\Carbon::parse($jadwal->waktu_selesai)
                                        );
                                @endphp
                                <div class="p-4 {{ $isCurrentClass ? 'bg-green-50 border-l-4 border-green-500' : '' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="font-medium text-sm {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                            {{ $jadwal->mata_pelajaran }}
                                        </div>
                                        <div class="text-xs font-medium {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }} bg-gray-100 px-2 py-1 rounded">
                                            {{ Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - 
                                            {{ Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <div class="text-xs {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }} font-medium">
                                                {{ $jadwal->guru->nama_lengkap }}
                                            </div>
                                            <div class="text-xs {{ $isCurrentClass ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $jadwal->guru->nip }}
                                            </div>
                                        </div>
                                        <div class="text-xs {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }} bg-gray-100 px-2 py-1 rounded">
                                            {{ $jadwal->ruangan ?? 'Default' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <p class="text-gray-500 text-sm mt-2">Tidak ada jadwal pelajaran untuk hari {{ $hari }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Attendance History -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-4 py-3.5 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-800">Riwayat Absensi</h2>
            <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        
        <div class="p-4">
            <div class="space-y-3">
                @forelse($absensi->take(3) as $data)
                    <div class="bg-gray-50 rounded-lg p-3 hover:bg-gray-100 transition-colors">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($data->waktu_scan)->format('d-m-Y') }}
                            </div>
                            @if($data->status == 'Hadir')
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ $data->status }}</span>
                            @elseif($data->status == 'Terlambat')
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ $data->status }}</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ $data->status }}</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mt-1.5 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($data->waktu_scan)->format('H:i:s') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 text-sm mt-2">Belum ada data absensi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Profile Section - Accordion Style -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5" x-data="{ open: false }">
        <div class="px-4 py-3.5 border-b border-gray-100 flex justify-between items-center cursor-pointer" 
             @click="open = !open">
            <h3 class="text-base font-semibold text-gray-800">Data Pribadi</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transform transition-transform" 
                 :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs font-medium text-gray-500">Tempat, Tanggal Lahir</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->dataSiswa->tmp_lahir }}, {{ $user->dataSiswa->tgl_lahir }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs font-medium text-gray-500">Jenis Kelamin</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->dataSiswa->jenis_kelamin }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs font-medium text-gray-500">Agama</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->dataSiswa->agama }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs font-medium text-gray-500">No. Telepon</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->dataSiswa->hp ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs font-medium text-gray-500">Data Orang Tua</p>
                        <div class="mt-2 space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Ayah</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->dataSiswa->ayah ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Ibu</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->dataSiswa->ibu ?? '-' }}</span>
                            </div>
                            @if($user->dataSiswa->wali)
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Wali</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $user->dataSiswa->wali }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Assignments Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-4 py-3.5 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-800">Tugas Mendatang</h2>
            <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        
        <div class="p-4">
            <!-- This is a placeholder. In a real app, you would loop through upcoming assignments -->
            <div class="space-y-3">
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-primary-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-sm font-medium text-gray-800">Matematika - Tugas Trigonometri</h4>
                            <p class="text-xs text-gray-500 mt-1">Bab 4 - Halaman 45-47</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            2 hari lagi
                        </span>
                    </div>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-xs text-gray-500">Dikumpulkan: 18 Apr 2025</span>
                        <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Detail</a>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-yellow-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-sm font-medium text-gray-800">Bahasa Indonesia - Esai Sastra</h4>
                            <p class="text-xs text-gray-500 mt-1">Analisis Novel "Laskar Pelangi"</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            5 hari lagi
                        </span>
                    </div>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-xs text-gray-500">Dikumpulkan: 21 Apr 2025</span>
                        <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Detail</a>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-3 border-l-4 border-green-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-sm font-medium text-gray-800">Fisika - Laporan Praktikum</h4>
                            <p class="text-xs text-gray-500 mt-1">Hukum Newton tentang Gerak</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            1 minggu lagi
                        </span>
                    </div>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-xs text-gray-500">Dikumpulkan: 23 Apr 2025</span>
                        <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Announcements Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-4 py-3.5 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-800">Pengumuman Terbaru</h2>
            <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        
        <div class="p-4">
            <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-primary-100 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-primary-800">Ujian Tengah Semester</h3>
                        <p class="mt-1 text-xs text-primary-700">Ujian Tengah Semester akan dilaksanakan pada tanggal 25-30 April 2025. Harap mempersiapkan diri dengan baik.</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-xs text-primary-600">15 Apr 2025</span>
                            <a href="#" class="text-xs text-primary-700 font-medium hover:underline">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Alpine.js is already loaded from the layout
    });
</script>
@endpush
@endsection