@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Daftar Pengumuman
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Pengumuman</h1>
                <p class="mt-2 text-gray-600">Isi formulir di bawah untuk membuat pengumuman baru</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-400 p-4">
                    <h2 class="text-xl font-semibold text-white">Formulir Pengumuman</h2>
                </div>

                <form action="{{ route('pengumuman.store') }}" method="POST" class="p-6 space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Judul Pengumuman -->
                        <div class="col-span-2">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="judul" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" value="{{ old('judul') }}" required>
                            @error('judul') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                            <input type="text" name="kategori" id="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" value="{{ old('kategori') }}" required>
                            @error('kategori') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="arsip" {{ old('status') == 'arsip' ? 'selected' : '' }}>Arsip</option>
                            </select>
                            @error('status') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tanggal Mulai -->
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" value="{{ old('tanggal_mulai') }}" required>
                            </div>
                            @error('tanggal_mulai') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tanggal Berakhir -->
                        <div>
                            <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir (opsional)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" value="{{ old('tanggal_berakhir') }}">
                            </div>
                            @error('tanggal_berakhir') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Isi Pengumuman -->
                        <div class="col-span-2">
                            <label for="isi" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman <span class="text-red-500">*</span></label>
                            <textarea name="isi" id="isi" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>{{ old('isi') }}</textarea>
                            @error('isi') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Lampiran -->
                        <div class="col-span-2">
                            <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-1">Lampiran (opsional)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="lampiran" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>Upload file</span>
                                            <input id="lampiran" name="lampiran" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX hingga 10MB</p>
                                </div>
                            </div>
                            @error('lampiran') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-3 px-4 rounded-lg hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Simpan Pengumuman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection