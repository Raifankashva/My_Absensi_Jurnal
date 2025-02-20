@extends('layouts.app')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Jadwal Pelajaran</h2>
                        <a href="{{ route('jadwal-pelajaran.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Tambah Jadwal
                        </a>
                    </div>

                    <!-- Filters -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form action="{{ route('jadwal-pelajaran.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Class Filter -->
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Filter Kelas</label>
                                <select name="kelas_id" id="kelas_id" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        onchange="this.form.submit()">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Day Filter -->
                            <div>
                                <label for="hari" class="block text-sm font-medium text-gray-700 mb-1">Filter Hari</label>
                                <select name="hari" id="hari" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        onchange="this.form.submit()">
                                    <option value="">Semua Hari</option>
                                    @foreach($hariList as $hari)
                                        <option value="{{ $hari }}" {{ request('hari') == $hari ? 'selected' : '' }}>
                                            {{ $hari }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Reset Filter -->
                            @if(request('kelas_id') || request('hari'))
                                <div class="flex items-end">
                                    <a href="{{ route('jadwal-pelajaran.index') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                        Reset Filter
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- Schedule Cards -->
                    <div class="space-y-6">
                        @forelse($jadwalPerKelas as $namaKelas => $jadwalKelas)
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b">
                                    <h3 class="text-lg font-medium text-gray-900">Kelas {{ $namaKelas }}</h3>
                                </div>
                                <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($jadwalKelas->sortBy('hari')->sortBy('jam_mulai') as $jadwal)
                                        <div class="bg-white rounded-lg border shadow-sm hover:shadow-md transition-shadow duration-200">
                                            <div class="p-4">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-lg font-semibold text-gray-900">{{ $jadwal->mata_pelajaran }}</h4>
                                                        <p class="text-sm text-gray-600">{{ $jadwal->guru->nama_lengkap }}</p>
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('jadwal-pelajaran.edit', $jadwal->id) }}" 
                                                           class="text-blue-600 hover:text-blue-800">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('jadwal-pelajaran.destroy', $jadwal->id) }}" 
                                                              method="POST" 
                                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');"
                                                              class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        {{ $jadwal->hari }}
                                                    </div>
                                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-gray-500">Tidak ada jadwal pelajaran yang ditemukan</div>
                                @if(request('kelas_id') || request('hari'))
                                    <div class="mt-2">
                                        <a href="{{ route('jadwal-pelajaran.index') }}" class="text-indigo-600 hover:text-indigo-800">
                                            Hapus filter untuk melihat semua jadwal
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add smooth fade-in animation for cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bg-white.rounded-lg.border');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.3s ease-in-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endsection