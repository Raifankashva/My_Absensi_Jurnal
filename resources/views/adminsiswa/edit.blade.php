@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="max-w-7xl mx-auto mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-white">Edit Data Siswa</h1>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('adminsiswa.index') }}" 
                               class="inline-flex items-center px-5 py-2.5 rounded-lg bg-white text-blue-600 hover:bg-blue-50 font-medium transition duration-300 ease-in-out shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="max-w-7xl mx-auto mb-6">
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('adminsiswa.update', $dataSiswa->id) }}" method="POST" enctype="multipart/form-data" class="max-w-7xl mx-auto">
            @csrf
            @method('PUT')
            
            <div class="grid md:grid-cols-12 gap-8">
                <!-- Left Column - Profile Photo & Progress -->
                <div class="md:col-span-4 space-y-6">
                    <!-- Profile Photo Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-b from-blue-500/30 to-blue-500/10"></div>
                            <div class="p-8 flex justify-center">
                                <div class="relative">
                                    <div id="photo-preview" class="w-48 h-48 rounded-full bg-gray-200 border-4 border-white shadow-lg flex items-center justify-center overflow-hidden">
                                        @if($dataSiswa->foto)
                                            <img src="{{ asset('storage/' . $dataSiswa->foto) }}" 
                                                alt="Foto {{ $dataSiswa->nama_lengkap }}" 
                                                class="w-full h-full object-cover">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Foto Profil</h2>
                            <div class="relative bg-blue-500 text-white py-2 px-4 rounded-lg shadow-sm inline-flex items-center cursor-pointer hover:bg-blue-600 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Upload Foto</span>
                                <input id="foto" name="foto" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                            </div>
                            <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                        </div>
                    </div>

                    <!-- Progress Indicator -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Tahapan Pengisian
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Sekolah</p>
                                        <p class="text-xs text-gray-500">Informasi sekolah dan kelas</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Data Pribadi</p>
                                        <p class="text-xs text-gray-500">Informasi identitas siswa</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Alamat</p>
                                        <p class="text-xs text-gray-500">Informasi tempat tinggal</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Orang Tua</p>
                                        <p class="text-xs text-gray-500">Informasi orang tua/wali</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Data Tambahan</p>
                                        <p class="text-xs text-gray-500">Informasi tambahan siswa</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Akun</p>
                                        <p class="text-xs text-gray-500">Informasi akun login</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form Sections -->
                <div class="md:col-span-8 space-y-6">
                    <!-- Data Sekolah -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Sekolah</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label for="sekolah_id" class="block text-sm font-medium text-gray-700">Sekolah <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select id="sekolah_id" name="sekolah_id" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md" required>
                                            <option value="">Pilih Sekolah</option>
                                            @foreach($sekolahs as $sekolah)
                                                <option value="{{ $sekolah->id }}" {{ $dataSiswa->sekolah_id == $sekolah->id ? 'selected' : '' }}>{{ $sekolah->nama_sekolah }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3z" clip-rule="evenodd" />
                                                <path fill-rule="evenodd" d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select id="kelas_id" name="kelas_id" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach($allKelas as $kelas)
                                                <option value="{{ $kelas->id }}" {{ $dataSiswa->kelas_id == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3z" clip-rule="evenodd" />
                                                <path fill-rule="evenodd" d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pribadi -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Pribadi</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-2">
                                    <label for="nisn" class="block text-sm font-medium text-gray-700">NISN <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="nisn" id="nisn" value="{{ $dataSiswa->nisn }}" maxlength="10" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Nomor Induk Siswa Nasional (10 digit)</p>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nis" class="block text-sm font-medium text-gray-700">NIS <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="nis" id="nis" value="{{ $dataSiswa->nis }}" maxlength="10" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Nomor Induk Siswa (maks. 10 digit)</p>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="nik" id="nik" value="{{ $dataSiswa->nik }}" maxlength="16" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Nomor Induk Kependudukan (16 digit)</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ $dataSiswa->nama_lengkap }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <div class="flex items-center space-x-6">
                                            <div class="flex items-center">
                                                <input id="jenis_kelamin_l" name="jenis_kelamin" value="laki-laki" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ $dataSiswa->jenis_kelamin == 'laki-laki' ? 'checked' : '' }} required>
                                                <label for="jenis_kelamin_l" class="ml-3 block text-sm font-medium text-gray-700">Laki-laki</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="jenis_kelamin_p" name="jenis_kelamin" value="perempuan" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ $dataSiswa->jenis_kelamin == 'perempuan' ? 'checked' : '' }}>
                                                <label for="jenis_kelamin_p" class="ml-3 block text-sm font-medium text-gray-700">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="agama" class="block text-sm font-medium text-gray-700">Agama <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <select id="agama" name="agama" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            @foreach($religions as $religion)
                                                <option value="{{ $religion }}" {{ $dataSiswa->agama == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="tmp_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="tmp_lahir" id="tmp_lahir" value="{{ $dataSiswa->tmp_lahir }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="date" name="tgl_lahir" id="tgl_lahir" value="{{ $dataSiswa->tgl_lahir->format('Y-m-d') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kode Pos <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="kode_pos" id="kode_pos" value="{{ $dataSiswa->kode_pos }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Alamat -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-amber-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Alamat</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <textarea id="alamat" name="alamat" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>{{ $dataSiswa->user->alamat }}</textarea>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Alamat lengkap tempat tinggal siswa (jalan, RT/RW, dll)</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <select id="province_id" name="province_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}" {{ $dataSiswa->province_id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="city_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <select id="city_id" name="city_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="">Pilih Kabupaten/Kota</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ $dataSiswa->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="district_id" class="block text-sm font-medium text-gray-700">Kecamatan <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <select id="district_id" name="district_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ $dataSiswa->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="village_id" class="block text-sm font-medium text-gray-700">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <select id="village_id" name="village_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="">Pilih Desa/Kelurahan</option>
                                            @foreach($villages as $village)
                                                <option value="{{ $village->id }}" {{ $dataSiswa->village_id == $village->id ? 'selected' : '' }}>{{ $village->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Orang Tua</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Data Ayah</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="ayah" class="block text-sm font-medium text-gray-700">Nama Ayah <span class="text-red-500">*</span></label>
                                            <div class="mt-1">
                                                <input type="text" name="ayah" id="ayah" value="{{ $dataSiswa->ayah }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="kerja_ayah" class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                                            <div class="mt-1">
                                                <input type="text" name="kerja_ayah" id="kerja_ayah" value="{{ $dataSiswa->kerja_ayah }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="email_ayah" class="block text-sm font-medium text-gray-700">Email Ayah</label>
                                            <div class="mt-1">
                                                <input type="email" name="email_ayah" id="email_ayah" value="{{ $dataSiswa->email_ayah }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Data Ibu</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="ibu" class="block text-sm font-medium text-gray-700">Nama Ibu <span class="text-red-500">*</span></label>
                                            <div class="mt-1">
                                                <input type="text" name="ibu" id="ibu" value="{{ $dataSiswa->ibu }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="kerja_ibu" class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                                            <div class="mt-1">
                                                <input type="text" name="kerja_ibu" id="kerja_ibu" value="{{ $dataSiswa->kerja_ibu }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="email_ibu" class="block text-sm font-medium text-gray-700">Email Ibu</label>
                                            <div class="mt-1">
                                                <input type="email" name="email_ibu" id="email_ibu" value="{{ $dataSiswa->email_ibu }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Tambahan -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Tambahan</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-2">
                                    <label for="tb" class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                                    <div class="mt-1">
                                        <input type="number" name="tb" id="tb" value="{{ $dataSiswa->tb }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="bb" class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                                    <div class="mt-1">
                                        <input type="number" name="bb" id="bb" value="{{ $dataSiswa->bb }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                    <div class="mt-1">
                                        <input type="text" name="no_hp" id="no_hp" value="{{ $dataSiswa->user->no_hp }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tinggal" class="block text-sm font-medium text-gray-700">Tinggal Dengan <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <select id="tinggal" name="tinggal" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            @foreach($livingOptions as $option)
                                                <option value="{{ $option }}" {{ $dataSiswa->tinggal == $option ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="transport" class="block text-sm font-medium text-gray-700">Transportasi <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="transport" id="transport" value="{{ $dataSiswa->transport }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Transportasi yang digunakan ke sekolah</p>
                                </div>

                                <div class="sm:col-span-6">
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Program Bantuan</h4>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-3">
                                        <div>
                                            <label for="kks" class="block text-sm font-medium text-gray-700">No. KKS</label>
                                            <div class="mt-1">
                                                <input type="text" name="kks" id="kks" value="{{ $dataSiswa->kks }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Kartu Keluarga Sejahtera</p>
                                        </div>

                                        <div>
                                            <label for="kph" class="block text-sm font-medium text-gray-700">No. KPH</label>
                                            <div class="mt-1">
                                                <input type="text" name="kph" id="kph" value="{{ $dataSiswa->kph }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Kartu Program Harapan</p>
                                        </div>

                                        <div>
                                            <label for="kip" class="block text-sm font-medium text-gray-700">No. KIP</label>
                                            <div class="mt-1">
                                                <input type="text" name="kip" id="kip" value="{{ $dataSiswa->kip }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Kartu Indonesia Pintar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Akun -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-100">
                            <div class="px-6 py-4 flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Akun</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="email" name="email" id="email" value="{{ $dataSiswa->user->email }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Email akan digunakan untuk login</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <div class="mt-1">
                                        <input type="password" name="password" id="password" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <select id="role" name="role" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="siswa" selected>Siswa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('adminsiswa.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview uploaded image
    const fileInput = document.getElementById('foto');
    const photoPreview = document.getElementById('photo-preview');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Replace content with image
                photoPreview.innerHTML = '';
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';
                photoPreview.appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // School-Class Dynamic Dropdown
    const sekolahSelect = document.getElementById('sekolah_id');
    const kelasSelect = document.getElementById('kelas_id');
    
    sekolahSelect.addEventListener('change', function() {
        const sekolahId = this.value;
        kelasSelect.innerHTML = '<option value="">Loading...</option>';
        
        if (sekolahId) {
            fetch(`/get-kelas/${sekolahId}`)
                .then(response => response.json())
                .then(data => {
                    kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
                    data.forEach(kelas => {
                        kelasSelect.innerHTML += `<option value="${kelas.id}">${kelas.nama_kelas}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    kelasSelect.innerHTML = '<option value="">Error loading kelas</option>';
                });
        } else {
            kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
        }
    });

    // Location Cascade Dropdowns
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const villageSelect = document.getElementById('village_id');

    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        resetDropdowns(['city', 'district', 'village']);
        
        if (provinceId) {
            fetchLocations('cities', provinceId, citySelect);
        }
    });

    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        resetDropdowns(['district', 'village']);
        
        if (cityId) {
            fetchLocations('districts', cityId, districtSelect);
        }
    });

    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        resetDropdowns(['village']);
        
        if (districtId) {
            fetchLocations('villages', districtId, villageSelect);
        }
    });

    function resetDropdowns(types) {
        types.forEach(type => {
            const select = document.getElementById(`${type}_id`);
            select.innerHTML = `<option value="">Pilih ${type.charAt(0).toUpperCase() + type.slice(1)}</option>`;
        });
    }

    function fetchLocations(type, parentId, selectElement) {
        selectElement.innerHTML = '<option value="">Loading...</option>';
        
        fetch(`/get-${type}/${parentId}`)
            .then(response => response.json())
            .then(data => {
                selectElement.innerHTML = `<option value="">Pilih ${type.charAt(0).toUpperCase() + type.slice(1)}</option>`;
                data.forEach(item => {
                    selectElement.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                selectElement.innerHTML = `<option value="">Error loading ${type}</option>`;
            });
    }

    // Date of birth validation
    const inputDate = document.getElementById("tgl_lahir");
    const today = new Date();
    today.setFullYear(today.getFullYear() - 6); // Kurangi 6 tahun dari hari ini
    const maxDate = today.toISOString().split("T")[0]; // Format YYYY-MM-DD
    inputDate.setAttribute("max", maxDate);
});
</script>
@endsection
