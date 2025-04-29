@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<style>
    [x-cloak] { display: none !important; }
    
    /* Subtle animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
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
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-sky-500/80 to-blue-500/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="relative px-6 py-8 md:px-8 backdrop-blur-sm">
            <div class="absolute inset-0 bg-white/10"></div>
            <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center space-x-4">
                    <span class="p-2 bg-white/20 rounded-lg text-white">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </span>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Data Absensi</h1>
                        <p class="text-white/80 text-sm">{{ $authSchool->nama }}</p>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('absensi.manual') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg border border-white/20 backdrop-blur-sm transition duration-200 group">
                        <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Input Manual</span>
                    </a>
                    <a href="{{ route('absensi.statistics') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg border border-white/20 backdrop-blur-sm transition duration-200 group">
                        <i class="fas fa-chart-bar mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Statistik</span>
                    </a>
                    <div class="relative" x-data="{ open: false }">
                        <button id="exportBtn" @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg border border-white/20 backdrop-blur-sm transition duration-200 group">
                            <i class="fas fa-download mr-2 group-hover:scale-110 transition-transform"></i>
                            <span>Export</span>
                            <i class="fas fa-chevron-down ml-2 text-xs transition-transform" :class="{'rotate-180': open}"></i>
                        </button>
                        <div id="exportMenu" x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg overflow-hidden z-10" style="display: none;">
                            <div class="py-2">
                                <a href="{{ route('absensi.export', ['format' => 'excel']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-file-excel text-green-500 mr-2"></i>
                                    <span>Export Excel</span>
                                </a>
                                <a href="{{ route('absensi.export', ['format' => 'pdf']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                    <span>Export PDF</span>
                                </a>
                                <a href="{{ route('absensi.export', ['format' => 'csv']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-file-csv text-blue-500 mr-2"></i>
                                    <span>Export CSV</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center text-gray-700">
                <i class="fas fa-filter text-blue-500 mr-2"></i>
                <h2 class="text-lg font-medium">Filter Data</h2>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('absensi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2 group">
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Kelas</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                            <i class="fas fa-school"></i>
                        </div>
                        <select name="kelas_id" id="kelas_id" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all">
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
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Tanggal</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all">
                    </div>
                </div>
                
                <div class="space-y-2 group">
                    <label for="periode" class="block text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Periode</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <select name="periode" id="periode" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all">
                            <option value="today">Hari Ini</option>
                            <option value="yesterday">Kemarin</option>
                            <option value="this_week">Minggu Ini</option>
                            <option value="last_week">Minggu Lalu</option>
                            <option value="this_month">Bulan Ini</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="custom">Kustom</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                
                <div id="customDateRange" class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                    <div class="space-y-2 group">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Tanggal Mulai</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <input type="date" name="start_date" id="start_date" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all">
                        </div>
                    </div>
                    
                    <div class="space-y-2 group">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Tanggal Akhir</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <input type="date" name="end_date" id="end_date" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all">
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-3 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-500 text-white font-medium rounded-lg shadow-sm hover:from-blue-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 group">
                        <i class="fas fa-search mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Tampilkan Data</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-blue-50 rounded-lg text-blue-500">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $absensi->pluck('siswa_id')->unique()->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-400 to-blue-500"></div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-green-50 rounded-lg text-green-500">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Hadir</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $absensi->where('status', 'Hadir')->count() }}</h3>
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
                        <h3 class="text-xl font-semibold text-gray-800">{{ $absensi->where('status', 'Terlambat')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-yellow-400 to-yellow-500"></div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-red-50 rounded-lg text-red-500">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Tidak Hadir</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $absensi->whereIn('status', ['Sakit', 'Izin', 'Alpa'])->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-red-400 to-red-500"></div>
        </div>
    </div>
    
    <!-- Attendance Data Grouped by Class -->
    <div class="space-y-8">
        @if($kelas_id)
            <!-- If a specific class is selected, show only that class -->
            @php
                $filteredKelas = $kelas->where('id', $kelas_id);
            @endphp
        @else
            <!-- If no class is selected, show all classes -->
            @php
                $filteredKelas = $kelas;
            @endphp
        @endif

        @foreach($filteredKelas as $k)
            @php
                $classAttendance = $absensi->filter(function($item) use ($k) {
                    return $item->siswa->kelas_id == $k->id;
                });
            @endphp
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md" x-data="{ expanded: true }">
                <div class="bg-gradient-to-r from-blue-50 to-blue-50 px-6 py-4 cursor-pointer" @click="expanded = !expanded">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="p-2 bg-blue-100 rounded-lg text-blue-500">
                                <i class="fas fa-users text-lg"></i>
                            </span>
                            <h3 class="text-lg font-medium text-gray-800">Kelas: {{ $k->nama_kelas }}</h3>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 text-sm rounded-full">
                                {{ $classAttendance->count() }} Siswa
                            </span>
                            <button class="text-gray-500 focus:outline-none transition-transform duration-200" :class="{'rotate-180': !expanded}">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div x-show="expanded" x-collapse x-cloak>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($classAttendance as $index => $a)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $a->siswa->nisn }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $a->siswa->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($a->waktu_scan)->format('H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($a->status == 'Hadir')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Hadir
                                        </span>
                                        @elseif($a->status == 'Terlambat')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Terlambat
                                        </span>
                                        @elseif($a->status == 'Izin')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-user-clock mr-1"></i> Izin
                                        </span>
                                        @elseif($a->status == 'Sakit')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            <i class="fas fa-user-injured mr-1"></i> Sakit
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i> Alpa
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $a->keterangan ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex space-x-2">
                                            <button type="button" class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="text-red-600 hover:text-red-900 transition-colors" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <span class="p-3 bg-gray-100 rounded-full text-gray-400 mb-3">
                                                <i class="fas fa-calendar-times text-2xl"></i>
                                            </span>
                                            <p class="text-gray-500 font-medium">Tidak ada data absensi untuk kelas ini</p>
                                            <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau tambahkan data absensi</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if($filteredKelas->count() == 0)
            <div class="bg-white rounded-xl shadow-sm p-10 text-center border border-gray-100">
                <div class="flex flex-col items-center">
                    <span class="p-4 bg-gray-100 rounded-full text-gray-400 mb-4">
                        <i class="fas fa-school text-4xl"></i>
                    </span>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Tidak ada data kelas yang tersedia</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Silakan tambahkan data kelas terlebih dahulu atau ubah filter pencarian Anda.</p>
                </div>
            </div>
        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle custom date range based on selected period
        const periodeSelect = document.getElementById('periode');
        const customDateRange = document.getElementById('customDateRange');
        
        periodeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.classList.remove('hidden');
            } else {
                customDateRange.classList.add('hidden');
            }
        });
        
        // Add subtle hover effects to cards
        const cards = document.querySelectorAll('.bg-white.rounded-xl');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('shadow-md');
                this.style.transform = 'translateY(-2px)';
            });
            card.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-md');
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Add staggered animation to cards
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    });
</script>

@endsection
