@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h1 class="text-xl font-semibold text-gray-800">Daftar Sekolah</h1>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-2">
                    <a href="{{ route('adminsekolah.index', ['export' => 'pdf'] + request()->all()) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Ekspor PDF
                    </a>
                    <a href="{{ route('adminsekolah.index', ['export' => 'excel'] + request()->all()) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Ekspor Excel
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="mx-6 mt-4 flex bg-green-50 rounded-md p-4 border-l-4 border-green-500" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button @click="show = false" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filter Panel -->
            <div class="p-4 sm:p-6">
                <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden mb-6">
                    <div class="px-4 py-3 bg-gray-100 border-b border-gray-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <h2 class="text-sm font-medium text-gray-700">Filter Data</h2>
                    </div>
                    <div class="p-4">
                        <form method="GET" action="{{ route('adminsekolah.index') }}" id="filter-form" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                
                                <div>
                                    <label for="jenjang" class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
                                    <select name="jenjang" id="jenjang" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Semua Jenjang --</option>
                                        <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="SMK" {{ request('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Semua Status --</option>
                                        <option value="Negeri" {{ request('status') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                        <option value="Swasta" {{ request('status') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari (Nama/NPSN)</label>
                                    <div class="flex">
                                        <div class="relative flex-grow">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                            <input type="text" name="search" id="search" class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ request('search') }}" placeholder="Cari nama sekolah atau NPSN...">
                                        </div>
                                        <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            Cari
                                        </button>
                                        <a href="{{ route('adminsekolah.index') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Total Sekolah</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalSchools ?? $schools->total() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Sekolah Aktif</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $activeSchools ?? $schools->where('is_active', 1)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Sekolah Non-Aktif</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $inactiveSchools ?? $schools->where('is_active', 0)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Terakhir Diperbarui</p>
                                <p class="text-sm font-bold text-gray-800">{{ $lastUpdated ?? now()->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NPSN</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Sekolah</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenjang</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provinsi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kabupaten/Kota</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Aktif</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($schools as $index => $school)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ($schools->currentPage() - 1) * $schools->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $school->npsn }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $school->nama_sekolah }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $school->jenjang == 'SD' ? 'bg-blue-100 text-blue-800' : 
                                           ($school->jenjang == 'SMP' ? 'bg-purple-100 text-purple-800' : 
                                           ($school->jenjang == 'SMA' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-pink-100 text-pink-800')) }}">
                                        {{ $school->jenjang }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $school->status == 'Negeri' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ $school->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $school->province ? $school->province->name : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $school->city ? $school->city->name : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $school->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $school->is_active ? 'bg-green-600' : 'bg-red-600' }} mr-1.5"></span>
                                        {{ $school->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex space-x-1">
                                        <a href="{{ route('adminsekolah.show', $school->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-1.5 rounded-md transition-colors" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('adminsekolah.edit', $school->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-md transition-colors" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('adminsekolah.toggle-active', $school->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="{{ $school->is_active ? 'text-amber-600 hover:text-amber-900 bg-amber-50 hover:bg-amber-100' : 'text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100' }} p-1.5 rounded-md transition-colors" title="{{ $school->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @if($school->is_active)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                                @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                @endif
                                            </button>
                                        </form>
                                        <form action="{{ route('adminsekolah.destroy', $school->id) }}" method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-10 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-gray-500 text-base">Tidak ada data sekolah.</p>
                                        <p class="text-gray-400 text-sm mt-1">Coba ubah filter pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-5 flex justify-center">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $schools->appends(request()->except('page'))->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js for interactive components -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi hapus dengan modal
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('Apakah Anda yakin ingin menghapus sekolah ini?')) {
                    this.submit();
                }
            });
        });

        // Provinsi - Kota dependensi
        const provinceSelect = document.getElementById('province_id');
        if (provinceSelect) {
            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;
                const citySelect = document.getElementById('city_id');
                
                if (provinceId) {
                    // Show loading indicator
                    citySelect.innerHTML = '<option value="">Loading...</option>';
                    
                    fetch(`/admin/get-cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option value="">-- Semua Kabupaten/Kota --</option>';
                            data.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching cities:', error);
                            citySelect.innerHTML = '<option value="">-- Error loading cities --</option>';
                        });
                } else {
                    citySelect.innerHTML = '<option value="">-- Semua Kabupaten/Kota --</option>';
                }
                
                // Auto submit form when province changes
                document.getElementById('filter-form').submit();
            });
        }

        // Auto submit form when filter changes
        const autoSubmitFilters = ['city_id', 'jenjang', 'status'];
        autoSubmitFilters.forEach(filterId => {
            const element = document.getElementById(filterId);
            if (element) {
                element.addEventListener('change', function() {
                    document.getElementById('filter-form').submit();
                });
            }
        });
    });
</script>
@endsection
