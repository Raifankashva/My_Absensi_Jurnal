@extends('layouts.app2')

@section('content')
<div class="px-4 py-3">
    <!-- Student Profile Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-4">
        <!-- Header with gradient background -->
        <div class="p-4 bg-gradient-to-r from-blue-600 to-indigo-600">
            <div class="flex items-center gap-3">
                <!-- Student photo -->
                <div class="flex-shrink-0 h-16 w-16 rounded-full ring-2 ring-white/90 overflow-hidden bg-white">
                    <img src="{{ asset('storage/' . $user->dataSiswa->foto) }}" 
                         alt="Foto {{ $user->dataSiswa->nama_lengkap }}" 
                         class="h-full w-full object-cover">
                </div>
                
                <!-- Student information -->
                <div>
                    <h1 class="text-lg font-bold text-white truncate">
                        {{ $user->dataSiswa->nama_lengkap }}
                    </h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-500/20 text-white border border-white/20">
                            Siswa Aktif
                        </span>
                        <span class="text-xs text-white/90">
                            Kelas {{ $user->dataSiswa->kelas->nama_kelas }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- NISN Badge -->
            <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/90 text-blue-800">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                </svg>
                NISN: {{ $user->dataSiswa->nisn }}
            </div>
        </div>
        
        <!-- QR Code Section -->
        <div class="p-3 border-t border-gray-100 flex items-center justify-between">
            <div>
                <h5 class="text-sm font-medium text-gray-800">QR Code Absensi</h5>
                <p class="text-xs text-gray-500">Tunjukkan saat absensi</p>
            </div>
            <img src="{{ $qrCodeUrl }}" alt="QR Code {{ $user->dataSiswa->nama_lengkap }}" class="h-16 w-16">
        </div>
        
        <!-- Student ID Card Download -->
        <div class="p-3 border-t border-gray-100 flex items-center justify-between">
            <div>
                <h5 class="text-sm font-medium text-gray-800">Kartu Pelajar</h5>
                <p class="text-xs text-gray-500">Unduh kartu pelajar resmi</p>
            </div>
            <a href="{{ route('siswa.kartu-pelajar') }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid - 2x2 for mobile -->
    <div class="grid grid-cols-2 gap-3 mb-4">
        <div class="bg-white rounded-xl shadow-sm p-3 transition-all duration-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-gray-500 font-medium">Sekolah</p>
                    <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $user->dataSiswa->sekolah->nama_sekolah }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-3 transition-all duration-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-green-50 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-gray-500 font-medium">Semester</p>
                    <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $user->dataSiswa->semester_aktif ?? 'Ganjil 2024/2025' }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-3 transition-all duration-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-purple-50 text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-gray-500 font-medium">Total Mapel</p>
                    <h3 class="text-sm font-semibold text-gray-800">{{ $user->dataSiswa->kelas->jadwalPelajaran->unique('mata_pelajaran')->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-3 transition-all duration-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-yellow-50 text-yellow-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-4">
        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-800">Jadwal Pelajaran</h2>
            <p class="text-xs text-gray-500">
                {{ $user->dataSiswa->semester_aktif ?? 'Ganjil' }} {{ $user->dataSiswa->tahun_ajaran ?? '2024/2025' }}
            </p>
        </div>

        <!-- Day Tabs - Scrollable on mobile -->
        <div class="border-b border-gray-200 overflow-x-auto">
            <div class="flex whitespace-nowrap" aria-label="Tabs">
                @php
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $currentDay = now()->locale('id')->dayName;
                @endphp

                @foreach($days as $hari)
                    <button 
                        onclick="showSchedule('{{ $hari }}')"
                        class="tab-btn py-2 px-4 text-center border-b-2 transition-colors duration-200 text-xs font-medium
                            {{ $hari === $currentDay ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        id="tab-{{ $hari }}"
                    >
                        <span class="inline-flex items-center">
                            @if($hari === $currentDay)
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                            @endif
                            {{ $hari }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Schedule Content -->
        @foreach($days as $hari)
            <div 
                id="schedule-{{ $hari }}" 
                class="schedule-content {{ $hari !== $currentDay ? 'hidden' : '' }}"
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
                            <div class="p-3 {{ $isCurrentClass ? 'bg-green-50 border-l-4 border-green-500' : '' }}">
                                <div class="flex justify-between items-start mb-1.5">
                                    <div class="font-medium text-sm {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                        {{ $jadwal->mata_pelajaran }}
                                    </div>
                                    <div class="text-xs font-medium {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                        {{ Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - 
                                        {{ Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                    </div>
                                </div>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <div class="text-xs {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                            {{ $jadwal->guru->nama_lengkap }}
                                        </div>
                                        <div class="text-xs {{ $isCurrentClass ? 'text-green-600' : 'text-gray-500' }}">
                                            {{ $jadwal->guru->nip }}
                                        </div>
                                    </div>
                                    <div class="text-xs {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                        {{ $jadwal->ruangan ?? 'Default' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-500 text-sm">Tidak ada jadwal pelajaran untuk hari {{ $hari }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Attendance History - Mobile Optimized -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-4">
        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-800">Riwayat Absensi</h2>
            <a href="#" class="text-xs text-blue-600 font-medium">Lihat Semua</a>
        </div>
        
        <div class="p-3">
            <div class="space-y-2">
                @forelse($absensi->take(3) as $data)
                    <div class="bg-gray-50 rounded-lg p-2.5">
                        <div class="flex justify-between items-center">
                            <div class="text-xs font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($data->waktu_scan)->format('d-m-Y') }}
                            </div>
                            @if($data->status == 'Hadir')
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ $data->status }}</span>
                            @elseif($data->status == 'Terlambat')
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ $data->status }}</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ $data->status }}</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Waktu: {{ \Carbon\Carbon::parse($data->waktu_scan)->format('H:i:s') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500 text-sm">Belum ada data absensi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Profile Section - Accordion Style for Mobile -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-4">
        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center" 
             onclick="toggleSection('profile-data')" 
             style="cursor: pointer;">
            <h3 class="text-base font-semibold text-gray-800">Data Pribadi</h3>
            <svg id="profile-data-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <div id="profile-data" class="p-4 hidden">
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-medium text-gray-500">Tempat, Tanggal Lahir</p>
                    <p class="mt-0.5 text-sm text-gray-900">{{ $user->dataSiswa->tmp_lahir }}, {{ $user->dataSiswa->tgl_lahir }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Jenis Kelamin</p>
                    <p class="mt-0.5 text-sm text-gray-900">{{ $user->dataSiswa->jenis_kelamin }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500">Agama</p>
                    <p class="mt-0.5 text-sm text-gray-900">{{ $user->dataSiswa->agama }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500">No. Telepon</p>
                    <p class="mt-0.5 text-sm text-gray-900">{{ $user->dataSiswa->hp ?? '-' }}</p>
                </div>
                
                <div class="pt-2">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get current day in Indonesian
    const days = {
        'Sunday': 'Minggu',
        'Monday': 'Senin',
        'Tuesday': 'Selasa',
        'Wednesday': 'Rabu',
        'Thursday': 'Kamis',
        'Friday': 'Jumat',
        'Saturday': 'Sabtu'
    };
    
    const today = days[new Date().toLocaleString('en-US', {weekday: 'long'})];
    
    // Show current day's schedule by default
    if (today !== 'Minggu') {
        showSchedule(today);
    } else {
        showSchedule('Senin'); // Default to Monday if it's Sunday
    }
    
    // Show profile data section by default
    toggleSection('profile-data');
});

function showSchedule(day) {
    // Hide all schedule contents
    document.querySelectorAll('.schedule-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-btn').forEach(tab => {
        tab.classList.remove('border-blue-500', 'text-blue-600', 'bg-blue-50');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected schedule
    const scheduleContent = document.getElementById(`schedule-${day}`);
    if (scheduleContent) {
        scheduleContent.classList.remove('hidden');
    }
    
    // Activate selected tab
    const selectedTab = document.getElementById(`tab-${day}`);
    if (selectedTab) {
        selectedTab.classList.remove('border-transparent', 'text-gray-500');
        selectedTab.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');
    }
}

function toggleSection(sectionId) {
    const section = document.getElementById(sectionId);
    const icon = document.getElementById(`${sectionId}-icon`);
    
    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        section.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}
</script>
@endpush
@endsection

