@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6 border-b-2 border-blue-500 pb-4">
        <h1 class="text-3xl font-extrabold text-gray-800">Data Siswa</h1>
        <a href="{{ route('adminsiswa.create') }}" class="transition-all duration-300 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1">
            <i class="fas fa-plus mr-2"></i>Tambah Siswa
        </a>
    </div>

    {{-- Filter Section with Enhanced Design --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
    <a href="{{ route('siswa.export') }}" class="btn btn-success">
    Export Data Siswa
</a>
        <form action="{{ route('adminsiswa.index') }}" method="GET" class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sekolah</label>
                <select name="sekolah_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    <option value="">Semua Sekolah</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ request('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                <select name="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    <option value="">Semua Kelas</option>
                    @foreach($allKelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Group by School with Enhanced Design --}}
    @forelse($groupedStudents as $sekolah)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-100 to-blue-200 px-6 py-4 border-b border-blue-200">
            <h2 class="text-2xl font-bold text-blue-800">{{ $sekolah->nama_sekolah }}</h2>
        </div>
        
        {{-- Group by Class --}}
        @foreach($sekolah->kelas as $kelas)
        @if($kelas->siswa->count() > 0)
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Kelas: {{ $kelas->nama_kelas }}</h3>
            <div class="overflow-x-auto">
            <form action="{{ route('adminsiswa.download-qrcodes') }}" method="POST">
    @csrf
    <div class="mb-4">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            Download Selected QR Codes
        </button>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3">
                    <input type="checkbox" id="select-all" class="form-checkbox">
                </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
            @foreach($kelas->siswa as $siswa)
            <tr>
                <td class="px-6 py-4">
                    <input type="checkbox" name="selected_students[]" value="{{ $siswa->id }}" class="form-checkbox student-checkbox">
                </td>        <td class="px-6 py-4 whitespace-nowrap">
                                @if($siswa->foto)
                                    <img src="{{ Storage::url(''.$siswa->foto) }}" 
                                         alt="Foto {{ $siswa->nama_lengkap }}"
                                         class="h-12 w-12 rounded-full object-cover border-2 border-blue-200 shadow-md">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $siswa->nisn }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $siswa->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $siswa->jenis_kelamin == 'laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $siswa->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $siswa->village->name }}, 
                                {{ $siswa->district->name }}, 
                                {{ $siswa->city->name }}
                            </td>
                            </form>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('adminsiswa.show', $siswa->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('adminsiswa.edit', $siswa->id) }}" class="text-yellow-600 hover:text-yellow-900 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('adminsiswa.destroy', $siswa->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="sm:hidden">
        @foreach($kelas->siswa as $siswa)
        <div x-data="{ open: false }" class="mb-4 bg-white rounded-lg shadow">
            {{-- Mobile Header - Always visible --}}
            <div @click="open = !open" class="p-4 flex items-center justify-between cursor-pointer">
                <div class="flex items-center space-x-3">
                    @if($siswa->foto)
                        <img src="{{ Storage::url(''.$siswa->foto) }}" 
                             alt="Foto {{ $siswa->nama_lengkap }}"
                             class="h-10 w-10 rounded-full object-cover border-2 border-blue-200 shadow-sm">
                    @else
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <span class="font-medium text-gray-900">{{ $siswa->nama_lengkap }}</span>
                </div>
                <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
            </div>

            {{-- Mobile Details - Expandable content --}}
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="border-t border-gray-200">
                <div class="p-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">NISN</span>
                        <span class="text-sm text-gray-900">{{ $siswa->nisn }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Jenis Kelamin</span>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $siswa->jenis_kelamin == 'laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $siswa->jenis_kelamin }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Alamat</span>
                        <span class="text-sm text-gray-900 text-right">
                            {{ $siswa->village->name }}, 
                            {{ $siswa->district->name }}, 
                            {{ $siswa->city->name }}
                        </span>
                    </div>
                    <div class="flex justify-end space-x-3 pt-2">
                        <a href="{{ route('adminsiswa.show', $siswa->id) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('adminsiswa.edit', $siswa->id) }}" class="text-yellow-600 hover:text-yellow-900">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('adminsiswa.destroy', $siswa->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
        </div>
        @endif
        @endforeach
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 text-center">
        <div class="mb-4">
            <i class="fas fa-folder-open text-6xl text-gray-300"></i>
        </div>
        <p class="text-gray-500 text-lg">Tidak ada data siswa yang ditemukan.</p>
    </div>
    @endforelse
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');

    selectAll.addEventListener('change', function() {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    });
});
</script>
@endsection

