@extends('layouts.app')

@section('title', 'Manajemen Token')

@section('content')
<div class="max-w-md mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Token QR</h1>
        <a href="{{ route('absensi.scan.logout') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
        </a>
    </div>
    
    <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
        <h2 class="text-lg font-semibold text-blue-800 flex items-center">
            <i class="fas fa-info-circle mr-2"></i> Informasi Sekolah
        </h2>
        <p class="mt-2 text-blue-700">{{ $authSchool->nama }}</p>
    </div>
    
    @if($tokenExists)
    <div class="bg-gray-50 p-6 rounded-md border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Perbarui Token</h2>
        <form action="{{ route('absensi.token.update') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="current_token" class="block text-sm font-medium text-gray-700 mb-1">Token Saat Ini</label>
                <input type="password" name="current_token" id="current_token" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>
            
            <div>
                <label for="new_token" class="block text-sm font-medium text-gray-700 mb-1">Token Baru</label>
                <input type="password" name="new_token" id="new_token" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" minlength="8">
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center justify-center">
                <i class="fas fa-sync-alt mr-2"></i> Perbarui Token
            </button>
        </form>
    </div>
    @else
    <div class="bg-gray-50 p-6 rounded-md border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Buat Token Baru</h2>
        <form action="{{ route('absensi.createToken') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="token" class="block text-sm font-medium text-gray-700 mb-1">Token Akses</label>
                <input type="password" name="token" id="token" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" minlength="8">
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
            </div>
            
            <div>
                <label for="admin_password" class="block text-sm font-medium text-gray-700 mb-1">Password Admin</label>
                <input type="password" name="admin_password" id="admin_password" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center justify-center">
                <i class="fas fa-key mr-2"></i> Buat Token
            </button>
        </form>
    </div>
    @endif
    
    <div class="bg-yellow-50 p-4 rounded-md border border-yellow-200">
        <h2 class="text-md font-semibold text-yellow-800 flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i> Informasi Penting
        </h2>
        <p class="mt-2 text-yellow-700 text-sm">Token ini digunakan untuk mengakses fitur scan QR. Jaga kerahasiaan token dan perbarui secara berkala untuk keamanan.</p>
    </div>
</div>
@endsection