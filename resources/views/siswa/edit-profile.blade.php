@extends('layouts.app2')

@section('content')
<div class="py-8 px-4 md:px-6 max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Profil</h1>
        <p class="text-gray-600 mt-2">Lengkapi informasi profil Anda untuk memperbarui data siswa</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Profile Header with Photo -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center overflow-hidden border-4 border-white">
                            @if($dataSiswa->foto)
                                <img src="{{ asset('storage/'.$dataSiswa->foto) }}" alt="Profile" class="h-full w-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <label for="foto" class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-md cursor-pointer hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="file" id="foto" name="foto" class="hidden" accept="image/jpeg,image/png,image/jpg">
                        </label>
                    </div>
                    <div class="text-center md:text-left text-white">
                        <h2 class="text-2xl font-bold">{{ $dataSiswa->nama_lengkap ?: 'Nama Siswa' }}</h2>
                        <p class="opacity-90">{{ $dataSiswa->nisn ? 'NISN: '.$dataSiswa->nisn : 'Lengkapi data diri Anda' }}</p>
                        <p class="text-sm opacity-75 mt-1">{{ $dataSiswa->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px overflow-x-auto" aria-label="Tabs">
                    <button type="button" class="tab-btn active border-blue-500 text-blue-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm" data-target="data-pribadi">
                        Data Pribadi
                    </button>
                    <button type="button" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm" data-target="data-alamat">
                        Alamat
                    </button>
                    <button type="button" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm" data-target="data-keluarga">
                        Data Keluarga
                    </button>
                    <button type="button" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm" data-target="data-tambahan">
                        Data Tambahan
                    </button>
                </nav>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <!-- Data Pribadi Tab -->
                <div id="data-pribadi" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Sekolah & Kelas -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Akademik</h3>
                            
                            <div>
                                <label for="sekolah_id" class="block text-sm font-medium text-gray-700 mb-1">Sekolah</label>
                                <select id="sekolah_id" name="sekolah_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    @foreach(\App\Models\Sekolah::all() as $sekolah)
                                        <option value="{{ $sekolah->id }}" {{ $dataSiswa->sekolah_id == $sekolah->id ? 'selected' : '' }}>{{ $sekolah->nama_sekolah }}</option>
                                    @endforeach
                                </select>
                                @error('sekolah_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                <select id="kelas_id" name="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    @foreach(\App\Models\Kelas::all() as $kelas)
                                        <option value="{{ $kelas->id }}" {{ $dataSiswa->kelas_id == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Nomor Identitas -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Nomor Identitas</h3>
                            
                            <div>
                                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                                <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $dataSiswa->nisn) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('nisn')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                                <input type="text" id="nis" name="nis" value="{{ old('nis', $dataSiswa->nis) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('nis')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                <input type="text" id="nik" name="nik" value="{{ old('nik', $dataSiswa->nik) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('nik')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Data Diri -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Data Diri</h3>
                            
                            <div>
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $dataSiswa->nama_lengkap) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('nama_lengkap')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $dataSiswa->user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                                <input type="text" id="hp" name="hp" value="{{ old('hp', $dataSiswa->hp) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('hp')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Kelamin & Agama -->
                        <div class="space-y-4">
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="laki-laki" {{ old('jenis_kelamin', $dataSiswa->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('jenis_kelamin', $dataSiswa->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                                <select id="agama" name="agama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                        <option value="{{ $agama }}" {{ old('agama', $dataSiswa->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                                @error('agama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <div class="space-y-4">
                            <div>
                                <label for="tmp_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                                <input type="text" id="tmp_lahir" name="tmp_lahir" value="{{ old('tmp_lahir', $dataSiswa->tmp_lahir) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('tmp_lahir')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tgl_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $dataSiswa->tgl_lahir) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('tgl_lahir')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Transportasi & Tinggal -->
                        <div class="space-y-4">
                            <div>
                                <label for="transport" class="block text-sm font-medium text-gray-700 mb-1">Moda Transportasi</label>
                                <input type="text" id="transport" name="transport" value="{{ old('transport', $dataSiswa->transport) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('transport')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tinggal" class="block text-sm font-medium text-gray-700 mb-1">Tinggal Dengan</label>
                                <select id="tinggal" name="tinggal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    @foreach(['Ortu', 'Wali', 'Kost', 'Asrama', 'Panti'] as $tinggal)
                                        <option value="{{ $tinggal }}" {{ old('tinggal', $dataSiswa->tinggal) == $tinggal ? 'selected' : '' }}>{{ $tinggal }}</option>
                                    @endforeach
                                </select>
                                @error('tinggal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Alamat Tab -->
                <div id="data-alamat" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Provinsi & Kabupaten -->
                        <div>
                            <div class="mb-4">
                                <label for="province_id" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                <select id="province_id" name="province_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id', $dataSiswa->province_id) == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                                <select id="city_id" name="city_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    @if(old('province_id', $dataSiswa->province_id))
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id', $dataSiswa->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('city_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kecamatan & Desa -->
                        <div>
                            <div class="mb-4">
                                <label for="district_id" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                                <select id="district_id" name="district_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="">Pilih Kecamatan</option>
                                    @if(old('city_id', $dataSiswa->city_id))
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id', $dataSiswa->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('district_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="village_id" class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan</label>
                                <select id="village_id" name="village_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="">Pilih Desa/Kelurahan</option>
                                    @if(old('district_id', $dataSiswa->district_id))
                                        @foreach($villages as $village)
                                            <option value="{{ $village->id }}" {{ old('village_id', $dataSiswa->village_id) == $village->id ? 'selected' : '' }}>{{ $village->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('village_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="md:col-span-2">
                            <div class="mb-4">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('alamat', $dataSiswa->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kode Pos -->
                        <div>
                            <div class="mb-4">
                                <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $dataSiswa->kode_pos) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('kode_pos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Keluarga Tab -->
                <div id="data-keluarga" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Data Ayah -->
                        <div class="space-y-4 p-4 bg-blue-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Data Ayah
                            </h3>
                            
                            <div>
                                <label for="ayah" class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                                <input type="text" id="ayah" name="ayah" value="{{ old('ayah', $dataSiswa->ayah) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('ayah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email_ayah" class="block text-sm font-medium text-gray-700 mb-1">Email Ayah</label>
                                <input type="email" id="email_ayah" name="email_ayah" value="{{ old('email_ayah', $dataSiswa->email_ayah) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('email_ayah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kerja_ayah" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                                <input type="text" id="kerja_ayah" name="kerja_ayah" value="{{ old('kerja_ayah', $dataSiswa->kerja_ayah) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('kerja_ayah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <div class="space-y-4 p-4 bg-pink-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Data Ibu
                            </h3>
                            
                            <div>
                                <label for="ibu" class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                                <input type="text" id="ibu" name="ibu" value="{{ old('ibu', $dataSiswa->ibu) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('ibu')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email_ibu" class="block text-sm font-medium text-gray-700 mb-1">Email Ibu</label>
                                <input type="email" id="email_ibu" name="email_ibu" value="{{ old('email_ibu', $dataSiswa->email_ibu) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('email_ibu')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kerja_ibu" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                                <input type="text" id="kerja_ibu" name="kerja_ibu" value="{{ old('kerja_ibu', $dataSiswa->kerja_ibu) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('kerja_ibu')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Data Wali -->
                        <div class="space-y-4 p-4 bg-purple-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Data Wali
                            </h3>
                            
                            <div>
                                <label for="wali" class="block text-sm font-medium text-gray-700 mb-1">Nama Wali</label>
                                <input type="text" id="wali" name="wali" value="{{ old('wali', $dataSiswa->wali) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('wali')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email_wali" class="block text-sm font-medium text-gray-700 mb-1">Email Wali</label>
                                <input type="email" id="email_wali" name="email_wali" value="{{ old('email_wali', $dataSiswa->email_wali) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('email_wali')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kerja_wali" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Wali</label>
                                <input type="text" id="kerja_wali" name="kerja_wali" value="{{ old('kerja_wali', $dataSiswa->kerja_wali) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('kerja_wali')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Tambahan Tab -->
                <div id="data-tambahan" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Data Fisik -->
                        <div class="space-y-4 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Data Fisik
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="tb" class="block text-sm font-medium text-gray-700 mb-1">Tinggi Badan (cm)</label>
                                    <input type="number" id="tb" name="tb" value="{{ old('tb', $dataSiswa->tb) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    @error('tb')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bb" class="block text-sm font-medium text-gray-700 mb-1">Berat Badan (kg)</label>
                                    <input type="number" id="bb" name="bb" value="{{ old('bb', $dataSiswa->bb) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    @error('bb')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Kartu -->
                        <div class="space-y-4 p-4 bg-yellow-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Data Kartu
                            </h3>
                            
                            <div>
                                <label for="kks" class="block text-sm font-medium text-gray-700 mb-1">Nomor KKS</label>
                                <input type="text" id="kks" name="kks" value="{{ old('kks', $dataSiswa->kks) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('kks')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kph" class="block text-sm font-medium text-gray-700 mb-1">Nomor KPH</label>
                                <input type="text" id="kph" name="kph" value="{{ old('kph', $dataSiswa->kph) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('kph')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kip" class="block text-sm font-medium text-gray-700 mb-1">Nomor KIP</label>
                                <input type="text" id="kip" name="kip" value="{{ old('kip', $dataSiswa->kip) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('kip')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
                <div class="flex space-x-3">
                    <a href="{{ route('siswa.profile') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript for tabs and dynamic location selection -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and hide all contents
            tabButtons.forEach(btn => btn.classList.remove('active', 'border-blue-500', 'text-blue-600'));
            tabButtons.forEach(btn => btn.classList.add('border-transparent', 'text-gray-500'));
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Add active class to clicked button and show corresponding content
            button.classList.remove('border-transparent', 'text-gray-500');
            button.classList.add('active', 'border-blue-500', 'text-blue-600');
            
            const targetId = button.getAttribute('data-target');
            document.getElementById(targetId).classList.remove('hidden');
        });
    });

    // Photo preview
    const photoInput = document.getElementById('foto');
    const photoPreview = document.querySelector('.h-32.w-32 img, .h-32.w-32 svg');
    
    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // If there's an SVG icon, replace it with an img
                    if (photoPreview.tagName === 'SVG') {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'h-full w-full object-cover';
                        photoPreview.parentNode.replaceChild(img, photoPreview);
                    } else {
                        photoPreview.src = e.target.result;
                    }
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Dynamic location selection
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const villageSelect = document.getElementById('village_id');

    // Province -> City
    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        
        // Reset dependent dropdowns
        citySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        
        if (provinceId) {
            fetch(`/api/cities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));
        }
    });

    // City -> District
    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        
        // Reset dependent dropdowns
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        
        if (cityId) {
            fetch(`/api/districts/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching districts:', error));
        }
    });

    // District -> Village
    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        
        // Reset dependent dropdowns
        villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        
        if (districtId) {
            fetch(`/api/villages/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(village => {
                        const option = document.createElement('option');
                        option.value = village.id;
                        option.textContent = village.name;
                        villageSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching villages:', error));
        }
    });
});
</script>
@endsection