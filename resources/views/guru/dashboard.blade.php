@extends('layouts.app3')

@section('title', 'Dashboard Guru')

@section('content')
<div class="space-y-6 md:ml-64">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl shadow-lg p-6 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h1>
                <p class="mt-1 text-primary-100">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="flex items-center space-x-2 bg-white/10 rounded-lg px-4 py-2 backdrop-blur-sm">
                <i class='bx bx-calendar text-xl'></i>
                <div>
                    <p class="text-sm font-medium">
                        @if(now()->month >= 1 && now()->month <= 6)
                            Semester Genap
                        @else
                            Semester Ganjil
                        @endif
                    </p>
                    <p class="text-xs">Tahun Ajaran {{ now()->year - 1 }}/{{ now()->year }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 hover-card border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Kelas</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                    <i class='bx bx-chalkboard text-2xl text-primary-500'></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 hover-card border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jurnal Bulan Ini</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                    <i class='bx bx-book-open text-2xl text-primary-500'></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 hover-card border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jadwal Hari Ini</p>
                    </div>
                <div class="w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                    <i class='bx bx-time-five text-2xl text-primary-500'></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 hover-card border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Siswa</p>
                    <p class="text-2xl font-bold mt-1">{{ $totalSiswa }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                    <i class='bx bx-group text-2xl text-primary-500'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-lg font-semibold">Jadwal Hari Ini</h2>
            <a href="{{ route('jadwal-pelajaran.index') }}" class="text-primary-500 hover:text-primary-600 text-sm flex items-center">
                Lihat Semua
                <i class='bx bx-chevron-right ml-1'></i>
            </a>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @php
                $today = strtolower(now()->translatedFormat('l'));
                $currentTime = now()->format('H:i:s');
                 
            @endphp
            
            @forelse($jadwalHariIni as $jadwal)
                <div class="p-4 flex items-center">
                    <div class="w-16 h-16 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex flex-col items-center justify-center mr-4">
                        <span class="text-xs text-primary-600 dark:text-primary-400">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                        <span class="text-xs text-primary-600 dark:text-primary-400 mt-1">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium">{{ $jadwal->mata_pelajaran }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $jadwal->kelas->nama_kelas }}</p>
                    </div>
                    <div class="flex items-center">
                        @php
                            $status = 'Akan Datang';
                            $statusClass = 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300';
                            
                            if ($currentTime > $jadwal->jam_selesai) {
                                $status = 'Selesai';
                                $statusClass = 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400';
                            } elseif ($currentTime >= $jadwal->jam_mulai && $currentTime <= $jadwal->jam_selesai) {
                                $status = 'Berlangsung';
                                $statusClass = 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400';
                            }
                        @endphp
                        <span class="px-2 py-1 {{ $statusClass }} text-xs rounded-md">{{ $status }}</span>
                        <button class="ml-3 text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                            <i class='bx bx-dots-vertical-rounded text-xl'></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada jadwal pelajaran hari ini
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Journals -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-lg font-semibold">Jurnal Terbaru</h2>
            <a href="{{ route('jurnal-guru.index') }}" class="text-primary-500 hover:text-primary-600 text-sm flex items-center">
                Lihat Semua
                <i class='bx bx-chevron-right ml-1'></i>
            </a>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            
            
            @forelse($jurnalTerbaru as $jurnal)
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-medium">{{ $jurnal->jadwalPelajaran->mata_pelajaran }} - {{ $jurnal->kelas->nama_kelas }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $jurnal->materi_yang_disampaikan }}</p>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $jurnal->tanggal->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center">
                            @php
                                $statusClass = 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400';
                                $statusText = 'Terlaksana';
                                
                                if ($jurnal->status_pertemuan == 'diganti') {
                                    $statusClass = 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400';
                                    $statusText = 'Diganti';
                                } elseif ($jurnal->status_pertemuan == 'dibatalkan') {
                                    $statusClass = 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400';
                                    $statusText = 'Dibatalkan';
                                }
                            @endphp
                            <span class="px-2 py-1 {{ $statusClass }} text-xs rounded-md">{{ $statusText }}</span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('jurnal-guru.show', $jurnal->id) }}" class="text-primary-500 hover:text-primary-600">
                                <i class='bx bx-show text-lg'></i>
                            </a>
                            <a href="{{ route('jurnal-guru.edit', $jurnal->id) }}" class="text-yellow-500 hover:text-yellow-600">
                                <i class='bx bx-edit text-lg'></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    Belum ada jurnal yang dibuat
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection