@extends('layouts.app')

@section('content')
<div class="py-12 bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 backdrop-blur-lg shadow-2xl sm:rounded-2xl border border-blue-100 overflow-hidden">
            <div class="p-6 bg-blue-50 border-b border-blue-200 flex flex-col md:flex-row justify-between items-center">
                <h1 class="text-2xl font-bold text-blue-900 mb-4 md:mb-0">Manajemen Kelas</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('kelas.create') }}" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition transform hover:scale-105 shadow-md">
                        <i class="bx bx-plus mr-2"></i>
                        Tambah Kelas Baru
                    </a>
                </div>
            </div>

            {{-- Filter Section --}}
            <div class="p-6 bg-white/50 backdrop-blur-sm">
                <form action="{{ route('kelas.index') }}" method="GET" class="grid md:grid-cols-4 gap-4">
                    <div>
                        <label for="sekolah" class="block text-sm font-medium text-blue-900 mb-1">Sekolah</label>
                        <select name="sekolah" id="sekolah" class="w-full px-3 py-2 border border-blue-300 rounded-md focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="">Semua Sekolah</option>
                            @foreach(\App\Models\Sekolah::all() as $sekolah)
                                <option value="{{ $sekolah->id }}" {{ request('sekolah') == $sekolah->id ? 'selected' : '' }}>
                                    {{ $sekolah->nama_sekolah }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="tingkat" class="block text-sm font-medium text-blue-900 mb-1">Tingkat</label>
                        <select name="tingkat" id="tingkat" class="w-full px-3 py-2 border border-blue-300 rounded-md focus:ring-2 focus:ring-blue-500 bg-white">
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
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition transform hover:scale-105">
                            <i class="bx bx-filter-alt mr-2"></i>Filter
                        </button>
                        <a href="{{ route('kelas.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg transition transform hover:scale-105">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-3 flex items-center">
                <i class="bx bx-check-circle mr-3 text-2xl"></i>
                {{ session('success') }}
            </div>
            @endif

            @php
                $sekolahs = $kelas->groupBy('sekolah_id');
            @endphp

            <div class="p-6 space-y-6">
                @forelse($sekolahs as $sekolah_id => $kelasPerSekolah)
                    @php
                        $sekolah = $kelasPerSekolah->first()->sekolah;
                    @endphp
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                        <div class="bg-blue-50 px-6 py-4 border-b border-blue-200 flex justify-between items-center">
                            <h2 class="text-xl font-bold text-blue-900">
                                <i class="bx bxs-school mr-2 text-blue-600"></i>
                                {{ $sekolah->nama_sekolah }}
                            </h2>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                Total Kelas: {{ $kelasPerSekolah->count() }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                            @foreach($kelasPerSekolah as $item)
                                <div class="bg-white rounded-2xl border border-blue-100 shadow-md hover:shadow-2xl transition transform hover:scale-105 group">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-blue-900 mb-1">{{ $item->nama_kelas }}</h3>
                                                <span class="text-sm text-blue-600 bg-blue-50 px-2 py-1 rounded">
                                                    Tingkat {{ $item->tingkat }}
                                                </span>
                                            </div>
                                            @if($item->jurusan)
                                                <span class="text-sm text-blue-700 bg-blue-100 px-2 py-1 rounded">
                                                    {{ $item->jurusan }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="text-sm text-gray-600 space-y-2 mb-4">
                                            <div class="flex items-center">
                                                <i class="bx bx-calendar mr-2 text-blue-600"></i>
                                                Tahun Ajaran: {{ $item->tahun_ajaran }}
                                            </div>
                                            <div class="flex items-center">
                                                <i class="bx bx-book mr-2 text-blue-600"></i>
                                                Semester: {{ $item->semester }}
                                            </div>
                                            <div class="flex items-center">
                                                <i class="bx bxs-user-detail mr-2 text-blue-600"></i>
                                                Kapasitas: {{ $item->kapasitas }} Siswa
                                            </div>
                                            <div class="flex items-center">
                                                <i class="bx bx-user-plus mr-2 text-blue-600"></i>
                                                Sisa Kapasitas: {{ $item->sisa_kapasitas }} Siswa
                                            </div>
                                        </div>
                                        
                                        <div class="flex justify-between items-center border-t border-blue-100 pt-4">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('kelas.show', $item->id) }}" class="text-blue-500 hover:text-blue-700 transition">
                                                    <i class="bx bx-show text-xl"></i>
                                                </a>
                                                <a href="{{ route('kelas.edit', $item->id) }}" class="text-green-500 hover:text-green-700 transition">
                                                    <i class="bx bx-edit text-xl"></i>
                                                </a>
                                                <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-500 hover:text-red-700 transition">
                                                        <i class="bx bx-trash text-xl"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                        <i class="bx bx-search-alt text-6xl text-blue-300 mb-4 block"></i>
                        <p class="text-gray-600 text-lg">Tidak ada kelas yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="p-6 bg-blue-50 border-t border-blue-200 flex justify-center">
                {{ $kelas->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection