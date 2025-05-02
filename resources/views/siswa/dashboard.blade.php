@extends('layouts.app2')

@section('content')
<div class="bg-gradient-to-b from-primary-50 to-white min-h-screen pb-20">
    <!-- Hero Section with Student Profile -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-500 pt-4 pb-6 px-4 sm:px-6 lg:px-8 rounded-b-3xl shadow-md">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                <!-- Student Photo -->
                <div class="relative">
                    <div class="h-24 w-24 sm:h-28 sm:w-28 rounded-full ring-4 ring-white/30 overflow-hidden bg-white flex-shrink-0">
                        <img src="{{ asset('storage/' . $user->dataSiswa->foto) }}" 
                             alt="Foto {{ $user->dataSiswa->nama_lengkap }}" 
                             class="h-full w-full object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->dataSiswa->nama_lengkap) }}&background=0D8ABC&color=fff'">
                    </div>
                    <div class="absolute -bottom-1 -right-1 bg-green-500 h-6 w-6 rounded-full flex items-center justify-center ring-2 ring-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                
                <!-- Student Information -->
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl font-bold text-white">
                        {{ $user->dataSiswa->nama_lengkap }}
                    </h1>
                    <div class="flex flex-wrap justify-center sm:justify-start items-center gap-2 mt-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white border border-white/20">
                            Kelas {{ $user->dataSiswa->kelas->nama_kelas }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white border border-white/20">
                            NISN: {{ $user->dataSiswa->nisn }}
                        </span>
                    </div>
                    <p class="mt-2 text-white/80 text-sm">
                        {{ $user->dataSiswa->sekolah->nama_sekolah }}
                    </p>
                </div>
                
                <!-- QR Code (Hidden on mobile, shown on larger screens) -->
                <div class="hidden sm:block ml-auto bg-white p-2 rounded-lg shadow-lg">
                    <img src="{{ $qrCodeUrl }}" alt="QR Code {{ $user->dataSiswa->nama_lengkap }}" class="h-24 w-24">
                    <p class="text-xs text-center text-primary-600 font-medium mt-1">Scan untuk absensi</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 transform transition-all duration-200 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-primary-100 text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500 font-medium">Total Mapel</p>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $user->dataSiswa->kelas->jadwalPelajaran->unique('mata_pelajaran')->count() }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 transform transition-all duration-200 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-green-100 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500 font-medium">Kehadiran</p>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $absensi->where('status', 'Hadir')->count() }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 transform transition-all duration-200 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-yellow-100 text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500 font-medium">Semester</p>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $user->dataSiswa->semester_aktif ?? 'Ganjil' }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 transform transition-all duration-200 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-purple-100 text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500 font-medium">Tugas</p>
                        <h3 class="text-lg font-semibold text-gray-800">3</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile QR Code (only visible on mobile) -->
        <div class="sm:hidden bg-white rounded-xl shadow-sm p-4 mb-6 flex items-center justify-between border border-gray-100">
            <div>
                <h3 class="text-sm font-medium text-gray-800">QR Code Absensi</h3>
                <p class="text-xs text-gray-500 mt-1">Scan untuk presensi harian</p>
            </div>
            <div class="bg-gray-50 p-2 rounded-lg">
                <img src="{{ $qrCodeUrl }}" alt="QR Code {{ $user->dataSiswa->nama_lengkap }}" class="h-16 w-16">
            </div>
        </div>
        
        <!-- Two Column Layout for Desktop -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column (2/3 width on desktop) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Today's Schedule -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-4 py-3 bg-gradient-to-r from-primary-50 to-white border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-base font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Jadwal Hari Ini
                        </h2>
                        <div class="text-xs font-medium px-2.5 py-1 bg-primary-100 text-primary-700 rounded-full">
                            {{ now()->isoFormat('dddd, D MMM Y') }}
                        </div>
                    </div>
                    
                    @php
                        $today = now()->locale('id')->dayName;
                        $todaySchedule = $jadwalPerHari[$today] ?? collect([]);
                    @endphp
                    
                    @if($todaySchedule->count() > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach($todaySchedule->sortBy('waktu_mulai') as $jadwal)
                                @php
                                    $isCurrentClass = Carbon\Carbon::now()->between(
                                        Carbon\Carbon::parse($jadwal->waktu_mulai),
                                        Carbon\Carbon::parse($jadwal->waktu_selesai)
                                    );
                                    $isPastClass = Carbon\Carbon::now()->isAfter(Carbon\Carbon::parse($jadwal->waktu_selesai));
                                @endphp
                                <div class="p-4 {{ $isCurrentClass ? 'bg-green-50 border-l-4 border-green-500' : ($isPastClass ? 'bg-gray-50/50' : '') }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="font-medium text-sm {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                            {{ $jadwal->mata_pelajaran }}
                                            @if($isCurrentClass)
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Sedang Berlangsung
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs font-medium {{ $isCurrentClass ? 'text-green-700 bg-green-100' : 'text-gray-700 bg-gray-100' }} px-2 py-1 rounded">
                                            {{ Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - 
                                            {{ Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-xs {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }} font-medium">
                                                    {{ $jadwal->guru->nama_lengkap }}
                                                </div>
                                                <div class="text-xs {{ $isCurrentClass ? 'text-green-600' : 'text-gray-500' }}">
                                                    {{ $jadwal->guru->nip }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div class="text-xs {{ $isCurrentClass ? 'text-green-700' : 'text-gray-700' }}">
                                                {{ $jadwal->ruangan->nama ?? 'Ruang Default' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-primary-50 h-20 w-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Hari Libur!</h3>
                            <p class="text-gray-500 text-sm max-w-sm mx-auto">
                                Tidak ada jadwal pelajaran untuk hari {{ $today }}. Nikmati waktu istirahatmu!
                            </p>
                        </div>
                    @endif
                </div>
                
                <!-- Weekly Schedule Tabs -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100" x-data="{ activeDay: '{{ now()->locale('id')->dayName }}' }">
                    <div class="px-4 py-3 bg-gradient-to-r from-primary-50 to-white border-b border-gray-100">
                        <h2 class="text-base font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Jadwal Pelajaran Mingguan
                        </h2>
                    </div>
                    
                    <!-- Day Tabs - Scrollable on mobile -->
                    <div class="border-b border-gray-200 overflow-x-auto schedule-tabs">
                        <div class="flex whitespace-nowrap" aria-label="Tabs">
                            @php
                                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            @endphp

                            @foreach($days as $hari)
                                <button 
                                    @click="activeDay = '{{ $hari }}'"
                                    class="py-3 px-5 text-center border-b-2 transition-colors duration-200 text-sm font-medium"
                                    :class="activeDay === '{{ $hari }}' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                >
                                    <span class="inline-flex items-center">
                                        <span class="w-2 h-2 rounded-full mr-1.5" :class="activeDay === '{{ $hari }}' ? 'bg-primary-500' : 'bg-transparent'"></span>
                                        {{ $hari }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Schedule Content -->
                    @foreach($days as $hari)
                        <div 
                            x-show="activeDay === '{{ $hari }}'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            class="max-h-96 overflow-y-auto"
                        >
                            @if(isset($jadwalPerHari[$hari]) && $jadwalPerHari[$hari]->count() > 0)
                                <div class="divide-y divide-gray-100">
                                    @foreach($jadwalPerHari[$hari]->sortBy('waktu_mulai') as $jadwal)
                                        <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                            <div class="flex justify-between items-start mb-2">
                                                <div class="font-medium text-sm text-gray-900">
                                                    {{ $jadwal->mata_pelajaran }}
                                                </div>
                                                <div class="text-xs font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">
                                                    {{ Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - 
                                                    {{ Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                                </div>
                                            </div>
                                            <div class="flex justify-between items-end">
                                                <div class="flex items-center">
                                                    <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs text-gray-900 font-medium">
                                                            {{ $jadwal->guru->nama_lengkap }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                    </div>
                                                    <div class="text-xs text-gray-700">
                                                        {{ $jadwal->ruangan->nama ?? 'Ruang Default' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <p class="text-gray-500 text-sm mt-2">Tidak ada jadwal pelajaran untuk hari {{ $hari }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <!-- Upcoming Assignments -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-4 py-3 bg-gradient-to-r from-primary-50 to-white border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-base font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Tugas Mendatang
                        </h2>
                        <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Lihat Semua</a>
                    </div>
                    
                    <div class="p-4">
                        <!-- This is a placeholder. In a real app, you would loop through upcoming assignments -->
                        <div class="space-y-3">
                            <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-lg bg-red-100 flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-medium text-gray-800">Matematika - Tugas Trigonometri</h4>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 ml-11">Bab 4 - Halaman 45-47</p>
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
                            
                            <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-lg bg-yellow-100 flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-medium text-gray-800">Bahasa Indonesia - Esai Sastra</h4>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 ml-11">Analisis Novel "Laskar Pelangi"</p>
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
                            
                            <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-medium text-gray-800">Fisika - Laporan Praktikum</h4>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 ml-11">Hukum Newton tentang Gerak</p>
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
            </div>
            
            <!-- Right Column (1/3 width on desktop) -->
            <div class="space-y-6">
                <!-- Attendance History -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-4 py-3 bg-gradient-to-r from-primary-50 to-white border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-base font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Riwayat Absensi
                        </h2>
                        <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Lihat Semua</a>
                    </div>
                    
                    <div class="p-4">
                        <div class="space-y-3">
                            @forelse($absensi->take(5) as $data)
                                <div class="bg-white rounded-lg p-3 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-sm mt-2">Belum ada data absensi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Announcements -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-4 py-3 bg-gradient-to-r from-primary-50 to-white border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-base font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                            Pengumuman
                        </h2>
                        <a href="#" class="text-xs text-primary-600 font-medium hover:underline">Lihat Semua</a>
                    </div>
                    
                    <div class="p-4">
                        <div class="space-y-3">
                            @forelse($pengumuman->take(3) as $item)
                                <div class="bg-white rounded-lg p-3 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <h4 class="text-sm font-medium text-gray-800">{{ $item->judul }}</h4>
                                    <div class="flex items-center mt-1.5 text-xs text-gray-500">
                                        <span class="px-2 py-0.5 rounded-full bg-primary-100 text-primary-700 mr-2">{{ $item->kategori }}</span>
                                        <span>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-2 line-clamp-2">{{ $item->isi }}</p>
                                    <div class="mt-2 flex justify-between items-center">
                                        <a a href="{{ asset('storage/' . $pengumuman->first()->lampiran) }}" download class="text-xs text-primary-600 font-medium hover:underline">Download</a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                    </svg>
                                    <p class="text-gray-500 text-sm mt-2">Belum ada pengumuman</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Student ID Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-4 py-3 bg-gradient-to-r from-primary-50 to-white border-b border-gray-100">
                        <h2 class="text-base font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            Kartu Pelajar
                        </h2>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex flex-col space-y-3">
                            <a href="{{ route('siswa.cetak-kartu-pelajar') }}" target="_blank" 
                               class="flex items-center justify-between p-3 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors duration-200">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-lg bg-primary-100 flex items-center justify-center mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-800">Cetak Kartu Pelajar</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">Kartu identitas resmi</p>
                                    </div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                            
                            <a href="{{ route('siswa.cetak-data-siswa') }}" target="_blank" 
                               class="flex items-center justify-between p-3 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors duration-200">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-lg bg-primary-100 flex items-center justify-center mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-800">Cetak Data Siswa</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">Informasi lengkap siswa</p>
                                    </div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
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
        // Alpine.js data and functions can be added here if needed
    });
</script>
@endpush
@endsection