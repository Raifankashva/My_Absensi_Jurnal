@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-3xl bg-white shadow-lg rounded-lg p-6">
        <div class="border-b pb-4 mb-4 flex justify-between items-center">
            <h4 class="text-xl font-semibold text-gray-800">Manajemen Token Akses - {{ $sekolah->nama_sekolah }}</h4>
            <a href="{{ route('absensi.select.school') }}" class="text-sm text-blue-500 hover:underline">Ganti Sekolah</a>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white shadow-md rounded-lg p-4 border">
                <h5 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Buat Token Baru</h5>
                <form method="POST" action="{{ route('absensi.token.create') }}">
                    @csrf
                    <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">
                    <div class="mb-3">
                        <label for="token" class="block text-gray-700">Token Baru:</label>
                        <input type="text" id="token" name="token" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300" required minlength="8">
                        <small class="text-gray-500">Minimal 8 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label for="admin_password" class="block text-gray-700">Password Admin:</label>
                        <input type="password" id="admin_password" name="admin_password" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">Buat Token</button>
                </form>
            </div>
            
            <div class="bg-white shadow-md rounded-lg p-4 border">
                <h5 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Update Token</h5>
                <form method="POST" action="{{ route('absensi.token.update') }}">
                    @csrf
                    <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">
                    <div class="mb-3">
                        <label for="current_token" class="block text-gray-700">Token Saat Ini:</label>
                        <input type="text" id="current_token" name="current_token" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_token" class="block text-gray-700">Token Baru:</label>
                        <input type="text" id="new_token" name="new_token" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300" required minlength="8">
                        <small class="text-gray-500">Minimal 8 karakter</small>
                    </div>
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md">Update Token</button>
                </form>
            </div>
        </div>
        
        <div class="mt-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            <strong>Catatan:</strong>
            <ul class="list-disc pl-5">
                <li>Token digunakan untuk mengakses fitur scan QR absensi untuk sekolah ini</li>
                <li>Untuk mengubah token, Anda harus mengetahui token saat ini</li>
                <li>Jangan bagikan token dengan pihak yang tidak berwenang</li>
            </ul>
        </div>
    </div>
</div>
@endsection
