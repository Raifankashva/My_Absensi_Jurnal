@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-semibold mb-4">Daftar Siswa</h1>
        
        <a href="{{ route('adminsiswa.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Siswa</a>
        
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Nama Lengkap</th>
                    <th class="border border-gray-300 px-4 py-2">Sekolah</th>
                    <th class="border border-gray-300 px-4 py-2">Kelas</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $student)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $student->nama_lengkap }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $student->sekolah->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $student->kelas->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('adminsiswa.show', $student) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Lihat</a>
                            <a href="{{ route('adminsiswa.edit', $student) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>
                            <form action="{{ route('adminsiswa.destroy', $student) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $siswa->links() }} <!-- Pagination -->
        </div>
    </div>
@endsection
