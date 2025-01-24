@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Add School Button -->
                <div class="mb-6">
                    <a href="{{ route('sekolahs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Tambah Sekolah
                    </a>
                </div>

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($sekolahs as $sekolah)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $sekolah->nama_sekolah }}             <img src="data:image/png;base64,{{ base64_encode($sekolah->qr_code_url) }}" alt="QR Code">
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sekolah->status === 'Negeri' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $sekolah->status }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">NPSN: {{ $sekolah->npsn }}</p>
                                <p class="text-sm text-gray-600 mb-4">Jenjang: {{ $sekolah->jenjang }}</p>
                                <div class="text-sm text-gray-600 mb-4">
                                    <p>{{ $sekolah->alamat }},</p>
                                    <p>{{ $sekolah->village->name }}, {{ $sekolah->district->name }},</p>
                                    <p>{{ $sekolah->city->name }}, {{ $sekolah->province->name }}</p>
                                </div>
                                <div class="border-t border-gray-200">
                                {{ $sekolah->total_siswa }} Siswa
                                </div>
                                <div class="flex justify-end space-x-2 mt-4">
                                    <a href="{{ route('sekolahs.show', $sekolah) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    <a href="{{ route('sekolahs.edit', $sekolah) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                    <form action="{{ route('sekolahs.destroy', $sekolah) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-4 text-gray-500">
                            Tidak ada data sekolah
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $sekolahs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection