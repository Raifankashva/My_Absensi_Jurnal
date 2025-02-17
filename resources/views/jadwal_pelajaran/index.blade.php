@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 flex justify-between items-center border-b">
            <h5 class="text-lg font-semibold">Jadwal Pelajaran</h5>
            <a href="{{ route('jadwal-pelajaran.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>
        <div class="p-6">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Kelas</th>
                            <th class="border px-4 py-2">Mata Pelajaran</th>
                            <th class="border px-4 py-2">Guru</th>
                            <th class="border px-4 py-2">Hari</th>
                            <th class="border px-4 py-2">Jam</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwalPelajaran as $index => $jadwal)
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2">{{ $jadwal->kelas->nama_kelas }}</td>
                            <td class="border px-4 py-2">{{ $jadwal->mata_pelajaran }}</td>
                            <td class="border px-4 py-2">{{ $jadwal->guru->nama_lengkap }}</td>
                            <td class="border px-4 py-2">{{ $jadwal->hari }}</td>
                            <td class="border px-4 py-2">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                            <td class="border px-4 py-2 flex space-x-2">
                                <a href="{{ route('jadwal-pelajaran.edit', $jadwal->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('jadwal-pelajaran.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada data jadwal pelajaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
