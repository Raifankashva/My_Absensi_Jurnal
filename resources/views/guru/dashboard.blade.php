@extends('layouts.app')
@section('title', 'Guru Dashboard')

@section('content')
<div class="container mx-auto p-4">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Guru Dashboard</h2>
    </div>

    <!-- Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-blue-500 text-white rounded-lg shadow-md p-6">
            <h5 class="text-lg font-semibold">Total Siswa</h5>
            <p class="text-4xl font-bold">{{ $totalSiswa }}</p>
        </div>
        <div class="bg-green-500 text-white rounded-lg shadow-md p-6">
            <h5 class="text-lg font-semibold">Total Guru</h5>
            <p class="text-4xl font-bold">{{ $totalGuru }}</p>
        </div>
        <div class="bg-yellow-500 text-white rounded-lg shadow-md p-6">
            <h5 class="text-lg font-semibold">Total Sekolah</h5>
            <p class="text-4xl font-bold">{{ $totalSekolah }}</p>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Input Nilai
            </button>
            <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Absensi
            </button>
            <button class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                Jadwal Mengajar
            </button>
        </div>
    </div>
</div>
@endsection