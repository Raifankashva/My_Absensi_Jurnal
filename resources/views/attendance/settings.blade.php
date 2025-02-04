@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Pengaturan Absensi Sekolah</h2>
        </div>
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('attendance.settings.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="sekolah_id" class="block text-sm font-medium text-gray-700">Sekolah</label>
                    <select name="sekolah_id" id="sekolah_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @foreach($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Jam Mulai Absensi</label>
                    <input type="time" name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block text-sm font-medium text-gray-700">Jam Akhir Absensi</label>
                    <input type="time" name="end_time" id="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="late_threshold" class="block text-sm font-medium text-gray-700">Batas Waktu Terlambat</label>
                    <input type="time" name="late_threshold" id="late_threshold" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="attendance_token" class="block text-sm font-medium text-gray-700">Token Absensi</label>
                    <input type="text" name="attendance_token" id="attendance_token" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="attendance_type" class="block text-sm font-medium text-gray-700">Tipe Absensi</label>
                    <select name="attendance_type" id="attendance_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="qr">QR Code</option>
                        <option value="manual">Manual</option>
                        <option value="both">QR & Manual</option>
                    </select>
                </div>

                <div class="mb-4 flex items-center">
                <input type="hidden" name="is_active" value="0">
<input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ old('is_active', $settings->is_active ?? false) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktifkan Absensi</label>
                    </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection