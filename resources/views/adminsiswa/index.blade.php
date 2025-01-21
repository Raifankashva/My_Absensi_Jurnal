{{-- resources/views/datasiswa/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Siswa</h1>
        <a href="{{ route('adminsiswa.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Siswa
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form action="{{ route('adminsiswa.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700">Sekolah</label>
                <select name="sekolah_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Sekolah</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ request('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($allKelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Group by School --}}
    @forelse($groupedStudents as $sekolah)
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="bg-gray-100 px-6 py-4 rounded-t-lg">
            <h2 class="text-xl font-bold">{{ $sekolah->nama_sekolah }}</h2>
        </div>
        
        {{-- Group by Class --}}
        @foreach($sekolah->kelas as $kelas)
        @if($kelas->siswa->count() > 0)
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Kelas: {{ $kelas->nama_kelas }}</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($kelas->siswa as $siswa)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nisn }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->jenis_kelamin }}</td>
                            <td class="px-6 py-4">
                                {{ $siswa->village->name }}, 
                                {{ $siswa->district->name }}, 
                                {{ $siswa->city->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('adminsiswa.show', $siswa->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                                <a href="{{ route('adminsiswa.edit', $siswa->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                <form action="{{ route('adminsiswa.destroy', $siswa->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <p class="text-gray-500">Tidak ada data siswa yang ditemukan.</p>
    </div>
    @endforelse
</div>
@endsection