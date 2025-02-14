@extends('layouts.app')
@section('title', 'Admin Siswa')

@section('content')
<div class="container mx-auto px-4 py-6">
@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p>{{ session('error') }}</p>
    </div>
@endif
    {{-- Header Section with Animation --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b-2 border-blue-500 pb-4">
        <div class="flex items-center space-x-3 mb-4 md:mb-0">
            <i class="fas fa-user-graduate text-3xl text-blue-600"></i>
            <h1 class="text-3xl font-extrabold text-gray-800 animate-fade-in">Data Siswa</h1>
        </div>
        <a href="{{ route('adminsiswa.create') }}" 
           class="group transition-all duration-300 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1">
            <i class="fas fa-user-plus mr-2 group-hover:rotate-12 transition-transform"></i>
            Tambah Siswa
        </a>
    </div>

    {{-- Enhanced Filter Section --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex items-center space-x-2 mb-4 md:mb-0">
                <i class="fas fa-file-export text-green-600 text-xl"></i>
                <a href="{{ route('siswa.export') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Export Data Siswa
                </a>
            </div>
            {{-- QR Code Download Button and Form --}}
<div class="flex items-center space-x-2">
    <i class="fas fa-qrcode text-purple-600 text-xl"></i>
    <button type="button" 
            id="download-qr-button"
            class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 flex items-center space-x-2">
        <i class="fas fa-download mr-2"></i>
        <span>Download QR Codes</span>
    </button>
</div>

{{-- QR Download Form --}}
<form id="qr-form" action="{{ route('adminsiswa.download-qrcodes') }}" method="POST" class="hidden">
    @csrf
</form>
        </div>

        <form action="{{ route('adminsiswa.index') }}" method="GET" 
              class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label class="flex items-center space-x-2 text-sm font-semibold text-gray-700">
                    <i class="fas fa-school text-blue-500"></i>
                    <span>Sekolah</span>
                </label>
                <select name="sekolah_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    <option value="">Semua Sekolah</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ request('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label class="flex items-center space-x-2 text-sm font-semibold text-gray-700">
                    <i class="fas fa-chalkboard text-blue-500"></i>
                    <span>Kelas</span>
                </label>
                <select name="kelas_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    <option value="">Semua Kelas</option>
                    @foreach($allKelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:shadow-xl flex items-center justify-center space-x-2">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Enhanced Student List Section --}}
    <form id="qr-form" action="{{ route('adminsiswa.download-qrcodes') }}" method="POST">
        @csrf
        @forelse($groupedStudents as $sekolah)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-100 to-blue-200 px-6 py-4 border-b border-blue-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-school text-2xl text-blue-800"></i>
                    <h2 class="text-2xl font-bold text-blue-800">{{ $sekolah->nama_sekolah }}</h2>
                </div>
            </div>

            @foreach($sekolah->kelas as $kelas)
            @if($kelas->siswa->count() > 0)
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <i class="fas fa-chalkboard-teacher text-xl text-gray-700"></i>
                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2">
                        Kelas: {{ $kelas->nama_kelas }}
                    </h3>
                </div>

                {{-- Desktop View --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded select-all">
                                        <span class="text-xs font-medium text-gray-500 uppercase">Select</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto & QR</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NISN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($kelas->siswa as $siswa)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="selected_students[]" value="{{ $siswa->id }}" 
                                           class="form-checkbox h-4 w-4 text-blue-600 rounded student-checkbox">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative group">
                                            @if($siswa->foto)
                                            <img src="{{ Storage::url(''.$siswa->foto) }}"
                                                alt="Foto {{ $siswa->nama_lengkap }}"
                                                class="h-12 w-12 rounded-full object-cover border-2 border-blue-200 shadow-md group-hover:border-blue-400 transition-all duration-300">
                                            @else
                                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                <i class="fas fa-user text-xl"></i>
                                            </div>
                                            @endif
                                        </div>
                                        @if(isset($qrCodeUrls[$siswa->id]))
                                        <img src="{{ $qrCodeUrls[$siswa->id] }}" 
                                             alt="QR Code {{ $siswa->nama }}" 
                                             class="h-12 w-12">
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                        <span>{{ $siswa->nisn }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-user text-gray-400"></i>
                                        <span class="font-medium text-gray-900">{{ $siswa->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs rounded-full inline-flex items-center space-x-1
                                        {{ $siswa->jenis_kelamin == 'laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        <i class="fas {{ $siswa->jenis_kelamin == 'laki-laki' ? 'fa-mars' : 'fa-venus' }}"></i>
                                        <span>{{ $siswa->jenis_kelamin }}</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                        <span>
                                            {{ $siswa->village->name }},
                                            {{ $siswa->district->name }},
                                            {{ $siswa->city->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('adminsiswa.show', $siswa->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('adminsiswa.edit', $siswa->id) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('adminsiswa.destroy', $siswa->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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

                {{-- Mobile View --}}
                <div class="md:hidden space-y-4">
                    @foreach($kelas->siswa as $siswa)
                    <div x-data="{ open: false }" 
                         class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                        <div @click="open = !open" 
                             class="p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                @if($siswa->foto)
                                <img src="{{ Storage::url(''.$siswa->foto) }}"
                                    alt="Foto {{ $siswa->nama_lengkap }}"
                                    class="h-12 w-12 rounded-full object-cover border-2 border-blue-200 shadow-md">
                                @else
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                    <i class="fas fa-user text-xl"></i>
                                </div>
                                @endif
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $siswa->nama_lengkap }}</h4>
                                    <p class="text-sm text-gray-500">NISN: {{ $siswa->nisn }}</p>
                                </div>
                            </div>
                            <i class="fas transition-transform duration-200"
                               :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                        </div>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             class="border-t border-gray-200">
                            <div class="p-4 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <p class="text-sm text-gray-500 flex items-center space-x-2">
                                            <i class="fas fa-venus-mars text-gray-400"></i>
                                            <span>Gender</span>
                                        </p>
                                        <span class="px-2 py-1 text-xs rounded-full inline-flex items-center space-x-1
                                            {{ $siswa->jenis_kelamin == 'laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            <i class="fas {{ $siswa->jenis_kelamin == 'laki-laki' ? 'fa-mars' : 'fa-venus' }}"></i>
                                            <span>{{ $siswa->jenis_kelamin }}</span>
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-1">
                                        <p class="text-sm text-gray-500 flex items-center space-x-2">
                                            <i class="fas fa-qrcode text-gray-400"></i>
                                            <span>QR Code</span>
                                        </p>
                                        @if(isset($qrCodeUrls[$siswa->id]))
                                        <img src="{{ $qrCodeUrls[$siswa->id] }}" 
                                             alt="QR Code {{ $siswa->nama }}" 
                                             class="h-16 w-16">
                                        @else
                                        <span class="text-sm text-gray-500">Tidak ada QR Code</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <p class="text-sm text-gray-500 flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                        <span>Alamat</span>
                                    </p>
                                    <p class="text-sm text-gray-700">
                                        {{ $siswa->village->name }},
                                        {{ $siswa->district->name }},
                                        {{ $siswa->city->name }}
                                    </p>
                                </div>

                                <div class="pt-3 border-t border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" 
                                                   name="selected_students[]" 
                                                   value="{{ $siswa->id }}" 
                                                   class="form-checkbox h-4 w-4 text-blue-600 rounded student-checkbox">
                                            <span class="text-sm text-gray-500">Pilih Siswa</span>
                                        </div>
                                        <div class="flex space-x-4">
                                            <a href="{{ route('adminsiswa.show', $siswa->id) }}" 
                                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('adminsiswa.edit', $siswa->id) }}" 
                                               class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-full transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('adminsiswa.destroy', $siswa->id) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
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
            <div class="mb-4 text-gray-300">
                <i class="fas fa-folder-open text-6xl"></i>
            </div>
            <p class="text-gray-500 text-lg">Tidak ada data siswa yang ditemukan.</p>
            <p class="text-gray-400 mt-2">Silakan tambah data siswa baru atau ubah filter pencarian.</p>
        </div>
        @endforelse
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle select all functionality per table
    document.querySelectorAll('.select-all').forEach(selectAll => {
        const table = selectAll.closest('table');
        if (table) {
            selectAll.addEventListener('change', function() {
                const studentCheckboxes = table.querySelectorAll('.student-checkbox');
                studentCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
            });
        }
    });

    // Update select all when individual checkboxes change
    document.querySelectorAll('.student-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const table = checkbox.closest('table');
            if (table) {
                const selectAll = table.querySelector('.select-all');
                const studentCheckboxes = table.querySelectorAll('.student-checkbox');
                const allChecked = Array.from(studentCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
            }
        });
    });
});


// Add this script at the end of your blade file
document.addEventListener('DOMContentLoaded', function() {
    const qrForm = document.getElementById('qr-form');
    const downloadButton = document.getElementById('download-qr-button');
    
    downloadButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get all checked checkboxes
        const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
        
        if (selectedCheckboxes.length === 0) {
            alert('Silakan pilih minimal satu siswa untuk mengunduh QR Code.');
            return;
        }
        
        // Submit the form
        qrForm.submit();
    });
});
</script>
@endsection