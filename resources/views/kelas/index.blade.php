@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Kelas</h1>
        <a href="{{ route('kelas.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Tambah Kelas Baru
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white shadow-md rounded-lg mb-6 p-4">
        <form action="{{ route('kelas.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-grow">
                <label for="sekolah" class="block text-sm font-medium text-gray-700 mb-1">Sekolah</label>
                <select name="sekolah" id="sekolah" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Sekolah</option>
                    @foreach(\App\Models\Sekolah::all() as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ request('sekolah') == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                <select name="tingkat" id="tingkat" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Tingkat</option>
                    @php
                        $tingkats = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                    @endphp
                    @foreach($tingkats as $tk)
                        <option value="{{ $tk }}" {{ request('tingkat') == $tk ? 'selected' : '' }}>
                            {{ $tk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Filter
                </button>
                <a href="{{ route('kelas.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded">
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @php
        $sekolahs = $kelas->groupBy('sekolah_id');
    @endphp

    @forelse($sekolahs as $sekolah_id => $kelasPerSekolah)
        @php
            $sekolah = $kelasPerSekolah->first()->sekolah;
        @endphp
        <div class="bg-white shadow-md rounded-lg mb-6">
            <div class="bg-gray-100 px-5 py-3 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $sekolah->nama_sekolah }}
                </h2>
                <span class="text-gray-600">Total Kelas: {{ $kelasPerSekolah->count() }}</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-5">
                @foreach($kelasPerSekolah as $item)
                    <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-lg font-bold text-gray-800">{{ $item->nama_kelas }}</h3>
                                <span class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                    {{ $item->tingkat }}
                                </span>
                            </div>
                            
                            <div class="text-sm text-gray-600 mb-3">
                                <p>Tahun Ajaran: {{ $item->tahun_ajaran }}</p>
                                <p>Semester: {{ $item->semester }}</p>
                                <p>Kapasitas: {{ $item->kapasitas }} Siswa</p>
                            </div>
                            
                            <div class="flex justify-between items-center border-t pt-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('kelas.show', $item->id) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('kelas.edit', $item->id) }}" class="text-green-500 hover:text-green-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @if($item->jurusan)
                                    <span class="text-sm text-gray-600 bg-blue-50 px-2 py-1 rounded">
                                        {{ $item->jurusan }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <p class="text-gray-600">Tidak ada kelas yang ditemukan.</p>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $kelas->links() }}
    </div>
</div>
@endsection