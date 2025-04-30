@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Prestasi Sekolah</h1>
                <p class="mt-1 text-sm text-gray-600">Menampilkan semua prestasi dari {{ $userSchool->nama_sekolah }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('prestasi.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Prestasi
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <form action="{{ route('prestasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="filter_tingkat" class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                <select id="filter_tingkat" name="filter_tingkat" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Semua Tingkat</option>
                    @foreach(['Sekolah','Kecamatan','Kota','Provinsi','Nasional','Internasional'] as $tingkat)
                        <option value="{{ $tingkat }}" {{ request('filter_tingkat') == $tingkat ? 'selected' : '' }}>{{ $tingkat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter_tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select id="filter_tahun" name="filter_tahun" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Semua Tahun</option>
                    @php
                        $currentYear = date('Y');
                        for($i = $currentYear; $i >= $currentYear - 10; $i--) {
                            echo '<option value="'.$i.'" '.(request('filter_tahun') == $i ? 'selected' : '').'>'.$i.'</option>';
                        }
                    @endphp
                </select>
            </div>
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari prestasi..." 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
                    Filter
                </button>
                <a href="{{ route('prestasi.index') }}" class="ml-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm" id="success-alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" onclick="document.getElementById('success-alert').remove()" class="inline-flex text-green-500 hover:text-green-600 focus:outline-none">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Prestasi Cards -->
    @if($prestasi->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($prestasi as $prestasi)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Card Header with Image -->
                    <div class="relative h-48 bg-blue-100">
                        @if(isset($prestasi->foto_prestasi) && count((array)$prestasi->foto_prestasi) > 0)
                            <img src="{{ asset('storage/' . ((array)$prestasi->foto_prestasi)[0]) }}" 
                                 class="w-full h-full object-cover" alt="{{ $prestasi->nama_prestasi }}">
                            @if(count((array)$prestasi->foto_prestasi) > 1)
                                <div class="absolute bottom-2 right-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-full">
                                    +{{ count((array)$prestasi->foto_prestasi) - 1 }} foto
                                </div>
                            @endif
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Badge for Level -->
                        <div class="absolute top-2 left-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $prestasi->tingkat == 'Internasional' ? 'bg-indigo-100 text-indigo-800' : 
                                   ($prestasi->tingkat == 'Nasional' ? 'bg-purple-100 text-purple-800' : 
                                   ($prestasi->tingkat == 'Provinsi' ? 'bg-blue-100 text-blue-800' : 
                                   ($prestasi->tingkat == 'Kota' ? 'bg-green-100 text-green-800' : 
                                   ($prestasi->tingkat == 'Kecamatan' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-gray-100 text-gray-800')))) }}">
                                {{ $prestasi->tingkat }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $prestasi->nama_prestasi }}</h3>
                            <span class="bg-blue-50 text-blue-700 text-sm px-2 py-1 rounded">{{ $prestasi->tahun }}</span>
                        </div>
                        
                        @if($prestasi->penyelenggara)
                            <p class="mt-1 text-sm text-gray-600">Penyelenggara: {{ $prestasi->penyelenggara }}</p>
                        @endif
                        
                        <p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ $prestasi->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                        
                        <!-- Card Actions -->
                        <div class="mt-4 flex justify-between items-center pt-3 border-t border-gray-100">
                            <a href="{{ route('prestasi.show', $prestasi->id) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat Detail
                            </a>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('prestasi.edit', $prestasi->id) }}" 
                                   class="text-gray-500 hover:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                
                                <button onclick="confirmDelete('{{ $prestasi->id }}', '{{ $prestasi->nama_prestasi }}')" 
                                        class="text-gray-500 hover:text-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <form id="delete-form-{{ $prestasi->id }}" action="{{ route('prestasi.destroy', $prestasi->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
      
    @else
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada prestasi</h3>
            <p class="mt-1 text-gray-500">Tambahkan prestasi pertama untuk sekolah Anda.</p>
            <div class="mt-6">
                <a href="{{ route('prestasi.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Prestasi
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Hapus Prestasi</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500" id="modal-description">
                        Apakah Anda yakin ingin menghapus prestasi ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <button type="button" id="confirm-delete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Hapus
            </button>
            <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
    // Auto-hide success alert after 5 seconds
    if (document.getElementById('success-alert')) {
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    }
    
    // Delete confirmation
    let deleteId = null;
    
    function confirmDelete(id, name) {
        deleteId = id;
        const modal = document.getElementById('delete-modal');
        const description = document.getElementById('modal-description');
        description.textContent = `Apakah Anda yakin ingin menghapus prestasi "${name}"? Tindakan ini tidak dapat dibatalkan.`;
        modal.classList.remove('hidden');
    }
    
    function closeModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        deleteId = null;
    }
    
    document.getElementById('confirm-delete').addEventListener('click', function() {
        if (deleteId) {
            document.getElementById(`delete-form-${deleteId}`).submit();
        }
    });
    
    // Close modal when clicking outside
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection
