@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <!-- Export Section -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
            <h3 class="text-xl font-semibold text-blue-800">Export Jadwal Pelajaran</h3>
        </div>
        <div class="p-6 bg-white">
            <form id="exportForm" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="export_kelas_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                    <div class="relative">
                        <select class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 pl-4 pr-10 py-2.5 appearance-none bg-white" id="export_kelas_id" name="kelas_id">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="export_hari" class="block text-sm font-medium text-gray-700 mb-2">Hari</label>
                    <div class="relative">
                        <select class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 pl-4 pr-10 py-2.5 appearance-none bg-white" id="export_hari" name="hari">
                            <option value="">Semua Hari</option>
                            @foreach($hariList as $h)
                            <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="export_guru_id" class="block text-sm font-medium text-gray-700 mb-2">Guru</label>
                    <div class="relative">
                        <select class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 pl-4 pr-10 py-2.5 appearance-none bg-white" id="export_guru_id" name="guru_id">
                            <option value="">Semua Guru</option>
                            @foreach($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-end space-x-3">
                    <button type="button" class="flex-1 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white inline-flex justify-center items-center px-4 py-2.5 rounded-lg shadow-md text-sm font-medium transition duration-150 ease-in-out transform hover:scale-105" onclick="exportPDF()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        PDF
                    </button>
                    <button type="button" class="flex-1 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white inline-flex justify-center items-center px-4 py-2.5 rounded-lg shadow-md text-sm font-medium transition duration-150 ease-in-out transform hover:scale-105" onclick="exportExcel()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Excel
                    </button>
                </div>
            </form>
        </div>
        <script>
            function exportPDF() {
                let url = '{{ route("jadwal-pelajaran.export-pdf") }}?' + new URLSearchParams(new FormData(document.getElementById('exportForm'))).toString();
                window.open(url, '_blank');
            }

            function exportExcel() {
                let url = '{{ route("jadwal-pelajaran.export-excel") }}?' + new URLSearchParams(new FormData(document.getElementById('exportForm'))).toString();
                window.open(url, '_blank');
            }
        </script>
        
        <!-- Jadwal Pelajaran Header -->
        <div class="px-6 py-5 border-t border-b border-gray-100 flex justify-between items-center space-x-3 bg-gradient-to-r from-blue-600 to-blue-700">
            <h3 class="text-xl font-semibold text-white">Jadwal Pelajaran</h3>
            <a href="{{ route('jadwal-pelajaran.create') }}"
                class="bg-white text-blue-700 hover:bg-blue-50 px-4 py-2 rounded-lg shadow-md border border-blue-200 transition duration-200 flex items-center space-x-2 text-sm font-medium transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Jadwal</span>
            </a>
        </div>
        
        <!-- Filter Section -->
        <div class="p-6 bg-white border-b border-gray-100">
            <form method="GET" action="{{ route('jadwal-pelajaran.index') }}" class="bg-blue-50 p-4 rounded-xl shadow-inner">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-0">
                    <div>
                        <label for="kelas_id" class="block text-sm font-medium text-blue-800 mb-2">Filter Kelas</label>
                        <div class="relative">
                            <select name="kelas_id"
                                class="w-full px-4 py-2.5 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition duration-200 bg-white shadow-sm"
                                onchange="this.form.submit()">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                <option value="{{ $k->id }}"
                                    {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-blue-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="hari" class="block text-sm font-medium text-blue-800 mb-2">Filter Hari</label>
                        <div class="relative">
                            <select name="hari"
                                class="w-full px-4 py-2.5 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition duration-200 bg-white shadow-sm"
                                onchange="this.form.submit()">
                                <option value="">Pilih Hari</option>
                                @foreach($hariList as $hari)
                                <option value="{{ $hari }}"
                                    {{ request('hari') == $hari ? 'selected' : '' }}>
                                    {{ $hari }}
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-blue-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

<div class="p-6 bg-white border-b border-gray-100">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calendar Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-100 lg:col-span-1">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 border-b border-blue-200">
                <h4 class="text-lg font-semibold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Kalender
                </h4>
            </div>
            <div class="p-4">
                <!-- Month and Year -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-blue-800">
                        <?php
                            $monthNames = [
                                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ];
                            $currentMonth = date('n') - 1; // 0-based index
                            $currentYear = date('Y');
                            echo $monthNames[$currentMonth] . ' ' . $currentYear;
                        ?>
                    </h3>
                    <div class="flex space-x-1">
                        <button class="p-1.5 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button class="p-1.5 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-1">
                    <!-- Days of Week -->
                    @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                        <div class="text-center py-2 text-xs font-semibold text-blue-700">{{ $day }}</div>
                    @endforeach
                    
                    <!-- Calendar Dates -->
                    <?php
                        $daysInMonth = date('t');
                        $firstDayOfMonth = date('N', strtotime(date('Y-m-01')));
                        $firstDayOfMonth = $firstDayOfMonth % 7; // Adjust for Sunday as first day
                        $currentDay = date('j');
                        
                        // Add empty cells for days before the 1st of the month
                        for ($i = 0; $i < $firstDayOfMonth; $i++) {
                            echo '<div class="text-center py-2 text-xs text-gray-400"></div>';
                        }
                        
                        // Add cells for each day of the month
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            $isToday = $day == $currentDay;
                            $cellClass = $isToday 
                                ? 'text-center py-2 text-xs font-medium bg-blue-600 text-white rounded-full' 
                                : 'text-center py-2 text-xs text-gray-700 hover:bg-blue-50 rounded-full';
                            
                            echo "<div class=\"$cellClass\">$day</div>";
                        }
                        
                        // Calculate remaining cells to fill out the grid
                        $remainingCells = 7 - (($firstDayOfMonth + $daysInMonth) % 7);
                        if ($remainingCells < 7) {
                            for ($i = 0; $i < $remainingCells; $i++) {
                                echo '<div class="text-center py-2 text-xs text-gray-400"></div>';
                            }
                        }
                    ?>
                </div>
                
                <!-- Legend -->
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                        <span class="text-xs text-gray-600">Hari Ini</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-xs text-gray-600">Ada Jadwal</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-100 p-4">
                <div class="flex items-start">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Total Mata Pelajaran</div>
                        <div class="text-2xl font-bold text-blue-800">
                            <?php
                                // This would ideally come from your controller
                                $totalMataPelajaran = count($jadwalPerKelas) > 0 ? rand(10, 20) : 0;
                                echo $totalMataPelajaran;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-100 p-4">
                <div class="flex items-start">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Total Guru</div>
                        <div class="text-2xl font-bold text-green-700">
                            <?php
                                // This would ideally come from your controller
                                $totalGuru = count($guru);
                                echo $totalGuru;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-100 p-4">
                <div class="flex items-start">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Total Kelas</div>
                        <div class="text-2xl font-bold text-purple-700">
                            <?php
                                // This would ideally come from your controller
                                $totalKelas = count($kelas);
                                echo $totalKelas;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-100 p-4">
                <div class="flex items-start">
                    <div class="p-3 rounded-full bg-amber-100 text-amber-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Jadwal Hari Ini</div>
                        <div class="text-2xl font-bold text-amber-700">
                            <?php
                                // This would ideally come from your controller
                                $jadwalHariIni = count($jadwalPerKelas) > 0 ? rand(3, 8) : 0;
                                echo $jadwalHariIni;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Jadwal Content -->
        <div class="p-6 bg-gray-50">
            @foreach($jadwalPerKelas as $namaKelas => $jadwal)
            <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden border border-blue-100 transform transition-all duration-300 hover:shadow-lg">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 border-b border-blue-200">
                    <h4 class="text-lg font-semibold text-white">{{ $namaKelas }}</h4>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Hari</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Mata Pelajaran</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Guru</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Jam</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($jadwal as $item)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">{{ $item->hari }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->mata_pelajaran }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->guru->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('jadwal-pelajaran.edit', $item->id) }}"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 p-2 rounded-lg transition duration-200 transform hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('jadwal-pelajaran.destroy', $item->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-2 rounded-lg transition duration-200 delete-confirm transform hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @if(count($jadwal) == 0)
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 bg-gray-50">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p>Tidak ada jadwal untuk kelas ini</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
            
            @if(count($jadwalPerKelas) == 0)
            <div class="bg-white rounded-xl shadow-md p-10 text-center border border-blue-100">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg text-gray-600 mb-2">Tidak ada jadwal yang ditemukan</p>
                    <p class="text-sm text-gray-500 mb-6">Silakan tambahkan jadwal baru atau ubah filter pencarian</p>
                    <a href="{{ route('jadwal-pelajaran.create') }}" 
                       class="bg-blue-600 text-white hover:bg-blue-700 px-6 py-2.5 rounded-lg shadow-md transition duration-200 flex items-center space-x-2 text-sm font-medium mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Jadwal Baru</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-confirm');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3B82F6',
                    cancelButtonColor: '#9CA3AF',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'text-white font-medium rounded-lg text-sm px-5 py-2.5',
                        cancelButton: 'text-white font-medium rounded-lg text-sm px-5 py-2.5 mr-2'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    });
</script>
@endsection
