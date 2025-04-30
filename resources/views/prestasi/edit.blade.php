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
                <span class="ml-2 text-blue-600">Edit Prestasi</span>
            </li>
        </ol>
    </nav>

    <!-- Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
            <h2 class="text-xl font-bold text-gray-900">Edit Prestasi</h2>
            <p class="mt-1 text-sm text-gray-600">Perbarui informasi prestasi</p>
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
        <form action="{{ route('prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Nama Prestasi -->
                <div class="sm:col-span-2">
                    <label for="nama_prestasi" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Prestasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_prestasi" id="nama_prestasi" value="{{ old('nama_prestasi', $prestasi->nama_prestasi) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('nama_prestasi') border-red-300 @enderror" 
                           placeholder="Contoh: Juara 1 Lomba Cerdas Cermat" required>
                    @error('nama_prestasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tingkat -->
                <div>
                    <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-1">
                        Tingkat <span class="text-red-500">*</span>
                    </label>
                    <select name="tingkat" id="tingkat" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('tingkat') border-red-300 @enderror" 
                            required>
                        <option value="">Pilih Tingkat</option>
                        @foreach(['Sekolah','Kecamatan','Kota','Provinsi','Nasional','Internasional'] as $tingkat)
                            <option value="{{ $tingkat }}" {{ old('tingkat', $prestasi->tingkat) == $tingkat ? 'selected' : '' }}>{{ $tingkat }}</option>
                        @endforeach
                    </select>
                    @error('tingkat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun -->
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun" id="tahun" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('tahun') border-red-300 @enderror" 
                            required>
                        <option value="">Pilih Tahun</option>
                        @php
                            $currentYear = date('Y');
                            for($i = $currentYear; $i >= $currentYear - 10; $i--) {
                                echo '<option value="'.$i.'" '.(old('tahun', $prestasi->tahun) == $i ? 'selected' : '').'>'.$i.'</option>';
                            }
                        @endphp
                    </select>
                    @error('tahun')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penyelenggara -->
                <div class="sm:col-span-2">
                    <label for="penyelenggara" class="block text-sm font-medium text-gray-700 mb-1">
                        Penyelenggara
                    </label>
                    <input type="text" name="penyelenggara" id="penyelenggara" value="{{ old('penyelenggara', $prestasi->penyelenggara) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('penyelenggara') border-red-300 @enderror" 
                           placeholder="Contoh: Dinas Pendidikan Kota">
                    @error('penyelenggara')
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
                              placeholder="Jelaskan detail prestasi yang diraih...">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Photos -->
                @if(isset($prestasi->foto_prestasi) && count((array)$prestasi->foto_prestasi) > 0)
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Foto Prestasi Saat Ini
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                        @foreach((array)$prestasi->foto_prestasi as $index => $foto)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Prestasi {{ $index + 1 }}" 
                                     class="h-32 w-full object-cover rounded-lg shadow-sm">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity rounded-lg flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" onclick="removeExistingPhoto(this, '{{ $foto }}')" class="bg-red-500 p-1 rounded-full shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="remove_photos" id="remove_photos" value="">
                </div>
                @endif

                <!-- New Photos -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tambah Foto Baru
                    </label>
                    <div class="mt-1 mb-4">
                        <div class="flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="foto_prestasi" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload foto</span>
                                        <input id="foto_prestasi" name="foto_prestasi[]" type="file" class="sr-only" multiple accept="image/*" onchange="previewImages(event)">
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
                    <div id="image-preview-container" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2"></div>
                    
                    @error('foto_prestasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('foto_prestasi.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('prestasi.show', $prestasi->id) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
    // Array to store photos to be removed
    let photosToRemove = [];
    
    function removeExistingPhoto(button, photoPath) {
        // Add photo to the list of photos to be removed
        photosToRemove.push(photoPath);
        document.getElementById('remove_photos').value = JSON.stringify(photosToRemove);
        
        // Remove the photo element from the DOM
        button.closest('.relative').remove();
    }
    
    function previewImages(event) {
        const container = document.getElementById('image-preview-container');
        
        const files = event.target.files;
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            if (!file.type.match('image.*')) {
                continue;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'relative group';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-32 w-full object-cover rounded-lg shadow-sm';
                
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity';
                removeButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>';
                removeButton.onclick = function() {
                    previewDiv.remove();
                };
                
                previewDiv.appendChild(img);
                previewDiv.appendChild(removeButton);
                container.appendChild(previewDiv);
            };
            
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
