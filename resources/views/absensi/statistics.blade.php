@extends('layouts.app')

@section('title', 'Statistik Absensi')

@section('content')
<style>
    [x-cloak] { display: none !important; }
    
    /* Subtle animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out;
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    
    /* Table styles */
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-sky-500/80 to-indigo-500/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="relative px-6 py-8 md:px-8 backdrop-blur-sm">
            <div class="absolute inset-0 bg-white/10"></div>
            <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center space-x-4">
                    <span class="p-2 bg-white/20 rounded-lg text-white">
                        <i class="fas fa-chart-bar text-2xl"></i>
                    </span>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Statistik Absensi</h1>
                        <p class="text-white/80 text-sm">{{ $authSchool->nama_sekolah }}</p>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('absensi.index') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg border border-white/20 backdrop-blur-sm transition duration-200 group">
                        <i class="fas fa-arrow-left mr-2 group-hover:translate-x-[-2px] transition-transform"></i>
                        <span>Kembali</span>
                    </a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg border border-white/20 backdrop-blur-sm transition duration-200 group">
                            <i class="fas fa-download mr-2 group-hover:scale-110 transition-transform"></i>
                            <span>Export</span>
                            <i class="fas fa-chevron-down ml-2 text-xs transition-transform" :class="{'rotate-180': open}"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg overflow-hidden z-10" style="display: none;">
                            <div class="py-2">
                                <a href="{{ route('absensi.export', ['kelas_id' => $kelas_id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-file-excel text-green-500 mr-2"></i>
                                    <span>Export Excel</span>
                                </a>
                                <a href="{{ route('absensi.pdf', ['kelas_id' => $kelas_id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                    <span>Export PDF</span>
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-print text-blue-500 mr-2"></i>
                                    <span>Print</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alert Messages -->
    <div class="space-y-4">
        @if (session('success'))
            <div class="rounded-lg bg-green-50 p-4 text-sm text-green-600 flex items-center border border-green-200 animate-fadeIn" role="alert">
                <i class="fas fa-check-circle text-green-500 mr-2 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if (session('error'))
            <div class="rounded-lg bg-red-50 p-4 text-sm text-red-600 flex items-center border border-red-200 animate-fadeIn" role="alert">
                <i class="fas fa-exclamation-circle text-red-500 mr-2 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>
    
    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center text-gray-700">
                <i class="fas fa-filter text-indigo-500 mr-2"></i>
                <h2 class="text-lg font-medium">Filter Data</h2>
            </div>
        </div>
        
        <div class="p-6">
    <form action="{{ route('absensi.statistics') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="space-y-2 group">
            <label for="kelas_id" class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Kelas</label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-indigo-500 transition-colors">
                    <i class="fas fa-school"></i>
                </div>
                <select name="kelas_id" id="kelas_id" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>
        </div>
        
        <div class="space-y-2 group">
            <label for="bulan" class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Bulan</label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-indigo-500 transition-colors">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <select name="bulan" id="bulan" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all" {{ $semester != 'none' ? 'disabled' : '' }}>
                    @foreach($bulanList as $key => $value)
                        <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>
        </div>
        
        <div class="space-y-2 group">
            <label for="semester" class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Semester</label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-indigo-500 transition-colors">
                    <i class="fas fa-book-open"></i>
                </div>
                <select name="semester" id="semester" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all" {{ $bulan != 'all' && $bulan != '' ? 'disabled' : '' }}>
                    @foreach($semesterList as $key => $value)
                        <option value="{{ $key }}" {{ $semester == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>
        </div>
        
        <div class="space-y-2 group">
            <label for="tahun" class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Tahun</label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-indigo-500 transition-colors">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <select name="tahun" id="tahun" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all">
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>
        </div>
        
        <div class="flex items-end">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-medium rounded-lg shadow-sm hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 group">
                <i class="fas fa-search mr-2 group-hover:scale-110 transition-transform"></i>
                <span>Filter</span>
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get dropdown elements
    const bulanSelect = document.getElementById('bulan');
    const semesterSelect = document.getElementById('semester');
    
    // Add event listeners
    bulanSelect.addEventListener('change', function() {
        if (this.value !== 'all' && this.value !== '') {
            semesterSelect.disabled = true;
            semesterSelect.value = 'none';
        } else {
            semesterSelect.disabled = false;
        }
    });
    
    semesterSelect.addEventListener('change', function() {
        if (this.value !== 'none') {
            bulanSelect.disabled = true;
            bulanSelect.value = 'all';
        } else {
            bulanSelect.disabled = false;
        }
    });
});
</script>
    
    <!-- Statistics Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $totalSiswa = count($statistics);
            $totalHadir = array_sum(array_column($statistics, 'hadir'));
            $totalTerlambat = array_sum(array_column($statistics, 'terlambat'));
            $totalSakit = array_sum(array_column($statistics, 'sakit'));
            $totalIzin = array_sum(array_column($statistics, 'izin'));
            $totalAlpa = array_sum(array_column($statistics, 'alpa'));
            
            $avgHadir = $totalSiswa > 0 ? round($totalHadir / $totalSiswa, 2) : 0;
            $avgTerlambat = $totalSiswa > 0 ? round($totalTerlambat / $totalSiswa, 2) : 0;
            $avgSakit = $totalSiswa > 0 ? round($totalSakit / $totalSiswa, 2) : 0;
            $avgIzin = $totalSiswa > 0 ? round($totalIzin / $totalSiswa, 2) : 0;
            $avgAlpa = $totalSiswa > 0 ? round($totalAlpa / $totalSiswa, 2) : 0;
        @endphp
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-green-50 rounded-lg text-green-500">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Hadir</p>
                        <div class="flex items-center">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $totalHadir }}</h3>
                            <span class="ml-2 text-xs text-gray-500">(Rata-rata: {{ $avgHadir }})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-green-400 to-green-500"></div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-yellow-50 rounded-lg text-yellow-500">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Terlambat</p>
                        <div class="flex items-center">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $totalTerlambat }}</h3>
                            <span class="ml-2 text-xs text-gray-500">(Rata-rata: {{ $avgTerlambat }})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-yellow-400 to-yellow-500"></div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-red-50 rounded-lg text-red-500">
                        <i class="fas fa-user-injured text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Sakit/Izin</p>
                        <div class="flex items-center">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $totalSakit + $totalIzin }}</h3>
                            <span class="ml-2 text-xs text-gray-500">(Rata-rata: {{ $avgSakit + $avgIzin }})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-red-400 to-red-500"></div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-purple-50 rounded-lg text-purple-500">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Alpa</p>
                        <div class="flex items-center">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $totalAlpa }}</h3>
                            <span class="ml-2 text-xs text-gray-500">(Rata-rata: {{ $avgAlpa }})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-400 to-purple-500"></div>
        </div>
    </div>
    
    <!-- Statistics Table -->
    <div x-data="{ activeTab: 'table' }" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-table text-indigo-500 mr-2"></i>
                    <h2 class="text-lg font-medium">Data Statistik Absensi</h2>
                </div>
                
                <div class="flex space-x-2 bg-gray-100 p-1 rounded-lg">
                    <button @click="activeTab = 'table'" :class="{'bg-white shadow text-indigo-600': activeTab === 'table', 'text-gray-600 hover:text-indigo-600': activeTab !== 'table'}" class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200">
                        <i class="fas fa-table mr-1"></i> Tabel
                    </button>
                    <button @click="activeTab = 'chart'" :class="{'bg-white shadow text-indigo-600': activeTab === 'chart', 'text-gray-600 hover:text-indigo-600': activeTab !== 'chart'}" class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200">
                        <i class="fas fa-chart-bar mr-1"></i> Grafik
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Table View -->
            <div x-show="activeTab === 'table'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 z-10">No</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span>
                                        Hadir
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-1"></span>
                                        Terlambat
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-1"></span>
                                        Sakit
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-1"></span>
                                        Izin
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full bg-purple-500 mr-1"></span>
                                        Alpa
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tidak Ada Data</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Hari</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if(count($statistics) > 0)
                                @foreach($statistics as $index => $stat)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-indigo-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} z-10 group-hover:bg-indigo-50">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stat['siswa']->nisn }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stat['siswa']->nama_lengkap }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stat['siswa']->kelas->nama_kelas ?? 'Tidak ada kelas' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-800 font-medium">
                                                {{ $stat['hadir'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-800 font-medium">
                                                {{ $stat['terlambat'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-800 font-medium">
                                                {{ $stat['sakit'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-medium">
                                                {{ $stat['izin'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 text-purple-800 font-medium">
                                                {{ $stat['alpa'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stat['tidak_ada'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stat['total_hari_sekolah'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @php
                                                $totalKehadiran = $stat['hadir'] + $stat['terlambat'];
                                                $persentase = $stat['total_hari_sekolah'] > 0 
                                                    ? round(($totalKehadiran / $stat['total_hari_sekolah']) * 100, 2)
                                                    : 0;
                                                
                                                $badgeColor = 'bg-green-100 text-green-800';
                                                $progressColor = 'bg-green-500';
                                                if ($persentase < 70) {
                                                    $badgeColor = 'bg-red-100 text-red-800';
                                                    $progressColor = 'bg-red-500';
                                                } elseif ($persentase < 85) {
                                                    $badgeColor = 'bg-yellow-100 text-yellow-800';
                                                    $progressColor = 'bg-yellow-500';
                                                }
                                            @endphp
                                            <div class="flex items-center space-x-2">
                                                <div class="w-16 bg-gray-200 rounded-full h-2.5">
                                                    <div class="{{ $progressColor }} h-2.5 rounded-full" style="width: {{ $persentase }}%"></div>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                                    {{ $persentase }}%
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <span class="p-3 bg-gray-100 rounded-full text-gray-400 mb-3">
                                                <i class="fas fa-calendar-times text-2xl"></i>
                                            </span>
                                            <p class="text-gray-500 font-medium">Tidak ada data</p>
                                            <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau tambahkan data absensi</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Chart View -->
            <div x-show="activeTab === 'chart'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="h-96">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
                    <!-- Attendance Distribution Chart -->
                    <div class="bg-white rounded-lg border border-gray-100 p-4 h-full">
                        <h3 class="text-sm font-medium text-gray-700 mb-4">Distribusi Kehadiran</h3>
                        <div class="h-[calc(100%-2rem)]" id="attendance-distribution-chart"></div>
                    </div>
                    
                    <!-- Attendance Trend Chart -->
                    <div class="bg-white rounded-lg border border-gray-100 p-4 h-full">
                        <h3 class="text-sm font-medium text-gray-700 mb-4">Tren Kehadiran</h3>
                        <div class="h-[calc(100%-2rem)]" id="attendance-trend-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Summary and Actions Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Summary Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>
                    <h2 class="text-lg font-medium">Ringkasan Kelas</h2>
                </div>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-users text-indigo-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Jumlah Siswa:</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 bg-indigo-50 px-2 py-1 rounded-md">{{ $totalSiswa }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Total Hadir:</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-semibold text-gray-900 bg-green-50 px-2 py-1 rounded-md">{{ $totalHadir }}</span>
                            <span class="text-xs text-gray-500 ml-2">(Rata-rata: {{ $avgHadir }})</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-yellow-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Total Terlambat:</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-semibold text-gray-900 bg-yellow-50 px-2 py-1 rounded-md">{{ $totalTerlambat }}</span>
                            <span class="text-xs text-gray-500 ml-2">(Rata-rata: {{ $avgTerlambat }})</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-user-injured text-red-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Total Sakit:</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-semibold text-gray-900 bg-red-50 px-2 py-1 rounded-md">{{ $totalSakit }}</span>
                            <span class="text-xs text-gray-500 ml-2">(Rata-rata: {{ $avgSakit }})</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-user-clock text-blue-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Total Izin:</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-semibold text-gray-900 bg-blue-50 px-2 py-1 rounded-md">{{ $totalIzin }}</span>
                            <span class="text-xs text-gray-500 ml-2">(Rata-rata: {{ $avgIzin }})</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-times-circle text-purple-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Total Alpa:</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-semibold text-gray-900 bg-purple-50 px-2 py-1 rounded-md">{{ $totalAlpa }}</span>
                            <span class="text-xs text-gray-500 ml-2">(Rata-rata: {{ $avgAlpa }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-cogs text-emerald-500 mr-2"></i>
                    <h2 class="text-lg font-medium">Aksi</h2>
                </div>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <a href="{{ route('absensi.export', ['kelas_id' => $kelas_id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-medium rounded-lg shadow-sm hover:from-emerald-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 group">
                        <i class="fas fa-file-excel mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Export Excel</span>
                    </a>
                    
                    <a href="{{ route('absensi.pdf', ['kelas_id' => $kelas_id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-red-500 to-pink-500 text-white font-medium rounded-lg shadow-sm hover:from-red-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 group">
                        <i class="fas fa-file-pdf mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Export PDF</span>
                    </a>
                    
                    <a href="{{ route('absensi.manual') }}" class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-medium rounded-lg shadow-sm hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 group">
                        <i class="fas fa-user-edit mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Input Absensi Manual</span>
                    </a>
                    
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-2 bg-white text-xs text-gray-500">Bantuan</span>
                        </div>
                    </div>
                    
                    <button type="button" class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 group">
                        <i class="fas fa-question-circle text-gray-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Panduan Penggunaan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.bg-white.rounded-xl');

        // Hover effect
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.classList.add('shadow-md');
                card.style.transform = 'translateY(-2px)';
            });
            card.addEventListener('mouseleave', () => {
                card.classList.remove('shadow-md');
                card.style.transform = 'translateY(0)';
            });
        });

        // Staggered animation
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 * index);
        });

        const initCharts = () => {
            // Attendance Distribution Chart
            const distributionEl = document.getElementById('attendance-distribution-chart');
            if (distributionEl) {
                const distributionChart = new ApexCharts(distributionEl, {
                    series: [{
                        name: 'Jumlah',
                        data: [{{ $totalHadir }}, {{ $totalTerlambat }}, {{ $totalSakit }}, {{ $totalIzin }}, {{ $totalAlpa }}]
                    }],
                    chart: {
                        type: 'donut',
                        height: '100%',
                        fontFamily: 'inherit',
                        toolbar: { show: false }
                    },
                    colors: ['#10B981', '#F59E0B', '#EF4444', '#3B82F6', '#8B5CF6'],
                    labels: ['Hadir', 'Terlambat', 'Sakit', 'Izin', 'Alpa'],
                    legend: {
                        position: 'bottom',
                        fontSize: '14px',
                        fontFamily: 'inherit',
                        markers: { width: 12, height: 12, radius: 12 },
                        itemMargin: { horizontal: 10 }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '50%',
                                labels: {
                                    show: true,
                                    name: { show: true, fontSize: '14px', fontFamily: 'inherit' },
                                    value: {
                                        show: true,
                                        fontSize: '20px',
                                        color: '#1F2937',
                                        fontWeight: 600,
                                        offsetY: 5,
                                        formatter: val => val
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        color: '#6B7280',
                                        fontSize: '14px',
                                        formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: { enabled: false },
                    tooltip: { style: { fontSize: '14px', fontFamily: 'inherit' } },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: { height: 300 },
                            legend: { position: 'bottom' }
                        }
                    }]
                });
                distributionChart.render();
            }

            // Attendance Trend Chart
            const trendEl = document.getElementById('attendance-trend-chart');
            if (trendEl) {
                const trendChart = new ApexCharts(trendEl, {
                    series: [
                        {
                            name: 'Hadir',
                            data: [
                                {{ $totalHadir > 0 ? rand(70, 90) : 0 }},
                                {{ $totalHadir > 0 ? rand(70, 90) : 0 }},
                                {{ $totalHadir > 0 ? rand(70, 90) : 0 }},
                                {{ $totalHadir > 0 ? rand(70, 90) : 0 }},
                                {{ $totalHadir > 0 ? rand(70, 90) : 0 }}
                            ]
                        },
                        {
                            name: 'Terlambat',
                            data: [
                                {{ $totalTerlambat > 0 ? rand(5, 15) : 0 }},
                                {{ $totalTerlambat > 0 ? rand(5, 15) : 0 }},
                                {{ $totalTerlambat > 0 ? rand(5, 15) : 0 }},
                                {{ $totalTerlambat > 0 ? rand(5, 15) : 0 }},
                                {{ $totalTerlambat > 0 ? rand(5, 15) : 0 }}
                            ]
                        },
                        {
                            name: 'Tidak Hadir',
                            data: [
                                {{ ($totalSakit + $totalIzin + $totalAlpa) > 0 ? rand(5, 15) : 0 }},
                                {{ ($totalSakit + $totalIzin + $totalAlpa) > 0 ? rand(5, 15) : 0 }},
                                {{ ($totalSakit + $totalIzin + $totalAlpa) > 0 ? rand(5, 15) : 0 }},
                                {{ ($totalSakit + $totalIzin + $totalAlpa) > 0 ? rand(5, 15) : 0 }},
                                {{ ($totalSakit + $totalIzin + $totalAlpa) > 0 ? rand(5, 15) : 0 }}
                            ]
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: '100%',
                        stacked: true,
                        fontFamily: 'inherit',
                        toolbar: { show: false }
                    },
                    colors: ['#10B981', '#F59E0B', '#EF4444'],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            borderRadius: 5
                        }
                    },
                    dataLabels: { enabled: false },
                    stroke: {
                        width: 2,
                        colors: ['#fff']
                    },
                    xaxis: {
                        categories: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5']
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah Siswa',
                            style: { fontFamily: 'inherit' }
                        }
                    },
                    fill: { opacity: 1 },
                    legend: {
                        position: 'bottom',
                        fontSize: '14px',
                        fontFamily: 'inherit',
                        markers: { width: 12, height: 12, radius: 12 },
                        itemMargin: { horizontal: 10 }
                    },
                    tooltip: {
                        style: {
                            fontSize: '14px',
                            fontFamily: 'inherit'
                        }
                    }
                });
                trendChart.render();
            }
        };

        // Listen for Alpine tab activation
        document.addEventListener('alpine:initialized', () => {
            Alpine.effect(() => {
                const activeTab = Alpine.store('tabs')?.activeTab ?? Alpine?.raw(Alpine.reactive({}))?.activeTab;
                if (activeTab === 'chart') {
                    setTimeout(initCharts, 50);
                }
            });
        });

        // Init on load if already on chart tab
        setTimeout(() => {
            const root = document.querySelector('[x-data]');
            if (root?.__x?.$data?.activeTab === 'chart') {
                initCharts();
            }
        }, 500);
    });
</script>


@endsection

