@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Jurnal Guru</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('jurnal-guru.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Jurnal
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Tanggal</th>
                    <th class="py-2 px-4 border-b">Kelas</th>
                    <th class="py-2 px-4 border-b">Materi</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurnalGuru as $jurnal)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $jurnal->tanggal }}</td>
                    <td class="py-2 px-4 border-b">{{ $jurnal->kelas->nama_kelas ?? '-' }}</td>
                    <td class="py-2 px-4 border-b">{{ $jurnal->materi_yang_disampaikan }}</td>
                    <td class="py-2 px-4 border-b">{{ $jurnal->status_pertemuan }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('jurnal-guru.show', $jurnal->id) }}" class="text-blue-500 hover:text-blue-700">Lihat</a>
                        <a href="{{ route('jurnal-guru.edit', $jurnal->id) }}" class="ml-2 text-green-500 hover:text-green-700">Edit</a>
                        <form action="{{ route('jurnal-guru.destroy', $jurnal->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-2 text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $jurnalGuru->links() }}
    </div>
</div>
@endsection