@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<div class="space-y-8">
    <!-- Header with gradient background -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-400 rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center space-x-3">
                <i class="fas fa-calendar-check text-white text-3xl"></i>
                <h1 class="text-2xl font-bold text-white">Data Absensi {{ $authSchool->nama }}</h1>
            </div>
            {{-- Replace the existing export buttons in the header with these --}}
<div class="flex space-x-3 mt-4 md:mt-0">
    <button type="button" id="exportBtn" 
       class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg inline-flex items-center transition-all duration-300 backdrop-blur-sm border border-white/20">
        <i class="fas fa-download mr-2"></i> Export
    </button>
</div>

<!-- Export Dropdown Menu (hidden by default) -->
<div id="exportMenu" class="hidden absolute right-6 mt-12 bg-white rounded-lg shadow-lg z-50 w-64 border border-blue-100 overflow-hidden">
    <div class="bg-blue-50 p-3 text-blue-600 font-semibold border-b border-blue-100">
        <i class="fas fa-file-export mr-2"></i> Export Options
    </div>
    <div class="p-3 space-y-2">
        <div class="text-gray-600 text-sm mb-2 font-medium">Single Day Export</div>
        <a href="{{ route('absensi.exportPDF', ['kelas_id' => request('kelas_id'), 'tanggal' => request('tanggal', Carbon\Carbon::now()->format('Y-m-d'))]) }}" 
            class="flex items-center p-2 hover:bg-blue-50 rounded text-gray-700 transition-colors">
            <i class="fas fa-file-pdf text-red-500 mr-2"></i> Export PDF (Single Day)
        </a>
        <a href="{{ route('absensi.exportExcel', ['kelas_id' => request('kelas_id'), 'tanggal' => request('tanggal', Carbon\Carbon::now()->format('Y-m-d'))]) }}" 
            class="flex items-center p-2 hover:bg-blue-50 rounded text-gray-700 transition-colors">
            <i class="fas fa-file-excel text-green-500 mr-2"></i> Export Excel (Single Day)
        </a>
        
        <div class="border-t border-gray-200 my-2"></div>
        
        <div class="text-gray-600 text-sm mb-2 font-medium">Period Export</div>
        <a href="{{ route('absensi.exportPeriodePDF', [
                'kelas_id' => request('kelas_id'), 
                'periode' => request('periode', 'today'),
                'tanggal_mulai' => request('tanggal_mulai'),
                'tanggal_akhir' => request('tanggal_akhir')
            ]) }}" 
            class="flex items-center p-2 hover:bg-blue-50 rounded text-gray-700 transition-colors">
            <i class="fas fa-file-pdf text-red-500 mr-2"></i> Export PDF (Period)
        </a>
        <a href="{{ route('absensi.exportPeriodeExcel', [
                'kelas_id' => request('kelas_id'), 
                'periode' => request('periode', 'today'),
                'tanggal_mulai' => request('tanggal_mulai'),
                'tanggal_akhir' => request('tanggal_akhir')
            ]) }}" 
            class="flex items-center p-2 hover:bg-blue-50 rounded text-gray-700 transition-colors">
            <i class="fas fa-file-excel text-green-500 mr-2"></i> Export Excel (Period)
        </a>
    </div>
</div>

            {{-- Add this to the existing filter form in your absensi.index.blade.php --}}
<div class="transition-all duration-300 hover:scale-105">
    <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
    <div class="relative">
        <select name="periode" id="periode" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 pl-10 py-3">
            <option value="today" {{ request('periode') == 'today' ? 'selected' : '' }}>Hari Ini</option>
            <option value="this_week" {{ request('periode') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="last_week" {{ request('periode') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
            <option value="this_month" {{ request('periode') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="last_month" {{ request('periode') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
            <option value="last_2_months" {{ request('periode') == 'last_2_months' ? 'selected' : '' }}>2 Bulan Terakhir</option>
            <option value="custom" {{ request('periode') == 'custom' ? 'selected' : '' }}>Kustom (Pilih Tanggal)</option>
        </select>
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-blue-500">
            <i class="fas fa-calendar-week"></i>
        </div>
    </div>
</div>

<!-- Custom Date Range (initially hidden) -->
<div id="customDateRange" class="grid grid-cols-1 md:grid-cols-2 gap-4 {{ request('periode') == 'custom' ? '' : 'hidden' }}">
    <div class="transition-all duration-300 hover:scale-105">
        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
        <div class="relative">
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 pl-10 py-3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-blue-500">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
    </div>
    
    <div class="transition-all duration-300 hover:scale-105">
        <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
        <div class="relative">
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 pl-10 py-3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-blue-500">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
    
    <!-- Filter Form with glass morphism effect -->
    <div class="bg-white/80 backdrop-blur-md p-6 rounded-xl shadow-md border border-blue-100 transform transition-all duration-300 hover:shadow-lg">
        <div class="flex items-center mb-4 text-blue-600">
            <i class="fas fa-filter mr-2 text-xl"></i>
            <h2 class="text-lg font-semibold">Filter Data</h2>
        </div>
        <form action="{{ route('absensi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="transition-all duration-300 hover:scale-105">
                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <div class="relative">
                    <select name="kelas_id" id="kelas_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 pl-10 py-3">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-blue-500">
                        <i class="fas fa-school"></i>
                    </div>
                </div>
            </div>
            
            <div class="transition-all duration-300 hover:scale-105">
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <div class="relative">
                    <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 pl-10 py-3">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-blue-500">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-6 py-3 rounded-lg inline-flex items-center transition-all duration-300 shadow-md hover:shadow-lg w-full justify-center">
                    <i class="fas fa-search mr-2"></i> Tampilkan Data
                </button>
            </div>
        </form>
    </div>
    
    <!-- Manual Attendance Form -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl shadow-md border border-blue-200 transform transition-all duration-300 hover:shadow-lg">
        <div class="flex items-center mb-4 text-blue-600">
            <i class="fas fa-user-check mr-2 text-xl"></i>
            <h2 class="text-lg font-semibold">Absensi Manual</h2>
        </div>
        <form action="{{ route('absensi.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            <div class="transition-all duration-300 hover:scale-105">
                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN Siswa</label>
                <div class="relative">
                    <input type="text" name="nisn" id="nisn" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 pl-10 py-3" placeholder="Masukkan NISN Siswa">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-blue-500">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-6 py-3 rounded-lg inline-flex items-center transition-all duration-300 shadow-md hover:shadow-lg w-full justify-center">
                    <i class="fas fa-save mr-2"></i> Simpan Absensi
                </button>
            </div>
        </form>
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
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-100 transform transition-all duration-300 hover:shadow-lg animate-fadeIn">
                <div class="bg-gradient-to-r from-blue-600 to-blue-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-users text-white text-xl"></i>
                            <h3 class="text-lg font-semibold text-white">Kelas: {{ $k->nama_kelas }}</h3>
                        </div>
                        <div class="bg-white/20 text-white text-sm px-3 py-1 rounded-full backdrop-blur-sm">
                            {{ $classAttendance->count() }} Siswa
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">No</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">NISN</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Nama Siswa</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Waktu</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-100">
                            @forelse($classAttendance as $index => $a)
                            <tr class="hover:bg-blue-50 transition-colors duration-200">
                                <td class="py-3 px-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 whitespace-nowrap">{{ $a->siswa->nisn }}</td>
                                <td class="py-3 px-4 whitespace-nowrap">{{ $a->siswa->nama_lengkap }}</td>
                                <td class="py-3 px-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($a->waktu_scan)->format('H:i:s') }}</td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if($a->status == 'Hadir')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Hadir
                                    </span>
                                    @elseif($a->status == 'Terlambat')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Terlambat
                                    </span>
                                    @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Tidak Hadir
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 px-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-calendar-times text-blue-300 text-4xl mb-2"></i>
                                        <p>Tidak ada data absensi untuk kelas ini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        
        @if($filteredKelas->count() == 0)
            <div class="bg-white rounded-xl shadow-md p-8 text-center border border-blue-100">
                <i class="fas fa-school text-blue-300 text-5xl mb-4"></i>
                <p class="text-gray-600">Tidak ada data kelas yang tersedia</p>
            </div>
        @endif
    </div>
</div>

<style>
/* Add animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

/* Add this to your CSS to ensure proper animation timing for each class card */
.bg-white.rounded-xl {
    animation-delay: calc(var(--animation-order, 0) * 0.1s);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation order to each class card
    const classCards = document.querySelectorAll('.bg-white.rounded-xl');
    classCards.forEach((card, index) => {
        card.style.setProperty('--animation-order', index);
    });
    
    // Add hover animation to buttons
    const buttons = document.querySelectorAll('button, a.bg-gradient-to-r, a.bg-white\\/10');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.classList.add('scale-105');
        });
        button.addEventListener('mouseleave', function() {
            this.classList.remove('scale-105');
        });
    });
});
</script>

<script>
    // Add this to your existing script section or create a new one
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle export dropdown menu
        const exportBtn = document.getElementById('exportBtn');
        const exportMenu = document.getElementById('exportMenu');
        
        exportBtn.addEventListener('click', function() {
            exportMenu.classList.toggle('hidden');
        });
        
        // Close the dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!exportBtn.contains(event.target) && !exportMenu.contains(event.target)) {
                exportMenu.classList.add('hidden');
            }
        });
        
        // Show/hide custom date range based on selected period
        const periodeSelect = document.getElementById('periode');
        const customDateRange = document.getElementById('customDateRange');
        
        periodeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.classList.remove('hidden');
            } else {
                customDateRange.classList.add('hidden');
            }
        });
    });
</script>
@endsection

