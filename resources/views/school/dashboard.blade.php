@extends('layouts.app')

@section('content')
<div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with enhanced gradient background -->
        <div class="bg-gradient-to-r from-blue-600 via-blue-600 to-blue-700 rounded-2xl p-8 shadow-lg mb-8 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-full h-full opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round" class="text-white w-64 h-64 absolute -right-16 -top-16 transform rotate-12">
                    <path d="M12 3L1 9L12 15L21 10.09V17C21 17.5304 20.7893 18.0391 20.4142 18.4142C20.0391 18.7893 19.5304 19 19 19H5C4.46957 19 3.96086 18.7893 3.58579 18.4142C3.21071 18.0391 3 17.5304 3 17V9L12 3Z" />
                </svg>
            </div>
            <div class="flex items-center gap-6 relative z-10">
                <div class="flex-shrink-0">
                    @if($sekolah->foto)
                    <img src="{{ asset('storage/' . $sekolah->foto) }}" alt="Foto {{ $sekolah->nama_sekolah }}" class="w-20 h-20 rounded-xl shadow-md border-2 border-white/30 object-cover">
                    @else
                    <div class="w-20 h-20 rounded-xl bg-white/20 flex items-center justify-center text-white text-3xl font-bold">
                        {{ substr($sekolah->nama_sekolah, 0, 1) }}
                    </div>
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                            <path d="M6 12v5c0 2 1 3 3 3h6c2 0 3-1 3-3v-5"/>
                        </svg>
                        Dashboard Sekolah
                    </h1>
                    <h2 class="text-xl font-medium text-blue-100 mb-2">{{ $sekolah->nama_sekolah }}</h2>
                    <div id="clock" class="text-lg text-white font-mono bg-white/10 px-4 py-2 rounded-lg inline-flex items-center"></div>
                </div>
            </div>
        </div>

        <script>
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const timeString = `${hours}:${minutes}:${seconds}`;
                document.getElementById('clock').textContent = `🕒 ${timeString}`;
            }

            setInterval(updateClock, 1000);
            updateClock(); // initial call to display immediately
        </script>

        <!-- Stats Cards with enhanced design -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Students Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-blue-100 group">
                <div class="px-6 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-3 shadow-md group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Siswa</dt>
                                <dd class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-600 bg-clip-text text-transparent">{{ $totalSiswa }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-blue-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('school.students') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 flex items-center group">
                            Lihat semua siswa
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Teachers Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-blue-100 group">
                <div class="px-6 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-3 shadow-md group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Guru</dt>
                                <dd class="text-3xl font-bold bg-gradient-to-r from-blue  -600 to-blue-600 bg-clip-text text-transparent">{{ $totalGuru }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-blue-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('adminguru.index') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 flex items-center group">
                            Lihat semua guru
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Classes Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-blue-100 group">
                <div class="px-6 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-3 shadow-md group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Kelas</dt>
                                <dd class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-600 bg-clip-text text-transparent">{{ $totalKelas }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-blue-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('kelassekolah.index') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 flex items-center group">
                            Lihat semua kelas
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Capacity Utilization Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-blue-100 group">
                <div class="px-6 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg p-3 shadow-md group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Kapasitas Terpakai</dt>
                                <dd class="text-3xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
                                    @php
                                    $totalKapasitas = $kelasUtilization->sum('kapasitas');
                                    $totalTerpakai = $kelasUtilization->sum(function($kelas) {
                                    return $kelas->kapasitas - $kelas->sisa_kapasitas;
                                    });
                                    $percentUsed = $totalKapasitas > 0 ? round(($totalTerpakai / $totalKapasitas) * 100) : 0;
                                    @endphp
                                    {{ $percentUsed }}%
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-blue-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('school.classes.capacity') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 flex items-center group">
                            Lihat kapasitas kelas
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Tables Section with enhanced design -->
        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Student Distribution by Gender -->
            <div class="bg-white shadow-md rounded-xl p-6 transition-all duration-300 hover:shadow-xl border border-blue-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-gradient-to-br from-blue-100 to-blue-100 rounded-full opacity-30"></div>
                <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Distribusi Siswa Berdasarkan Jenis Kelamin
                </h3>
                <div class="mt-4 h-64 bg-gradient-to-br from-blue-50 to-blue-50 p-4 rounded-lg shadow-inner">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <!-- Class Distribution by Grade -->
            <div class="bg-white shadow-md rounded-xl p-6 transition-all duration-300 hover:shadow-xl border border-blue-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-gradient-to-br from-blue-100 to-blue-100 rounded-full opacity-30"></div>
                <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Distribusi Kelas Berdasarkan Tingkat
                </h3>
                <div class="mt-4 h-64 bg-gradient-to-br from-blue-50 to-blue-50 p-4 rounded-lg shadow-inner">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>

            <!-- Teacher Distribution by Status -->
            <div class="bg-white shadow-md rounded-xl p-6 transition-all duration-300 hover:shadow-xl border border-blue-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-gradient-to-br from-blue  -100 to-blue-100 rounded-full opacity-30"></div>
                <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue -600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Distribusi Guru Berdasarkan Status Kepegawaian
                </h3>
                <div class="mt-4 h-64 bg-gradient-to-br from-blue -50 to-blue-50 p-4 rounded-lg shadow-inner">
                    <canvas id="teacherStatusChart"></canvas>
                </div>
            </div>

            <!-- Class Capacity Utilization -->
            <div class="bg-white shadow-md rounded-xl p-6 transition-all duration-300 hover:shadow-xl border border-blue-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-full opacity-30"></div>
                <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Utilisasi Kapasitas Kelas
                </h3>
                <div class="mt-4 h-64 bg-gradient-to-br from-cyan-50 to-blue-50 p-4 rounded-lg shadow-inner">
                    <canvas id="capacityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Records Section with enhanced design -->
        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Recent Students -->
            <div class="bg-white shadow-md rounded-xl transition-all duration-300 hover:shadow-xl border border-blue-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-blue-100 bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-white">Siswa Terbaru</h3>
                </div>
                <div class="divide-y divide-blue-100">
                    @foreach($latestSiswa as $siswa)
                    <div class="px-6 py-4 transition-colors duration-300 hover:bg-blue-50 group">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                @if($siswa->foto)
                                <img class="h-12 w-12 rounded-full object-cover border-2 border-blue-200 shadow-sm group-hover:border-blue-400 transition-all duration-300" src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                @else
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white font-bold shadow-sm">
                                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                                </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-blue-800">
                                    <a href="{{ route('school.student.show', $siswa->id) }}" class="hover:text-blue-600 transition-colors duration-300">{{ $siswa->nama_lengkap }}</a>
                                </div>
                                <div class="text-sm text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    NISN: {{ $siswa->nisn }} | 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mx-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Kelas: {{ $siswa->kelas->nama_kelas }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-blue-50 px-6 py-4 text-right rounded-b-xl">
                    <a href="{{ route('school.students') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 inline-flex items-center group">
                        Lihat semua siswa
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Recent Teachers -->
            <div class="bg-white shadow-md rounded-xl transition-all duration-300 hover:shadow-xl border border-blue-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-blue-100 bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-white">Guru Terbaru</h3>
                </div>
                <div class="divide-y divide-blue-100">
                    @foreach($latestGuru as $guru)
                    <div class="px-6 py-4 transition-colors duration-300 hover:bg-blue-50 group">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                @if($guru->foto)
                                <img class="h-12 w-12 rounded-full object-cover border-2 border-blue-200 shadow-sm group-hover:border-blue-400 transition-all duration-300" src="{{ asset('storage/guru-photos/' . $guru->foto) }}" alt="{{ $guru->nama_lengkap }}">
                                @else
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white font-bold shadow-sm">
                                    {{ substr($guru->nama_lengkap, 0, 1) }}
                                </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-blue-800">
                                    <a href="{{ route('school.teacher.show', $guru->id) }}" class="hover:text-blue-600 transition-colors duration-300">{{ $guru->nama_lengkap }}</a>
                                </div>
                                <div class="text-sm text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-blue -500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    @php
                                    $mapelArray = is_array($guru->mata_pelajaran) ? $guru->mata_pelajaran : json_decode($guru->mata_pelajaran, true);
                                    $mapelString = implode(', ', array_slice($mapelArray, 0, 2));
                                    if (count($mapelArray) > 2) {
                                    $mapelString .= ' +' . (count($mapelArray) - 2);
                                    }
                                    @endphp
                                    {{ $guru->status_kepegawaian }} | {{ $mapelString }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-blue-50 px-6 py-4 text-right rounded-b-xl">
                    <a href="{{ route('school.teachers') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 inline-flex items-center group">
                        Lihat semua guru
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced color palette for charts
        const blueColors = [
            'rgba(37, 99, 235, 0.8)',   // blue-600
            'rgba(79, 70, 229, 0.8)',   // blue-600
            'rgba(124, 58, 237, 0.8)',  // blue   -600
            'rgba(147, 51, 234, 0.8)',  // blue-600
            'rgba(6, 182, 212, 0.8)',   // cyan-500
        ];
        
        const blueColorsBorders = [
            'rgba(37, 99, 235, 1)',   // blue-600
            'rgba(79, 70, 229, 1)',   // blue-600
            'rgba(124, 58, 237, 1)',  // blue -600
            'rgba(147, 51, 234, 1)',  // blue-600
            'rgba(6, 182, 212, 1)',   // cyan-500
        ];

        // Enhanced animation options
        const animationOptions = {
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            family: 'Inter, system-ui, sans-serif',
                            size: 12
                        },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.8)',
                    titleFont: {
                        family: 'Inter, system-ui, sans-serif',
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: 'Inter, system-ui, sans-serif',
                        size: 13
                    },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    boxPadding: 6,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        }
                    }
                }
            }
        };

        // Gender distribution chart
        const genderData = @json($siswaByGender);
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: genderData.map(item => item.jenis_kelamin === 'laki-laki' ? 'Laki-laki' : 'Perempuan'),
                datasets: [{
                    data: genderData.map(item => item.total),
                    backgroundColor: [blueColors[0], blueColors[1]],
                    borderColor: [blueColorsBorders[0], blueColorsBorders[1]],
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                ...animationOptions,
                cutout: '60%'
            }
        });

        // Grade distribution chart
        const gradeData = @json($kelasByTingkat);
        const gradeCtx = document.getElementById('gradeChart').getContext('2d');
        new Chart(gradeCtx, {
            type: 'bar',
            data: {
                labels: gradeData.map(item => 'Tingkat ' + item.tingkat),
                datasets: [{
                    label: 'Jumlah Kelas',
                    data: gradeData.map(item => item.total),
                    backgroundColor: blueColors[2],
                    borderColor: blueColorsBorders[2],
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: blueColors[0]
                }]
            },
            options: {
                ...animationOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.6)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Teacher status chart
        const teacherData = @json($guruByStatus);
        const teacherCtx = document.getElementById('teacherStatusChart').getContext('2d');
        new Chart(teacherCtx, {
            type: 'pie',
            data: {
                labels: teacherData.map(item => item.status_kepegawaian),
                datasets: [{
                    data: teacherData.map(item => item.total),
                    backgroundColor: blueColors,
                    borderColor: blueColorsBorders,
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                ...animationOptions,
                plugins: {
                    ...animationOptions.plugins,
                    legend: {
                        ...animationOptions.plugins.legend,
                        position: 'right'
                    }
                }
            }
        });

        // Class capacity utilization chart
        const capacityData = @json($kelasUtilization);
        const capacityCtx = document.getElementById('capacityChart').getContext('2d');
        new Chart(capacityCtx, {
            type: 'bar',
            data: {
                labels: capacityData.map(item => item.nama_kelas),
                datasets: [{
                    label: 'Kapasitas Terpakai (%)',
                    data: capacityData.map(item => item.utilization),
                    backgroundColor: capacityData.map(item => {
                        // Color based on utilization percentage with blue theme
                        if (item.utilization < 50) return 'rgba(6, 182, 212, 0.7)';  // cyan-500
                        if (item.utilization < 75) return 'rgba(37, 99, 235, 0.7)';  // blue-600
                        if (item.utilization < 90) return 'rgba(79, 70, 229, 0.7)';  // blue-600
                        return 'rgba(124, 58, 237, 0.7)'; // blue -600
                    }),
                    borderColor: 'rgba(219, 234, 254, 0.8)', // blue-100
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.6
                }]
            },
            options: {
                ...animationOptions,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.6)'
                        },
                        title: {
                            display: true,
                            text: 'Persentase Kapasitas Terpakai',
                            font: {
                                family: 'Inter, system-ui, sans-serif',
                                size: 12
                            }
                        }
                    },
                    y: {
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const item = capacityData[context.dataIndex];
                                return `${context.formattedValue}% (${item.kapasitas - item.sisa_kapasitas}/${item.kapasitas})`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    /* Enhanced custom styles for modern appearance */
    body {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    /* Smooth hover transitions for all interactive elements */
    a, button {
        transition: all 0.3s ease;
    }
    
    /* Enhanced card hover effects with subtle shadows */
    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(37, 99, 235, 0.04);
    }
    
    /* Gradient text for headings */
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        background-image: linear-gradient(to right, #2563eb, #4f46e5);
    }
    
    /* Pulse animation for important stats */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }
    
    .animate-pulse-slow {
        animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Enhanced scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #93c5fd;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #60a5fa;
    }
    
    /* Card hover effects */
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
    }
    
    /* Gradient backgrounds for sections */
    .bg-gradient-section {
        background-image: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    }
    
    /* Improved focus styles for accessibility */
    a:focus, button:focus {
        outline: 2px solid rgba(59, 130, 246, 0.5);
        outline-offset: 2px;
    }
    
    /* Glass morphism effect for cards */
    .glass-effect {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
</style>

@endsection
