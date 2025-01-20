@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
    <div class="flex items-center space-x-3">
        <span class="text-sm text-gray-600">Welcome</span>
        <span class="text-sm text-gray-600">|</span>
        <span class="text-sm text-gray-600">{{ now()->format('d M Y') }}</span>
        <span class="text-sm text-gray-600">|</span>
        <span class="text-sm text-gray-600">{{ now()->format('H:i') }}</span> <!-- Current time -->
        <span class="text-sm text-gray-600">|</span>
        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
            Admin Panel
        </span>
    </div>
</div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-600 text-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-medium mb-2">Total Sekolah</h3>
                        <p class="text-3xl font-bold">{{ $totalSekolah }}</p>
                    </div>
                    <div class="bg-blue-500 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5 8.11V14a1 1 0 00.553.894l4 2A1 1 0 0010 16V8.11l2.394-1.021a1 1 0 000-1.84l-7-3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-green-600 text-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-medium mb-2">Total Guru</h3>
                        <p class="text-3xl font-bold">{{ $totalGuru }}</p>
                    </div>
                    <div class="bg-green-500 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-purple-600 text-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-medium mb-2">Total Siswa</h3>
                        <p class="text-3xl font-bold">{{ $totalSiswa }}</p>
                    </div>
                    <div class="bg-purple-500 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-red-600 text-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-medium mb-2">Total Pengguna</h3>
                        <p class="text-3xl font-bold">{{ $latestUsers->count() }}</p>
                    </div>
                    <div class="bg-red-500 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b">
                <h3 class="text-xl font-semibold text-gray-800">Pengguna Terbaru</h3>
            </div>
            <div class="divide-y">
                @foreach($latestUsers as $user)
                <div class="px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                        <div>
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

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b">
                <h3 class="text-xl font-semibold text-gray-800">Daftar Sekolah</h3>
            </div>
            <div class="divide-y">
                @foreach($sekolah as $s)
                <div class="px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">{{ $s->nama_sekolah }}</p>
                            <p class="text-sm text-gray-500">{{ $s->email }}</p>
                        </div>
                        <div>
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
@endsection