@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50/50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
            <div class="flex items-center justify-between p-8 bg-gradient-to-r from-blue-600 to-indigo-600">
                <div class="flex items-center space-x-8">
                    <div class="flex-shrink-0 h-24 w-24 rounded-full ring-4 ring-white/90 overflow-hidden">
                        <img src="{{ asset('storage/' . $user->dataSiswa->foto) }}" 
                             alt="Foto {{ $user->dataSiswa->nama_lengkap }}" 
                             class="h-full w-full object-cover">
                    </div>
                    <div>
                        <div class="flex items-center space-x-3">
                            <h1 class="text-3xl font-bold text-white">
                                {{ $user->dataSiswa->nama_lengkap }}
                            </h1>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-500/20 text-white border border-white/20">
                                Siswa Aktif
                            </span>
                        </div>
                        <div class="flex space-x-4 mt-3">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-white/90 text-blue-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                NISN: {{ $user->dataSiswa->nisn }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-white/90 text-blue-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Kelas {{ $user->dataSiswa->kelas->nama_kelas }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 font-medium">Sekolah</p>
                        <h3 class="text-lg font-semibold text-gray-800 mt-1">{{ $user->dataSiswa->sekolah->nama_sekolah }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-green-50 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 font-medium">Semester</p>
                        <h3 class="text-lg font-semibold text-gray-800 mt-1">{{ $user->dataSiswa->semester_aktif ?? 'Ganjil 2024/2025' }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 font-medium">Total Mapel</p>
                        <h3 class="text-lg font-semibold text-gray-800 mt-1">{{ $user->dataSiswa->kelas->jadwalPelajaran->unique('mata_pelajaran')->count() }} Mata Pelajaran</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-yellow-50 text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 font-medium">Hari Ini</p>
                        <h3 class="text-lg font-semibold text-gray-800 mt-1">{{ now()->isoFormat('dddd') }} {{ now()->format('H:i') }}</h3>
                    </div>
                </div>
            </div>
        </div>


        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Jadwal Pelajaran</h1>
        <p class="mt-2 text-sm text-gray-600">
            Semester {{ $user->dataSiswa->semester_aktif ?? 'Ganjil' }} Tahun Ajaran {{ $user->dataSiswa->tahun_ajaran ?? '2024/2025' }}
        </p>
    </div>

    <!-- Schedule Card -->
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <!-- Day Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex" aria-label="Tabs" x-data="{ activeDay: '{{ now()->format('l') }}' }">
                @php
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $currentDay = now()->locale('id')->dayName;
                @endphp

                @foreach($days as $hari)
                    <button 
                        onclick="showSchedule('{{ $hari }}')"
                        class="tab-btn flex-1 py-4 px-1 text-center border-b-2 transition-colors duration-200 text-sm font-medium
                            {{ $hari === $currentDay ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        id="tab-{{ $hari }}"
                    >
                        <span class="inline-flex items-center">
                            @if($hari === $currentDay)
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                            @endif
                            {{ $hari }}
                        </span>
                    </button>
                @endforeach
            </nav>
        </div>

        <!-- Schedule Content -->
        @foreach($days as $hari)
            <div 
                id="schedule-{{ $hari }}" 
                class="schedule-content {{ $hari !== $currentDay ? 'hidden' : '' }}"
            >
                @if(isset($jadwalPerHari[$hari]) && $jadwalPerHari[$hari]->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Mata Pelajaran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Guru</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Ruangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($jadwalPerHari[$hari]->sortBy('waktu_mulai') as $jadwal)
                                    @php
                                        $isCurrentClass = Carbon\Carbon::now()->format('l') == $hari && 
                                            Carbon\Carbon::now()->between(
                                                Carbon\Carbon::parse($jadwal->waktu_mulai),
                                                Carbon\Carbon::parse($jadwal->waktu_selesai)
                                            );
                                    @endphp
                                    <tr class="{{ $isCurrentClass ? 'bg-green-50 border-l-4 border-green-500' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                                {{ Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - 
                                                {{ Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                                {{ $jadwal->mata_pelajaran }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                                {{ $jadwal->guru->nama_lengkap }}
                                            </div>
                                            <div class="text-xs {{ $isCurrentClass ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $jadwal->guru->nip }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm {{ $isCurrentClass ? 'text-green-700' : 'text-gray-900' }}">
                                                {{ $jadwal->ruangan ?? 'Default' }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">Tidak ada jadwal pelajaran untuk hari {{ $hari }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Profile Section -->
    <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Data Pribadi</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->dataSiswa->tmp_lahir }}, {{ $user->dataSiswa->tgl_lahir }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->dataSiswa->jenis_kelamin }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Agama</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->dataSiswa->agama }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">No. Telepon</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->dataSiswa->hp ?? '-' }}</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="pb-4">
                    <p class="text-sm font-medium text-gray-500">Data Orang Tua</p>
                    <div class="mt-3 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Ayah</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->dataSiswa->ayah ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Ibu</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->dataSiswa->ibu ?? '-' }}</span>
                        </div>
                        @if($user->dataSiswa->wali)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Wali</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->dataSiswa->wali }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="#" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Nilai</h3>
                        <p class="text-sm text-gray-500">Lihat nilai akademik</p>
                    </div>
                </div>
            </a>

            <a href="#" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-green-50 text-green-600 group-hover:bg-green-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Absensi</h3>
                        <p class="text-sm text-gray-500">Rekap kehadiran</p>
                    </div>
                </div>
            </a>

            <a href="#" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Tugas</h3>
                        <p class="text-sm text-gray-500">Daftar tugas</p>
                    </div>
                </div>
            </a>

            <a href="#" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-yellow-50 text-yellow-600 group-hover:bg-yellow-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pengumuman</h3>
                        <p class="text-sm text-gray-500">Info terbaru</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

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
</script>
@endsection