@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Tambah Data Siswa</h1>
                    <p class="mt-1 text-sm text-gray-500">Lengkapi formulir berikut untuk menambahkan data siswa baru.</p>
                </div>
                <a href="{{ route('adminsiswa.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-md p-4">
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
        @endif

        <!-- Form -->
        <form action="{{ route('adminsiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Progress Indicator -->
            <div class="hidden sm:block">
                <div class="py-5">
                    <div class="border-t border-gray-200"></div>
                </div>
                <div class="flex justify-between">
                    <div class="w-1/6 text-center">
                        <div class="relative">
                            <div class="h-12 w-12 mx-auto rounded-full bg-blue-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="mt-2 text-xs font-medium text-gray-900">Sekolah</div>
                        </div>
                    </div>
                    <div class="w-1/6 text-center">
                        <div class="relative">
                            <div class="h-12 w-12 mx-auto rounded-full bg-blue-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="mt-2 text-xs font-medium text-gray-900">Data Pribadi</div>
                        </div>
                    </div>
                    <div class="w-1/6 text-center">
                        <div class="relative">
                            <div class="h-12 w-12 mx-auto rounded-full bg-blue-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="mt-2 text-xs font-medium text-gray-900">Alamat</div>
                        </div>
                    </div>
                    <div class="w-1/6 text-center">
                        <div class="relative">
                            <div class="h-12 w-12 mx-auto rounded-full bg-blue-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="mt-2 text-xs font-medium text-gray-900">Orang Tua</div>
                        </div>
                    </div>
                    <div class="w-1/6 text-center">
                        <div class="relative">
                            <div class="h-12 w-12 mx-auto rounded-full bg-blue-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="mt-2 text-xs font-medium text-gray-900">Data Tambahan</div>
                        </div>
                    </div>
                    <div class="w-1/6 text-center">
                        <div class="relative">
                            <div class="h-12 w-12 mx-auto rounded-full bg-blue-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-2 text-xs font-medium text-gray-900">Akun</div>
                        </div>
                    </div>
                </div>
                <div class="py-5">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>

            <!-- Data Sekolah -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg leading-6 font-medium text-gray-900">Data Sekolah</h3>
                    </div>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi sekolah dan kelas siswa.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="sekolah_id" class="block text-sm font-medium text-gray-700">Sekolah <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <select id="sekolah_id" name="sekolah_id" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md" required>
                                    <option value="">Pilih Sekolah</option>
                                    @foreach($sekolahs as $sekolah)
                                        <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>{{ $sekolah->nama_sekolah }}</option>
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
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg leading-6 font-medium text-gray-900">Data Pribadi</h3>
                    </div>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi identitas dan data diri siswa.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <label for="nisn" class="block text-sm font-medium text-gray-700">NISN <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}" maxlength="10" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Nomor Induk Siswa Nasional (10 digit)</p>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="nis" class="block text-sm font-medium text-gray-700">NIS <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="nis" id="nis" value="{{ old('nis') }}" maxlength="10" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Nomor Induk Siswa (maks. 10 digit)</p>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Nomor Induk Kependudukan (16 digit)</p>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <div class="flex items-center space-x-6">
                                    <div class="flex items-center">
                                        <input id="jenis_kelamin_l" name="jenis_kelamin" value="laki-laki" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('jenis_kelamin') == 'laki-laki' ? 'checked' : '' }} required>
                                        <label for="jenis_kelamin_l" class="ml-3 block text-sm font-medium text-gray-700">Laki-laki</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="jenis_kelamin_p" name="jenis_kelamin" value="perempuan" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('jenis_kelamin') == 'perempuan' ? 'checked' : '' }}>
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
                                        <option value="{{ $religion }}" {{ old('agama') == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="tmp_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="tmp_lahir" id="tmp_lahir" value="{{ old('tmp_lahir') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="date" name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kode Pos <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto Siswa</label>
                            <div class="mt-1 flex items-center">
                                <div class="h-32 w-32 rounded-md overflow-hidden bg-gray-100 flex items-center justify-center">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="relative bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm flex items-center cursor-pointer hover:bg-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <label for="foto" class="relative text-sm leading-4 font-medium text-gray-700 pointer-events-none">
                                            <span>Upload Foto</span>
                                        </label>
                                        <input id="foto" name="foto" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">

                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Alamat -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg leading-6 font-medium text-gray-900">Data Alamat</h3>
                    </div>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi alamat tempat tinggal siswa.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <textarea id="alamat" name="alamat" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>{{ old('alamat') }}</textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Alamat lengkap tempat tinggal siswa (jalan, RT/RW, dll)</p>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select id="province_id" name="province_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="city_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select id="city_id" name="city_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="district_id" class="block text-sm font-medium text-gray-700">Kecamatan <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select id="district_id" name="district_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="village_id" class="block text-sm font-medium text-gray-700">Desa/Kelurahan <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select id="village_id" name="village_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    <option value="">Pilih Desa/Kelurahan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg leading-6 font-medium text-gray-900">Data Orang Tua</h3>
                    </div>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi orang tua atau wali siswa.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Data Ayah</h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="ayah" class="block text-sm font-medium text-gray-700">Nama Ayah <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="ayah" id="ayah" value="{{ old('ayah') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="kerja_ayah" class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                                    <div class="mt-1">
                                        <input type="text" name="kerja_ayah" id="kerja_ayah" value="{{ old('kerja_ayah') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div>
                                    <label for="email_ayah" class="block text-sm font-medium text-gray-700">Email Ayah</label>
                                    <div class="mt-1">
                                        <input type="email" name="email_ayah" id="email_ayah" value="{{ old('email_ayah') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
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
                                        <input type="text" name="ibu" id="ibu" value="{{ old('ibu') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="kerja_ibu" class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                                    <div class="mt-1">
                                        <input type="text" name="kerja_ibu" id="kerja_ibu" value="{{ old('kerja_ibu') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div>
                                    <label for="email_ibu" class="block text-sm font-medium text-gray-700">Email Ibu</label>
                                    <div class="mt-1">
                                        <input type="email" name="email_ibu" id="email_ibu" value="{{ old('email_ibu') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Tambahan -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg leading-6 font-medium text-gray-900">Data Tambahan</h3>
                    </div>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi tambahan dan program bantuan.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <label for="tb" class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                            <div class="mt-1">
                                <input type="number" name="tb" id="tb" value="{{ old('tb') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="bb" class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                            <div class="mt-1">
                                <input type="number" name="bb" id="bb" value="{{ old('bb') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                            <div class="mt-1">
                                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="tinggal" class="block text-sm font-medium text-gray-700">Tinggal Dengan <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select id="tinggal" name="tinggal" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    @foreach($livingOptions as $option)
                                        <option value="{{ $option }}" {{ old('tinggal') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="transport" class="block text-sm font-medium text-gray-700">Transportasi <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="transport" id="transport" value="{{ old('transport') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Transportasi yang digunakan ke sekolah</p>
                        </div>

                        <div class="sm:col-span-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Program Bantuan</h4>
                            <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-3">
                                <div>
                                    <label for="kks" class="block text-sm font-medium text-gray-700">No. KKS</label>
                                    <div class="mt-1">
                                        <input type="text" name="kks" id="kks" value="{{ old('kks') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Kartu Keluarga Sejahtera</p>
                                </div>

                                <div>
                                    <label for="kph" class="block text-sm font-medium text-gray-700">No. KPH</label>
                                    <div class="mt-1">
                                        <input type="text" name="kph" id="kph" value="{{ old('kph') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Kartu Program Harapan</p>
                                </div>

                                <div>
                                    <label for="kip" class="block text-sm font-medium text-gray-700">No. KIP</label>
                                    <div class="mt-1">
                                        <input type="text" name="kip" id="kip" value="{{ old('kip') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Kartu Indonesia Pintar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Akun -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg leading-6 font-medium text-gray-900">Data Akun</h3>
                    </div>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi akun untuk login siswa.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Email akan digunakan untuk login</p>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="password" name="password" id="password" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
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
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview uploaded image
    const fileInput = document.getElementById('foto');
    const imagePreview = fileInput.parentElement.parentElement.querySelector('svg');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Replace SVG with image
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-full w-full object-cover';
                imagePreview.parentNode.replaceChild(img, imagePreview);
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
