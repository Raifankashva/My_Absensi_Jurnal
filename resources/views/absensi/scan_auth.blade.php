@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <div class="border-b pb-4 mb-4">
            <h4 class="text-xl font-semibold text-gray-800">Akses Scan QR - {{ $sekolah->nama_sekolah }}</h4>
        </div>
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <form method="GET" action="{{ route('absensi.scan') }}" class="space-y-4">
            <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">
            
            <div>
                <label for="token" class="block text-gray-700 font-medium">Token Akses untuk {{ $sekolah->nama_sekolah }}:</label>
                <input type="password" id="token" name="token" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md w-full">
                    Masuk
                </button>
            </div>
            
            <div class="text-center">
                <a href="{{ route('absensi.select.school') }}" class="text-blue-500 hover:underline">Ganti Sekolah</a>
            </div>
        </form>
    </div>
</div>
@endsection
