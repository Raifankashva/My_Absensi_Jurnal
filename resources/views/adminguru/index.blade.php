@extends('layouts.app')

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6 border-b-2 border-blue-500 pb-4">
            <h2 class="text-3xl font-extrabold text-gray-800">Data Guru</h2>
            <a href="{{ route('adminguru.create') }}" class="transition-all duration-300 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-plus mr-2"></i>Tambah Guru
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r-lg" role="alert">
            <div class="flex">
                <div class="py-1">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                </div>
                <div>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Group teachers by school --}}
        @php
            $groupedGuru = $guru->groupBy('sekolah.nama_sekolah');
        @endphp

        @forelse($groupedGuru as $sekolahNama => $guruList)
        <div class="bg-white shadow-lg rounded-xl border border-gray-100 mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-100 to-blue-200 px-6 py-5 border-b border-blue-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-blue-800">{{ $sekolahNama }}</h3>
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                        Total Guru: {{ $guruList->count() }}
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($guruList as $guru)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($guru->foto)
                                    <img src="{{ Storage::url('foto/guru/'.$guru->foto) }}" 
                                         alt="Foto {{ $guru->nama_lengkap }}"
                                         class="h-12 w-12 rounded-full object-cover border-2 border-blue-200 shadow-md">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $guru->nama_lengkap }}</div>
                                <div class="text-sm text-gray-500">{{ $guru->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $guru->nip ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @if(is_array($guru->mata_pelajaran))
                                        {{ implode(', ', $guru->mata_pelajaran) }}
                                    @else
                                        {{ $guru->mata_pelajaran }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @switch($guru->status_kepegawaian)
                                        @case('PNS')
                                            bg-green-100 text-green-800
                                            @break
                                        @case('PPPK')
                                            bg-blue-100 text-blue-800
                                            @break
                                        @case('Honorer')
                                            bg-yellow-100 text-yellow-800
                                            @break
                                        @default
                                            bg-gray-100 text-gray-800
                                    @endswitch
                                ">
                                    <i class="fas fa-circle mr-1 text-current"></i>
                                    {{ $guru->status_kepegawaian }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('adminguru.show', $guru) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('adminguru.edit', $guru) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('adminguru.destroy', $guru) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="bg-white shadow-lg rounded-xl border border-gray-100 p-8 text-center">
            <div class="mb-4">
                <i class="fas fa-folder-open text-6xl text-gray-300"></i>
            </div>
            <p class="text-gray-500 text-lg">Tidak ada data guru yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection