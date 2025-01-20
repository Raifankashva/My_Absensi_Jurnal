@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Data Guru</h2>
            <a href="{{ route('adminguru.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Tambah Guru
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Group teachers by school --}}
        @php
            $groupedGuru = $guru->groupBy('sekolah.nama_sekolah');
        @endphp

        @forelse($groupedGuru as $sekolahNama => $guruList)
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $sekolahNama }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Total Guru: {{ $guruList->count() }}
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($guruList as $guru)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($guru->foto)
                                    <img src="{{ Storage::url('foto/guru/'.$guru->foto) }}" 
                                         alt="Foto {{ $guru->nama_lengkap }}"
                                         class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500 text-sm">No Foto</span>
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
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                    {{ $guru->status_kepegawaian }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('adminguru.show', $guru) }}" 
                                       class="text-blue-600 hover:text-blue-900">Detail</a>
                                    <a href="{{ route('adminguru.edit', $guru) }}" 
                                       class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('adminguru.destroy', $guru) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900">
                                            Hapus
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
        <div class="bg-white shadow-sm rounded-lg p-6 text-center">
            <p class="text-gray-500">Tidak ada data guru yang tersedia.</p>
        </div>
        @endforelse

    </div>
</div>
@endsection
