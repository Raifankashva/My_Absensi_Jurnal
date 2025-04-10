@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Import Data Siswa</h2>
                    <a href="{{ route('adminsiswa.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <div class="flex items-center text-blue-700 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <h3 class="font-medium">Petunjuk Import Data</h3>
                    </div>
                    <ol class="list-decimal ml-6 text-sm text-gray-700">
                        <li class="mb-1">Download template Excel yang sudah disediakan</li>
                        <li class="mb-1">Isi data sesuai format yang ada pada template</li>
                        <li class="mb-1">Pastikan data Sekolah, Kelas, dan ID Wilayah sudah benar</li>
                        <li class="mb-1">Jangan mengubah nama kolom atau urutan kolom</li>
                        <li>Upload file Excel yang sudah diisi data</li>
                    </ol>
                </div>

                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-1/2">
                        <div class="p-6 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-lg mb-4">Download Template</h3>
                            <p class="text-gray-600 mb-4">Download template Excel yang berisi format data siswa yang benar.</p>
                            <a href="{{ route('siswa.download-template') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Download Template
                            </a>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-1/2">
                        <div class="p-6 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-lg mb-4">Upload Data</h3>
                            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel</label>
                                    <input type="file" name="file" id="file" required 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('file')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Import Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection