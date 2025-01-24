@extends('layouts.app')

@section('content')
<div class="py-12 bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-4 flex items-center shadow-lg">
                <i class="bx bx-check-circle mr-3 text-2xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-4 flex items-center shadow-lg">
                <i class="bx bx-error-circle mr-3 text-2xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-lg overflow-hidden shadow-2xl sm:rounded-2xl border border-blue-100">
            <div class="p-6 border-b border-blue-100 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-blue-900">Daftar Sekolah</h2>
                <a href="{{ route('sekolahs.create') }}" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition transform hover:scale-105 shadow-md">
                    <i class="bx bx-plus mr-2"></i>
                    Tambah Sekolah
                </a>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($sekolahs as $sekolah)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-blue-100 transform transition hover:scale-105 hover:shadow-2xl group">
                            <div class="p-6 relative">
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sekolah->status === 'Negeri' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $sekolah->status }}
                                    </span>
                                </div>
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                        <i class="bx bxs-school text-3xl text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-blue-900 mb-1">{{ $sekolah->nama_sekolah }}</h3>
                                        <p class="text-sm text-gray-600">NPSN: {{ $sekolah->npsn }}</p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600 mb-4 space-y-1">
                                    <p class="flex items-center">
                                        <i class="bx bx-map mr-2 text-blue-600"></i>
                                        {{ $sekolah->alamat }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="bx bx-location-plus mr-2 text-blue-600"></i>
                                        {{ $sekolah->village->name }}, {{ $sekolah->district->name }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="bx bx-globe mr-2 text-blue-600"></i>
                                        {{ $sekolah->city->name }}, {{ $sekolah->province->name }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-between border-t border-blue-100 pt-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="bx bxs-user-detail mr-2 text-blue-600"></i>
                                        {{ $sekolah->total_siswa }} Siswa
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('sekolahs.show', $sekolah) }}" class="text-blue-600 hover:text-blue-900 transition">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('sekolahs.edit', $sekolah) }}" class="text-green-600 hover:text-green-900 transition">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('sekolahs.destroy', $sekolah) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="absolute bottom-2 right-2">
                                    <img src="data:image/png;base64,{{ base64_encode($sekolah->qr_code_url) }}" alt="QR Code" class="w-12 h-12 opacity-50 group-hover:opacity-100 transition">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 bg-blue-50 rounded-lg">
                            <i class="bx bx-search-alt text-6xl text-blue-300 mb-4 block"></i>
                            <p class="text-gray-600">Tidak ada data sekolah</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $sekolahs->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection