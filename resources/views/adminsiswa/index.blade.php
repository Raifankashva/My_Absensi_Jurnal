@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Siswa</h1>
        <a href="{{ route('adminsiswa.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Siswa
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @foreach($sekolah as $school)
    <div class="bg-white shadow-md rounded-lg mb-6">
        <div class="bg-gray-100 px-6 py-4 rounded-t-lg">
            <h2 class="text-xl font-semibold">{{ $school->nama_sekolah }}</h2>
        </div>
        
        @foreach($sekolah->kelas as $class)
        <div class="p-4">
            <h3 class="text-lg font-medium mb-4 bg-gray-50 p-2">Kelas: {{ $class->nama_kelas }}</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">NISN</th>
                            <th class="px-4 py-2 text-left">NIS</th>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Jenis Kelamin</th>
                            <th class="px-4 py-2 text-left">Alamat</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($class->dataSiswa as $student)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $student->nisn }}</td>
                            <td class="px-4 py-2">{{ $student->nis }}</td>
                            <td class="px-4 py-2">{{ $student->nama }}</td>
                            <td class="px-4 py-2">{{ $student->jenis_kelamin }}</td>
                            <td class="px-4 py-2">{{ $student->user->alamat }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('adminsiswa.show', $student) }}" class="text-blue-600 hover:text-blue-900 mx-1">
                                    Detail
                                </a>
                                <a href="{{ route('adminsiswa.edit', $student) }}" class="text-yellow-600 hover:text-yellow-900 mx-1">
                                    Edit
                                </a>
                                <form action="{{ route('adminsiswa.destroy', $student) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 mx-1" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr class="border-t">
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                Tidak ada siswa di kelas ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
@endsection