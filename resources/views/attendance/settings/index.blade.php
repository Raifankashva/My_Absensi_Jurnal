@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-xl mb-6 p-4 sm:p-6 transition-all duration-300 hover:shadow-2xl">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 relative">
                Pengaturan Absensi
                <div class="h-1 w-20 bg-blue-500 rounded-full mt-1"></div>
            </h2>

            <a href="{{ route('attendance.settings.create') }}" 
               class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Pengaturan
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @foreach($settings as $setting)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-semibold text-lg">{{ substr($setting->sekolah->nama_sekolah, 0, 1) }}</span>
                            </div>
                            <h3 class="font-semibold text-lg text-gray-800">{{ $setting->sekolah->nama_sekolah }}</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $setting->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $setting->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-sm text-gray-500 mb-1">Jam Masuk</div>
                            <div class="flex items-center gap-2 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($setting->jam_masuk)->format('H:i') }}
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-sm text-gray-500 mb-1">Batas Telat</div>
                            <div class="flex items-center gap-2 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($setting->batas_telat)->format('H:i') }}
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-sm text-gray-500 mb-1">Jam Pulang</div>
                            <div class="flex items-center gap-2 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($setting->jam_pulang)->format('H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="text-sm text-gray-500 mb-2">Hari Aktif</div>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $hariMap = [
                                    '1' => 'Minggu',
                                    '2' => 'Senin',
                                    '3' => 'Selasa',
                                    '4' => 'Rabu',
                                    '5' => 'Kamis',
                                    '6' => 'Jumat',
                                    '7' => 'Sabtu'
                                ];
                            @endphp
                            @foreach($setting->hari_aktif as $hari)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                    {{ $hariMap[$hari] ?? $hari }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500">Token:</span>
                            <span class="font-mono text-sm bg-gray-100 px-3 py-1 rounded">{{ $setting->token }}</span>
                            <button class="text-gray-400 hover:text-blue-600 transition-colors duration-200" title="Copy Token">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                                </svg>
                            </button>
                        </div>

                        <a href="{{ route('attendance.settings.edit', $setting->id) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Pengaturan
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection