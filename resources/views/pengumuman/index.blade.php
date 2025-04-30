@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Daftar Pengumuman</h1>
        <a href="{{ route('pengumuman.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Pengumuman</a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">Judul</th>
                    <th class="px-4 py-2 text-left">Kategori</th>
                    <th class="px-4 py-2 text-left">Tanggal Mulai</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengumuman as $item)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $item->judul }}</td>
                        <td class="px-4 py-2">{{ $item->kategori }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-3 py-1 rounded-full {{ $item->status == 'aktif' ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('pengumuman.show', $item->id) }}" class="text-blue-500 hover:text-blue-700">Lihat</a> |
                            <a href="{{ route('pengumuman.edit', $item->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a> |
                            <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
