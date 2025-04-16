<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Sekolah Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        },
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="{ activeStep: 1 }">
    
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ $errors->first() }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
        </span>
    </div>
    @endif

    
    <div class="w-full max-w-4xl">
            <!-- Logo and Header -->
            <div class="text-center mb-10">
                <div class="flex justify-center">
                    <div class="bg-primary-600 p-3 rounded-full shadow-lg">
                        <i class="fas fa-school text-white text-3xl"></i>
                    </div>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Pendaftaran Sekolah Baru
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Silakan lengkapi formulir berikut untuk mendaftarkan sekolah Anda
                </p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between">
                    <div class="text-center" :class="activeStep >= 1 ? 'text-primary-600' : 'text-gray-400'">
                        <div class="flex items-center justify-center w-10 h-10 mx-auto rounded-full border-2 transition-colors duration-200"
                            :class="activeStep >= 1 ? 'bg-primary-100 border-primary-500' : 'bg-gray-100 border-gray-300'">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <p class="mt-2 text-sm font-medium">Akun</p>
                    </div>
                    <div class="flex-1 flex items-center">
                        <div class="w-full h-1 bg-gray-200 rounded-full" :class="activeStep >= 2 ? 'bg-primary-500' : 'bg-gray-200'"></div>
                    </div>
                    <div class="text-center" :class="activeStep >= 2 ? 'text-primary-600' : 'text-gray-400'">
                        <div class="flex items-center justify-center w-10 h-10 mx-auto rounded-full border-2 transition-colors duration-200"
                            :class="activeStep >= 2 ? 'bg-primary-100 border-primary-500' : 'bg-gray-100 border-gray-300'">
                            <i class="fas fa-school"></i>
                        </div>
                        <p class="mt-2 text-sm font-medium">Sekolah</p>
                    </div>
                    <div class="flex-1 flex items-center">
                        <div class="w-full h-1 bg-gray-200 rounded-full" :class="activeStep >= 3 ? 'bg-primary-500' : 'bg-gray-200'"></div>
                    </div>
                    <div class="text-center" :class="activeStep >= 3 ? 'text-primary-600' : 'text-gray-400'">
                        <div class="flex items-center justify-center w-10 h-10 mx-auto rounded-full border-2 transition-colors duration-200"
                            :class="activeStep >= 3 ? 'bg-primary-100 border-primary-500' : 'bg-gray-100 border-gray-300'">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <p class="mt-2 text-sm font-medium">Lokasi</p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('school.register') }}" enctype="multipart/form-data" class="relative">
                    @csrf

                    <!-- Step 1: Account Information -->
                    <div x-show="activeStep === 1" x-transition>
                        <div class="bg-primary-600 px-6 py-4">
                            <h3 class="text-lg font-medium text-white flex items-center">
                                <i class="fas fa-user-circle mr-2"></i>
                                Informasi Akun
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-user mr-1 text-primary-500"></i>
                                        Nama Sekolah
                                    </label>
                                    <input id="name" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('name') border-red-500 @enderror" 
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-envelope mr-1 text-primary-500"></i>
                                        Email
                                    </label>
                                    <input id="email" type="email" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('email') border-red-500 @enderror" 
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="contoh@email.com">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-lock mr-1 text-primary-500"></i>
                                        Password
                                    </label>
                                    <div class="relative">
                                        <input id="password" type="password" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('password') border-red-500 @enderror" 
                                            name="password" required autocomplete="new-password"
                                            placeholder="Minimal 8 karakter">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer">
                                            <i class="fas fa-eye" onclick="togglePasswordVisibility('password')"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-lock mr-1 text-primary-500"></i>
                                        Konfirmasi Password
                                    </label>
                                    <div class="relative">
                                        <input id="password-confirm" type="password" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" 
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Ulangi password">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer">
                                            <i class="fas fa-eye" onclick="togglePasswordVisibility('password-confirm')"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-home mr-1 text-primary-500"></i>
                                        Alamat Admin
                                    </label>
                                    <input id="alamat" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('alamat') border-red-500 @enderror" 
                                        name="alamat" value="{{ old('alamat') }}" required
                                        placeholder="Alamat lengkap">
                                    @error('alamat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-phone mr-1 text-primary-500"></i>
                                        No. HP Admin
                                    </label>
                                    <input id="no_hp" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('no_hp') border-red-500 @enderror" 
                                        name="no_hp" value="{{ old('no_hp') }}" required
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_hp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: School Information -->
                    <div x-show="activeStep === 2" x-cloak x-transition>
                        <div class="bg-primary-600 px-6 py-4">
                            <h3 class="text-lg font-medium text-white flex items-center">
                                <i class="fas fa-school mr-2"></i>
                                Informasi Sekolah
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="npsn" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-id-card mr-1 text-primary-500"></i>
                                        NPSN
                                    </label>
                                    <input id="npsn" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('npsn') border-red-500 @enderror" 
                                        name="npsn" value="{{ old('npsn') }}" required maxlength="8"
                                        placeholder="8 digit angka">
                                    @error('npsn')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nama_sekolah" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-building mr-1 text-primary-500"></i>
                                        Nama Sekolah
                                    </label>
                                    <input id="nama_sekolah" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('nama_sekolah') border-red-500 @enderror" 
                                        name="nama_sekolah" value="{{ old('nama_sekolah') }}" required
                                        placeholder="Nama lengkap sekolah">
                                    @error('nama_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="jenjang" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-graduation-cap mr-1 text-primary-500"></i>
                                        Jenjang
                                    </label>
                                    <select id="jenjang" 
                                        class="form-select w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('jenjang') border-red-500 @enderror" 
                                        name="jenjang" required>
                                        <option value="">Pilih Jenjang</option>
                                        <option value="SD" {{ old('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="SMK" {{ old('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                                    </select>
                                    @error('jenjang')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-info-circle mr-1 text-primary-500"></i>
                                        Status
                                    </label>
                                    <select id="status" 
                                        class="form-select w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('status') border-red-500 @enderror" 
                                        name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Negeri" {{ old('status') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                        <option value="Swasta" {{ old('status') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="akreditasi" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-award mr-1 text-primary-500"></i>
                                        Akreditasi
                                    </label>
                                    <select id="akreditasi" 
                                        class="form-select w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('akreditasi') border-red-500 @enderror" 
                                        name="akreditasi">
                                        <option value="">Pilih Akreditasi</option>
                                        <option value="A" {{ old('akreditasi') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('akreditasi') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ old('akreditasi') == 'C' ? 'selected' : '' }}>C</option>
                                    </select>
                                    @error('akreditasi')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-phone-alt mr-1 text-primary-500"></i>
                                        No. Telepon Sekolah
                                    </label>
                                    <input id="no_telp" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('no_telp') border-red-500 @enderror" 
                                        name="no_telp" value="{{ old('no_telp') }}" required
                                        placeholder="021xxxxxxxx">
                                    @error('no_telp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-globe mr-1 text-primary-500"></i>
                                        Website
                                    </label>
                                    <input id="website" type="url" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('website') border-red-500 @enderror" 
                                        name="website" value="{{ old('website') }}"
                                        placeholder="https://www.example.com">
                                    @error('website')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="kepala_sekolah" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-user-tie mr-1 text-primary-500"></i>
                                        Nama Kepala Sekolah
                                    </label>
                                    <input id="kepala_sekolah" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('kepala_sekolah') border-red-500 @enderror" 
                                        name="kepala_sekolah" value="{{ old('kepala_sekolah') }}" required
                                        placeholder="Nama lengkap kepala sekolah">
                                    @error('kepala_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nip_kepala_sekolah" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-id-badge mr-1 text-primary-500"></i>
                                        NIP Kepala Sekolah
                                    </label>
                                    <input id="nip_kepala_sekolah" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('nip_kepala_sekolah') border-red-500 @enderror" 
                                        name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah') }}" maxlength="18"
                                        placeholder="18 digit angka">
                                    @error('nip_kepala_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-image mr-1 text-primary-500"></i>
                                        Foto Sekolah
                                    </label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-500 transition-colors duration-200">
                                        <div class="space-y-1 text-center">
                                            <div class="flex text-sm text-gray-600">
                                                <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                                    <span>Upload file</span>
                                                    <input id="foto" name="foto" type="file" class="sr-only" accept="image/*">
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF hingga 10MB
                                            </p>
                                            <div id="preview-container" class="hidden mt-2">
                                                <img id="preview-image" class="mx-auto h-32 object-cover rounded" src="#" alt="Preview">
                                            </div>
                                        </div>
                                    </div>
                                    @error('foto')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Location Information -->
                    <div x-show="activeStep === 3" x-cloak x-transition>
                        <div class="bg-primary-600 px-6 py-4">
                            <h3 class="text-lg font-medium text-white flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                Informasi Lokasi
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="province_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-map mr-1 text-primary-500"></i>
                                        Provinsi
                                    </label>
                                    <select id="province_id" 
                                        class="form-select w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('province_id') border-red-500 @enderror" 
                                        name="province_id" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-city mr-1 text-primary-500"></i>
                                        Kabupaten/Kota
                                    </label>
                                    <select id="city_id" 
                                        class="form-select w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('city_id') border-red-500 @enderror" 
                                        name="city_id" required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                    @error('city_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="district_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-map-signs mr-1 text-primary-500"></i>
                                        Kecamatan
                                    </label>
                                    <select id="district_id" 
                                        class="form-select w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('district_id') border-red-500 @enderror" 
                                        name="district_id" required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    @error('district_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="village_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-home mr-1 text-primary-500"></i>
                                        Kelurahan/Desa
                                    </label>
                                    <select id="village_id" 
                                        class="form-select w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('village_id') border-red-500 @enderror" 
                                        name="village_id" required>
                                        <option value="">Pilih Kelurahan/Desa</option>
                                    </select>
                                    @error('village_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-mail-bulk mr-1 text-primary-500"></i>
                                        Kode Pos
                                    </label>
                                    <input id="kode_pos" type="text" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('kode_pos') border-red-500 @enderror" 
                                        name="kode_pos" value="{{ old('kode_pos') }}" required maxlength="5"
                                        placeholder="5 digit angka">
                                    @error('kode_pos')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="alamat_sekolah" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-map-marked-alt mr-1 text-primary-500"></i>
                                        Alamat Sekolah
                                    </label>
                                    <textarea id="alamat_sekolah" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('alamat_sekolah') border-red-500 @enderror" 
                                        name="alamat_sekolah" required rows="3"
                                        placeholder="Alamat lengkap sekolah">{{ old('alamat_sekolah') }}</textarea>
                                    @error('alamat_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="px-6 py-4 bg-gray-50 flex justify-between items-center border-t border-gray-200">
                        <button 
                            type="button" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
                            x-show="activeStep > 1"
                            @click="activeStep--">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Sebelumnya
                        </button>
                        <div class="flex space-x-2">
                            <button 
                                type="button" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
                                x-show="activeStep < 3"
                                @click="activeStep++">
                                Selanjutnya
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
                                x-show="activeStep === 3">
                                <i class="fas fa-check mr-2"></i>
                                Daftar Sekolah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            // Toggle eye icon
            const icon = event.currentTarget;
            if (type === 'text') {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Image preview
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.getElementById('preview-container');
                    const previewImage = document.getElementById('preview-image');
                    
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Location dropdowns
        document.addEventListener('DOMContentLoaded', function() {
    // Select Elements
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const villageSelect = document.getElementById('village_id');
    
    // Form Elements
    const npsnInput = document.getElementById('npsn');
    const kodeposInput = document.getElementById('kode_pos');
    const nipInput = document.getElementById('nip_kepala_sekolah');
    const form = document.querySelector('form');

    // Input Masking
    npsnInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
    });

    kodeposInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);
    });

    nipInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18);
    });

    // Location Change Handlers
    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        if (provinceId) {
            fetchCities(provinceId);
            citySelect.disabled = false;
        } else {
            resetSelect(citySelect);
            resetSelect(districtSelect);
            resetSelect(villageSelect);
        }
    });

    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        if (cityId) {
            fetchDistricts(cityId);
            districtSelect.disabled = false;
        } else {
            resetSelect(districtSelect);
            resetSelect(villageSelect);
        }
    });

    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        if (districtId) {
            fetchVillages(districtId);
            villageSelect.disabled = false;
        } else {
            resetSelect(villageSelect);
        }
    });

    // Fetch Functions
    async function fetchCities(provinceId) {
        try {
            showLoader(citySelect);
            const response = await fetch(`/getcities/${provinceId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const cities = await response.json();
            
            populateSelect(citySelect, cities, 'Pilih Kota/Kabupaten');
        } catch (error) {
            console.error('Error fetching cities:', error);
            showError(citySelect, 'Gagal memuat data kota');
        } finally {
            hideLoader(citySelect);
        }
    }

    async function fetchDistricts(cityId) {
        try {
            showLoader(districtSelect);
            const response = await fetch(`/getdistricts/${cityId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const districts = await response.json();
            
            populateSelect(districtSelect, districts, 'Pilih Kecamatan');
        } catch (error) {
            console.error('Error fetching districts:', error);
            showError(districtSelect, 'Gagal memuat data kecamatan');
        } finally {
            hideLoader(districtSelect);
        }
    }

    async function fetchVillages(districtId) {
        try {
            showLoader(villageSelect);
            const response = await fetch(`/getvillages/${districtId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const villages = await response.json();
            
            populateSelect(villageSelect, villages, 'Pilih Kelurahan/Desa');
        } catch (error) {
            console.error('Error fetching villages:', error);
            showError(villageSelect, 'Gagal memuat data kelurahan/desa');
        } finally {
            hideLoader(villageSelect);
        }
    }

    // Utility Functions
    function resetSelect(selectElement) {
        selectElement.innerHTML = `<option value="">Pilih ${selectElement.getAttribute('data-placeholder') || 'Pilih'}</option>`;
        selectElement.disabled = true;
    }

    function populateSelect(selectElement, data, placeholder) {
        selectElement.innerHTML = `<option value="">${placeholder}</option>`;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;
            selectElement.appendChild(option);
        });
        selectElement.disabled = false;
    }

    function showLoader(element) {
        const parent = element.parentElement;
        if (!parent.querySelector('.loader')) {
            const loader = document.createElement('div');
            loader.className = 'loader absolute right-8 top-10';
            loader.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
            parent.style.position = 'relative';
            parent.appendChild(loader);
        }
    }

    function hideLoader(element) {
        const loader = element.parentElement.querySelector('.loader');
        if (loader) {
            loader.remove();
        }
    }

    function showError(element, message) {
        const errorDiv = document.createElement('p');
        errorDiv.className = 'mt-1 text-sm text-red-600 error-message';
        errorDiv.textContent = message;
        
        // Remove any existing error message
        const existingError = element.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        element.parentElement.appendChild(errorDiv);
    }

    // Form Submission Handler
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Remove all existing error messages
        document.querySelectorAll('.error-message').forEach(error => error.remove());
        
        // Basic client-side validation
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                showError(field, 'Bidang ini wajib diisi');
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
            }
        });

        if (isValid) {
            try {
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                `;
                
                form.submit();
            } catch (error) {
                console.error('Error submitting form:', error);
                showError(form.querySelector('button[type="submit"]'), 'Gagal menyimpan data. Silakan coba lagi.');
            }
        }
    });

    // Initialize form if there's old data (after validation error)
    if (provinceSelect.value) {
        fetchCities(provinceSelect.value).then(() => {
            if (citySelect.dataset.oldValue) {
                citySelect.value = citySelect.dataset.oldValue;
                fetchDistricts(citySelect.value).then(() => {
                    if (districtSelect.dataset.oldValue) {
                        districtSelect.value = districtSelect.dataset.oldValue;
                        fetchVillages(districtSelect.value).then(() => {
                            if (villageSelect.dataset.oldValue) {
                                villageSelect.value = villageSelect.dataset.oldValue;
                            }
                        });
                    }
                });
            }
        });
    }
});
    </script>
</body>
</html>