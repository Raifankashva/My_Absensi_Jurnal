@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0">
        <h1 class="text-3xl font-bold text-blue-900">Admin Dashboard</h1>
        <div class="flex flex-wrap items-center justify-center md:justify-end space-x-3 bg-blue-50 px-4 py-2 rounded-lg shadow-sm">
            <div class="flex items-center space-x-2">
                <i class="bx bx-calendar text-blue-600"></i>
                <span class="text-sm text-gray-600">{{ now()->format('d M Y') }}</span>
            </div>
            <div class="w-px h-4 bg-gray-300 mx-2"></div>
            <div class="flex items-center space-x-2">
                <i class="bx bx-time text-blue-600"></i>
                <span class="text-sm text-gray-600">{{ now()->format('H:i') }}</span>
            </div>
            <div class="w-px h-4 bg-gray-300 mx-2"></div>
            <span class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                Admin Panel
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
        $cards = [
            ['color' => 'blue', 'icon' => 'bxs-school', 'title' => 'Total Sekolah', 'count' => $totalSekolah],
            ['color' => 'green', 'icon' => 'bxs-user-detail', 'title' => 'Total Guru', 'count' => $totalGuru],
            ['color' => 'purple', 'icon' => 'bxs-group', 'title' => 'Total Siswa', 'count' => $totalSiswa],
            ['color' => 'red', 'icon' => 'bxs-user-pin', 'title' => 'Total Pengguna', 'count' => $latestUsers->count()]
        ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-{{ $card['color'] }}-600 text-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-2xl">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-medium mb-2">{{ $card['title'] }}</h3>
                        <p class="text-3xl font-bold">{{ $card['count'] }}</p>
                    </div>
                    <div class="bg-{{ $card['color'] }}-500 rounded-full p-3">
                        <i class="bx {{ $card['icon'] }} text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100">
            <div class="bg-blue-50 px-6 py-4 border-b border-blue-200 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-blue-900">Pengguna Terbaru</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition">
                    Lihat Semua
                </a>
            </div>
            <div class="divide-y divide-blue-100">
                @foreach($latestUsers->take(5) as $user)
                <div class="px-6 py-4 hover:bg-blue-50 transition group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800 group-hover:text-blue-900 transition">
                                {{ $user->name }}
                            </p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                        <div class="text-right">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
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

        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100">
            <div class="bg-blue-50 px-6 py-4 border-b border-blue-200 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-blue-900">Daftar Sekolah</h3>
                <a href="{{ route('sekolahs.index') }}" class="text-sm text-blue-600 hover:text-blue-800 transition">
                    Lihat Semua
                </a>
            </div>
            <div class="divide-y divide-blue-100">
                @foreach($sekolah->take(5) as $s)
                <div class="px-6 py-4 hover:bg-blue-50 transition group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800 group-hover:text-blue-900 transition">
                                {{ $s->nama_sekolah }}
                            </p>
                            <p class="text-sm text-gray-500">{{ $s->email }}</p>
                        </div>
                        <div class="text-right">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
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
@endsection