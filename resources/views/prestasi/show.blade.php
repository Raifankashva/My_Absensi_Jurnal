@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm font-medium">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('school.dashboard') }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
            </li>
            <li class="flex items-center">
                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('prestasi.index') }}" class="ml-2 text-gray-500 hover:text-gray-700">Prestasi</a>
            </li>
            <li class="flex items-center">
                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-2 text-blue-600 truncate max-w-xs">{{ $prestasi->nama_prestasi }}</span>
            </li>
        </ol>
    </nav>

    <!-- Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-50 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Detail Prestasi</h2>
                <p class="mt-1 text-sm text-gray-600">Informasi lengkap tentang prestasi</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('prestasi.edit', $prestasi->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit
                </a>
                <button onclick="confirmDelete('{{ $prestasi->id }}', '{{ $prestasi->nama_prestasi }}')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Hapus
                </button>
                <form id="delete-form-{{ $prestasi->id }}" action="{{ route('prestasi.destroy', $prestasi->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Image Gallery -->
            @if(isset($prestasi->foto_prestasi) && count((array)$prestasi->foto_prestasi) > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Foto Prestasi</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach((array)$prestasi->foto_prestasi as $index => $foto)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Prestasi {{ $index + 1 }}" 
                                     class="h-48 w-full object-cover rounded-lg shadow-sm cursor-pointer"
                                     onclick="openLightbox('{{ asset('storage/' . $foto) }}')">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity rounded-lg flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" onclick="openLightbox('{{ asset('storage/' . $foto) }}')" class="bg-white p-2 rounded-full shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 8a1 1 0 011-1h1V6a1 1 0 012 0v1h1a1 1 0 110 2H9v1a1 1 0 11-2 0V9H6a1 1 0 01-1-1z" />
                                                <path fill-rule="evenodd" d="M2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8zm6-4a4 4 0 100 8 4 4 0 000-8z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Prestasi</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Nama Prestasi</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $prestasi->nama_prestasi }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tingkat</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $prestasi->tingkat == 'Internasional' ? 'bg-indigo-100 text-indigo-800' : 
                                       ($prestasi->tingkat == 'Nasional' ? 'bg-purple-100 text-purple-800' : 
                                       ($prestasi->tingkat == 'Provinsi' ? 'bg-blue-100 text-blue-800' : 
                                       ($prestasi->tingkat == 'Kota' ? 'bg-green-100 text-green-800' : 
                                       ($prestasi->tingkat == 'Kecamatan' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-gray-100 text-gray-800')))) }}">
                                    {{ $prestasi->tingkat }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tahun</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $prestasi->tahun }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Penyelenggara</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $prestasi->penyelenggara ?: 'Tidak ada data' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-base text-gray-900 whitespace-pre-line">{{ $prestasi->deskripsi ?: 'Tidak ada deskripsi' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Tambahan</h3>
                    <dl class="grid grid-cols-1 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Sekolah</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $prestasi->sekolah->nama_sekolah }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Ditambahkan</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $prestasi->created_at->format('d M Y, H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $prestasi->updated_at->format('d M Y, H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
            <a href="{{ route('prestasi.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Daftar Prestasi
            </a>
            <a href="{{ route('prestasi.edit', $prestasi->id) }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                Edit Prestasi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4">
    <button type="button" onclick="closeLightbox()" class="absolute top-4 right-4 text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <img id="lightbox-img" src="/placeholder.svg" alt="Foto Prestasi" class="max-h-screen max-w-full">
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
    // Lightbox functionality
    function openLightbox(imgSrc) {
        document.getElementById('lightbox-img').src = imgSrc;
        document.getElementById('lightbox').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close lightbox when clicking outside the image
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
    
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
