@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-600 p-3 rounded-lg">
                    <i class="bx bxs-dashboard text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-blue-900">Admin Dashboard</h1>
                    <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4 bg-white px-6 py-3 rounded-xl shadow-sm border border-blue-100">
                <div class="flex items-center space-x-2">
                    <i class="bx bx-calendar text-blue-600"></i>
                    <span class="text-sm text-gray-600">{{ now()->format('d M Y') }}</span>
                </div>
                <div class="w-px h-4 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <i class="bx bx-time text-blue-600"></i>
                    <span class="text-sm text-gray-600">{{ now()->format('H:i') }}</span>
                </div>
                <div class="w-px h-4 bg-gray-300"></div>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                    Admin Panel
                </span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @php
            $cards = [
                [
                    'color' => 'blue',
                    'gradient' => 'from-blue-600 to-blue-400',
                    'icon' => 'bxs-school',
                    'title' => 'Total Sekolah',
                    'count' => $totalSekolah,
                    'trend' => '+2.5%',
                    'trend_text' => 'dari bulan lalu'
                ],
                [
                    'color' => 'emerald',
                    'gradient' => 'from-emerald-600 to-emerald-400',
                    'icon' => 'bxs-user-detail',
                    'title' => 'Total Guru',
                    'count' => $totalGuru,
                    'trend' => '+3.2%',
                    'trend_text' => 'dari bulan lalu'
                ],
                [
                    'color' => 'purple',
                    'gradient' => 'from-purple-600 to-purple-400',
                    'icon' => 'bxs-group',
                    'title' => 'Total Siswa',
                    'count' => $totalSiswa,
                    'trend' => '+5.1%',
                    'trend_text' => 'dari bulan lalu'
                ],
                [
                    'color' => 'rose',
                    'gradient' => 'from-rose-600 to-rose-400',
                    'icon' => 'bxs-user-pin',
                    'title' => 'Total Pengguna',
                    'count' => $latestUsers->count(),
                    'trend' => '+1.8%',
                    'trend_text' => 'dari bulan lalu'
                ]
            ];
            @endphp

            @foreach($cards as $card)
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r {{ $card['gradient'] }} rounded-xl transform transition-all duration-300 group-hover:scale-105 group-hover:rotate-1"></div>
                <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 group-hover:-translate-y-1 group-hover:-translate-x-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">{{ $card['title'] }}</h3>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($card['count']) }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-emerald-500 text-sm font-medium">{{ $card['trend'] }}</span>
                                    <span class="text-gray-500 text-xs ml-1">{{ $card['trend_text'] }}</span>
                                </div>
                            </div>
                            <div class="bg-{{ $card['color'] }}-100 rounded-lg p-3">
                                <i class="bx {{ $card['icon'] }} text-2xl text-{{ $card['color'] }}-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Attendance Overview -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-200">
                    <h3 class="text-xl font-semibold text-blue-900">Overview Absensi Hari Ini</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                        $attendance = [
                            [
                                'title' => 'Hadir',
                                'count' => 850,
                                'percentage' => 85,
                                'color' => 'emerald'
                            ],
                            [
                                'title' => 'Izin/Sakit',
                                'count' => 100,
                                'percentage' => 10,
                                'color' => 'yellow'
                            ],
                            [
                                'title' => 'Tidak Hadir',
                                'count' => 50,
                                'percentage' => 5,
                                'color' => 'rose'
                            ]
                        ];
                        @endphp

                        @foreach($attendance as $item)
                        <div class="bg-{{ $item['color'] }}-50 rounded-lg p-6 border border-{{ $item['color'] }}-200 transform transition-all duration-300 hover:scale-105">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-{{ $item['color'] }}-700 font-semibold">{{ $item['title'] }}</h4>
                                <span class="bg-{{ $item['color'] }}-100 text-{{ $item['color'] }}-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $item['percentage'] }}%
                                </span>
                            </div>
                            <p class="text-3xl font-bold text-{{ $item['color'] }}-700">{{ number_format($item['count']) }}</p>
                            <div class="mt-4 bg-{{ $item['color'] }}-200 rounded-full h-2.5">
                                <div class="bg-{{ $item['color'] }}-600 h-2.5 rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Users and Schools -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Latest Users -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="bx bxs-user-plus text-2xl text-blue-600"></i>
                        <h3 class="text-xl font-semibold text-blue-900">Pengguna Terbaru</h3>
                    </div>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition flex items-center">
                        Lihat Semua
                        <i class="bx bx-right-arrow-alt ml-1"></i>
                    </a>
                </div>
                <div class="divide-y divide-blue-100">
                    @foreach($latestUsers->take(5) as $user)
                    <div class="px-6 py-4 hover:bg-blue-50 transition-all duration-200 group">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="bx bxs-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 group-hover:text-blue-900 transition">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Schools List -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="bx bxs-graduation text-2xl text-blue-600"></i>
                        <h3 class="text-xl font-semibold text-blue-900">Daftar Sekolah</h3>
                    </div>
                    <a href="{{ route('sekolahs.index') }}" class="text-sm text-blue-600 hover:text-blue-800 transition flex items-center">
                        Lihat Semua
                        <i class="bx bx-right-arrow-alt ml-1"></i>
                    </a>
                </div>
                <div class="divide-y divide-blue-100">
                    @foreach($sekolah->take(5) as $s)
                    <div class="px-6 py-4 hover:bg-blue-50 transition-all duration-200 group">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="bx bxs-school text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 group-hover:text-blue-900 transition">
                                        {{ $s->nama_sekolah }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $s->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ ucfirst($s->jenjang) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $s->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection