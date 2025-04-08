@extends('layouts.app')

@section('title', 'Autentikasi Scan QR')

@section('content')
<div class="max-w-md mx-auto space-y-6">
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800">Autentikasi Scan QR</h1>
        <p class="text-gray-600 mt-2">{{ $authSchool->nama }}</p>
    </div>
    
    <div class="bg-gray-50 p-6 rounded-md border border-gray-200">
        <form action="{{ route('absensi.scan') }}" method="GET" class="space-y-4">
            <div>
                <label for="token" class="block text-sm font-medium text-gray-700 mb-1">Token Akses</label>
                <input type="password" name="token" id="token" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Masukkan token akses">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center justify-center">
                <i class="fas fa-key mr-2"></i> Autentikasi
            </button>
        </form>
    </div>
    
    <div class="text-center">
        <a href="{{ route('absensi.token.management') }}" class="text-blue-600 hover:underline">
            <i class="fas fa-cog mr-1"></i> Kelola Token Akses
        </a>
    </div>
</div>
@endsection