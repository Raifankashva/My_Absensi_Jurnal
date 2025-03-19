@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Data Guru</h1>
                    
                    <a href="{{ route('adminguru.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-200">
                        Tambah Guru
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto mt-6">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left">No</th>
                                <th class="py-3 px-4 text-left">Foto</th>
                                <th class="py-3 px-4 text-left">NIP</th>
                                <th class="py-3 px-4 text-left">Nama</th>
                                <th class="py-3 px-4 text-left">Sekolah</th>
                                <th class="py-3 px-4 text-left">Mata Pelajaran</th>
                                <th class="py-3 px-4 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($guru as $index => $g)
                                <tr>
                                    <td class="py-3 px-4">{{ $guru->firstItem() + $index }}</td>
                                    <td class="py-3 px-4">
                                        @if($g->foto)
                                            <img src="{{ asset('storage/guru-photos/'.$g->foto) }}" alt="{{ $g->nama_lengkap }}" class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-gray-500">No Image</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $g->nip ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">{{ $g->nama_lengkap }}</td>
                                    <td class="py-3 px-4">{{ $g->sekolah->nama_sekolah ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">
                                        @php
                                            $mapel = json_decode($g->mata_pelajaran, true);
                                        @endphp
                                        @if(is_array($mapel))
                                            {{ implode(', ', array_slice($mapel, 0, 2)) }}
                                            @if(count($mapel) > 2)
                                                <span class="text-gray-500">...</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('adminguru.show', $g->id) }}" class="px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600">
                                                Detail
                                            </a>
                                            <a href="{{ route('adminguru.edit', $g->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            <form action="{{ route('adminguru.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-3 px-4 text-center text-gray-500">
                                        Data guru tidak tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $guru->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection