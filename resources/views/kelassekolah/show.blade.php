@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Detail Kelas</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('kelassekolah.edit', $kelas->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <a href="{{ route('kelassekolah.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg flex items-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi Kelas
                            </h3>
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-500 bg-gray-50 w-1/3">Nama Kelas</td>
                                            <td class="px-4 py-3 text-sm font-medium">{{ $kelas->nama_kelas }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-500 bg-gray-50">Tingkat</td>
                                            <td class="px-4 py-3 text-sm font-medium">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Tingkat {{ $kelas->tingkat }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-500 bg-gray-50">Jurusan</td>
                                            <td class="px-4 py-3 text-sm font-medium">{{ $kelas->jurusan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-500 bg-gray-50">Wali Kelas</td>
                                            <td class="px-4 py-3 text-sm font-medium flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $kelas->wali_kelas ?? '-' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Kapasitas & Tahun Ajaran
                            </h3>
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-500 bg-gray-50 w-1/2">Kapasitas</td>
                                            <td class="px-4 py-3 text-sm font-medium flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                {{ $kelas->kapasitas }} siswa
                                            </td>
                                        </tr>
                                        @if(isset($kelas->remaining_capacity))
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-500 bg-gray-50">Sisa Kapasitas</td>
                                            <td class="px-4 py-3 text-sm font-medium">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $kelas->remaining_capacity > 5 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $kelas->remaining_capacity }} siswa
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-500 bg-gray-50">Tahun Ajaran</td>
                                            <td class="px-4 py-3 text-sm font-medium flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $kelas->tahun_ajaran }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-500 bg-gray-50">Semester</td>
                                            <td class="px-4 py-3 text-sm font-medium">{{ $kelas->semester }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Siswa -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Daftar Siswa
                    </h3>
                    
                    @if(count($kelas->siswa) > 0)
                        <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($kelas->siswa as $index => $siswa)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $siswa->nis }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                    {{ $siswa->jenis_kelamin }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 bg-gray-50 rounded-lg border border-gray-100 text-center shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-lg font-medium text-gray-700">Belum ada siswa yang terdaftar di kelas ini.</p>
                            <p class="text-sm text-gray-500 mt-1">Silakan tambahkan siswa ke kelas ini melalui menu Siswa.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

