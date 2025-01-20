@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Guru</h1>
        <a href="{{ route('adminguru.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            Tambah Guru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($guru as $item)
        <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition hover:scale-105 hover:shadow-xl">
            <div class="relative">
                <div class="h-48 bg-blue-100 flex items-center justify-center">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_lengkap }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-blue-500 flex items-center justify-center w-full h-full">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                    {{ $item->sekolah->nama_sekolah }}
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item->nama_lengkap }}</h3>
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5 8.11V14a1 1 0 00.553.894l4 2A1 1 0 0010 16V8.11l2.394-1.021a1 1 0 000-1.84l-7-3z"/>
                        </svg>
                        <span>NIP: {{ $item->nip ?? '-' }}</span>
                    </div>
                </div>

                <div class="flex justify-between space-x-2">
                    <a href="{{ route('adminguru.show', $item) }}" class="w-full bg-blue-50 text-blue-600 py-2 rounded-lg text-center hover:bg-blue-100 transition">
                        Detail
                    </a>
                    <a href="{{ route('adminguru.edit', $item) }}" class="w-full bg-green-50 text-green-600 py-2 rounded-lg text-center hover:bg-green-100 transition">
                        Edit
                    </a>
                    <form action="{{ route('adminguru.destroy', $item) }}" method="POST" class="w-full" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-50 text-red-600 py-2 rounded-lg hover:bg-red-100 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8 flex justify-center">
        {{ $guru->links() }}
    </div>
</div>
@endsection