@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm font-medium">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
            </li>
            <li class="flex items-center">
                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('fasilitas.index') }}" class="ml-2 text-gray-500 hover:text-gray-700">Fasilitas</a>
            </li>
            <li class="flex items-center">
                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-2 text-blue-600">Edit Fasilitas</span>
            </li>
        </ol>
    </nav>

    <!-- Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
            <h2 class="text-xl font-bold text-gray-900">Edit Fasilitas</h2>
            <p class="mt-1 text-sm text-gray-600">Perbarui informasi fasilitas</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="p-4 bg-red-50 border-l-4 border-red-500">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan pada formulir:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('fasilitas.update', $fasilitas->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Nama Fasilitas -->
                <div class="sm:col-span-2">
                    <label for="nama_fasilitas" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Fasilitas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_fasilitas" id="nama_fasilitas" value="{{ old('nama_fasilitas', $fasilitas->nama_fasilitas) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('nama_fasilitas') border-red-300 @enderror" 
                           placeholder="Contoh: Laboratorium Komputer" required>
                    @error('nama_fasilitas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" id="kategori" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('kategori') border-red-300 @enderror" 
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach(['Akademik', 'Olahraga', 'Umum', 'Teknologi', 'Kesehatan'] as $kategori)
                            <option value="{{ $kategori }}" {{ old('kategori', $fasilitas->kategori) == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">
                        Jumlah
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $fasilitas->jumlah) }}" min="0"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('jumlah') border-red-300 @enderror" 
                               placeholder="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Unit</span>
                        </div>
                    </div>
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div>
                    <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-1">
                        Kondisi <span class="text-red-500">*</span>
                    </label>
                    <select name="kondisi" id="kondisi" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('kondisi') border-red-300 @enderror" 
                            required>
                        <option value="">Pilih Kondisi</option>
                        @foreach(['Baik', 'Cukup', 'Perlu Perbaikan'] as $kondisi)
                            <option value="{{ $kondisi }}" {{ old('kondisi', $fasilitas->kondisi) == $kondisi ? 'selected' : '' }}>{{ $kondisi }}</option>
                        @endforeach
                    </select>
                    @error('kondisi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="sm:col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('deskripsi') border-red-300 @enderror" 
                              placeholder="Jelaskan detail fasilitas...">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Photo -->
                @if($fasilitas->foto_fasilitas)
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Foto Saat Ini
                    </label>
                    <div class="mt-2 relative">
                        <img src="{{ asset('storage/'.$fasilitas->foto_fasilitas) }}" alt="{{ $fasilitas->nama_fasilitas }}" 
                             class="h-48 w-full object-cover rounded-lg shadow-sm">
                        <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-opacity rounded-lg flex items-center justify-center">
                            <div class="opacity-0 hover:opacity-100 transition-opacity">
                                <button type="button" onclick="toggleRemovePhoto()" class="bg-red-500 p-2 rounded-full shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="remove-photo-container" class="hidden mt-2">
                        <div class="flex items-center">
                            <input id="remove_photo" name="remove_photo" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remove_photo" class="ml-2 block text-sm text-red-600">
                                Hapus foto saat ini
                            </label>
                        </div>
                    </div>
                </div>
                @endif

                <!-- New Photo -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $fasilitas->foto_fasilitas ? 'Ganti Foto' : 'Foto Fasilitas' }}
                    </label>
                    <div class="mt-1 mb-4">
                        <div class="flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="foto_fasilitas" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload foto</span>
                                        <input id="foto_fasilitas" name="foto_fasilitas" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF hingga 2MB
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image Preview -->
                    <div id="image-preview" class="hidden mt-2">
                        <img id="preview-image" src="#" alt="Preview" class="h-48 w-full object-cover rounded-lg shadow-sm">
                        <button type="button" onclick="removeImage()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                            Hapus Gambar
                        </button>
                    </div>
                    
                    @error('foto_fasilitas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('fasilitas.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview-image');
        const previewContainer = document.getElementById('image-preview');
        
        if (event.target.files.length > 0) {
            const file = event.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            
            reader.readAsDataURL(file);
        }
    }
    
    function removeImage() {
        const input = document.getElementById('foto_fasilitas');
        const preview = document.getElementById('preview-image');
        const previewContainer = document.getElementById('image-preview');
        
        input.value = '';
        preview.src = '#';
        previewContainer.classList.add('hidden');
    }
    
    function toggleRemovePhoto() {
        const container = document.getElementById('remove-photo-container');
        container.classList.toggle('hidden');
        
        const checkbox = document.getElementById('remove_photo');
        checkbox.checked = !checkbox.checked;
    }
</script>
@endsection
