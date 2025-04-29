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
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'card': '0 0 20px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
        
        /* Map styles */
        #map {
            height: 400px;
            width: 100%;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Form focus styles */
        .form-input:focus, .form-select:focus {
            box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.3);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="{ activeStep: 1 }">
        
        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-6 max-w-4xl w-full animate-fade-in" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ $errors->first() }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button type="button" class="inline-flex text-red-500 hover:text-red-600 focus:outline-none">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="w-full max-w-4xl">
            <div class="text-center mb-10">
                <div class="flex justify-center mb-4">
                    <div class="bg-gradient-to-r from-primary-600 to-primary-500 p-4 rounded-full shadow-lg transform transition-transform hover:scale-105">
                        <i class="fas fa-school text-white text-3xl"></i>
                    </div>
                </div>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight">
                    Pendaftaran Sekolah Baru
                </h2>
                <p class="mt-3 text-base text-gray-600 max-w-xl mx-auto">
                    Silakan lengkapi formulir berikut untuk mendaftarkan sekolah Anda ke dalam sistem kami
                </p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-10">
                <div class="flex justify-between items-center">
                    <!-- Step 1 -->
                    <div class="relative flex flex-col items-center" :class="activeStep >= 1 ? 'text-primary-600' : 'text-gray-400'">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 transition-colors duration-300"
                            :class="activeStep >= 1 ? 'bg-primary-50 border-primary-500' : 'bg-gray-100 border-gray-300'">
                            <i class="fas fa-user-circle text-lg"></i>
                        </div>
                        <div class="absolute -bottom-6 w-max text-center">
                            <p class="text-sm font-medium">Akun</p>
                        </div>
                    </div>
                    
                    <!-- Line 1 -->
                    <div class="flex-1 mx-2">
                        <div class="h-1 rounded-full transition-colors duration-300" 
                            :class="activeStep >= 2 ? 'bg-primary-500' : 'bg-gray-200'"></div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="relative flex flex-col items-center" :class="activeStep >= 2 ? 'text-primary-600' : 'text-gray-400'">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 transition-colors duration-300"
                            :class="activeStep >= 2 ? 'bg-primary-50 border-primary-500' : 'bg-gray-100 border-gray-300'">
                            <i class="fas fa-school text-lg"></i>
                        </div>
                        <div class="absolute -bottom-6 w-max text-center">
                            <p class="text-sm font-medium">Sekolah</p>
                        </div>
                    </div>
                    
                    <!-- Line 2 -->
                    <div class="flex-1 mx-2">
                        <div class="h-1 rounded-full transition-colors duration-300" 
                            :class="activeStep >= 3 ? 'bg-primary-500' : 'bg-gray-200'"></div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="relative flex flex-col items-center" :class="activeStep >= 3 ? 'text-primary-600' : 'text-gray-400'">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 transition-colors duration-300"
                            :class="activeStep >= 3 ? 'bg-primary-50 border-primary-500' : 'bg-gray-100 border-gray-300'">
                            <i class="fas fa-map-marker-alt text-lg"></i>
                        </div>
                        <div class="absolute -bottom-6 w-max text-center">
                            <p class="text-sm font-medium">Lokasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-card rounded-2xl overflow-hidden border border-gray-100 mt-8">
                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('school.register') }}" enctype="multipart/form-data" class="relative">
                    @csrf

                    <!-- Step 1: Account Information -->
                    <div x-show="activeStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="bg-gradient-to-r from-primary-600 to-primary-500 px-6 py-5">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-user-circle mr-3"></i>
                                Informasi Akun
                            </h3>
                        </div>
                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-user mr-2 text-primary-500"></i>
                                        Nama Sekolah
                                    </label>
                                    <input id="name" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('name') border-red-500 @enderror" 
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-envelope mr-2 text-primary-500"></i>
                                        Email
                                    </label>
                                    <input id="email" type="email" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('email') border-red-500 @enderror" 
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="contoh@email.com">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-lock mr-2 text-primary-500"></i>
                                        Password
                                    </label>
                                    <div class="relative">
                                        <input id="password" type="password" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('password') border-red-500 @enderror" 
                                            name="password" required autocomplete="new-password"
                                            placeholder="Minimal 8 karakter">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer">
                                            <i class="fas fa-eye hover:text-primary-500 transition-colors" onclick="togglePasswordVisibility('password')"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-lock mr-2 text-primary-500"></i>
                                        Konfirmasi Password
                                    </label>
                                    <div class="relative">
                                        <input id="password-confirm" type="password" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" 
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Ulangi password">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer">
                                            <i class="fas fa-eye hover:text-primary-500 transition-colors" onclick="togglePasswordVisibility('password-confirm')"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-home mr-2 text-primary-500"></i>
                                        Alamat Admin
                                    </label>
                                    <input id="alamat" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('alamat') border-red-500 @enderror" 
                                        name="alamat" value="{{ old('alamat') }}" required
                                        placeholder="Alamat lengkap">
                                    @error('alamat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-phone mr-2 text-primary-500"></i>
                                        No. HP Admin
                                    </label>
                                    <input id="no_hp" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('no_hp') border-red-500 @enderror" 
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
                    <div x-show="activeStep === 2" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="bg-gradient-to-r from-primary-600 to-primary-500 px-6 py-5">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-school mr-3"></i>
                                Informasi Sekolah
                            </h3>
                        </div>
                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label for="npsn" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-id-card mr-2 text-primary-500"></i>
                                        NPSN
                                    </label>
                                    <input id="npsn" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('npsn') border-red-500 @enderror" 
                                        name="npsn" value="{{ old('npsn') }}" required maxlength="8"
                                        placeholder="8 digit angka">
                                    @error('npsn')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="nama_sekolah" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-building mr-2 text-primary-500"></i>
                                        Nama Sekolah
                                    </label>
                                    <input id="nama_sekolah" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('nama_sekolah') border-red-500 @enderror" 
                                        name="nama_sekolah" value="{{ old('nama_sekolah') }}" required
                                        placeholder="Nama lengkap sekolah">
                                    @error('nama_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="jenjang" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-graduation-cap mr-2 text-primary-500"></i>
                                        Jenjang
                                    </label>
                                    <select id="jenjang" 
                                        class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('jenjang') border-red-500 @enderror" 
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

                                <div class="space-y-2">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-info-circle mr-2 text-primary-500"></i>
                                        Status
                                    </label>
                                    <select id="status" 
                                        class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('status') border-red-500 @enderror" 
                                        name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Negeri" {{ old('status') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                        <option value="Swasta" {{ old('status') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="akreditasi" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-award mr-2 text-primary-500"></i>
                                        Akreditasi
                                    </label>
                                    <select id="akreditasi" 
                                        class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('akreditasi') border-red-500 @enderror" 
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

                                <div class="space-y-2">
                                    <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-phone-alt mr-2 text-primary-500"></i>
                                        No. Telepon Sekolah
                                    </label>
                                    <input id="no_telp" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('no_telp') border-red-500 @enderror" 
                                        name="no_telp" value="{{ old('no_telp') }}" required
                                        placeholder="021xxxxxxxx">
                                    @error('no_telp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-globe mr-2 text-primary-500"></i>
                                        Website
                                    </label>
                                    <input id="website" type="url" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('website') border-red-500 @enderror" 
                                        name="website" value="{{ old('website') }}"
                                        placeholder="https://www.example.com">
                                    @error('website')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="kepala_sekolah" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-user-tie mr-2 text-primary-500"></i>
                                        Nama Kepala Sekolah
                                    </label>
                                    <input id="kepala_sekolah" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('kepala_sekolah') border-red-500 @enderror" 
                                        name="kepala_sekolah" value="{{ old('kepala_sekolah') }}" required
                                        placeholder="Nama lengkap kepala sekolah">
                                    @error('kepala_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="nip_kepala_sekolah" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-id-badge mr-2 text-primary-500"></i>
                                        NIP Kepala Sekolah
                                    </label>
                                    <input id="nip_kepala_sekolah" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('nip_kepala_sekolah') border-red-500 @enderror" 
                                        name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah') }}" maxlength="18"
                                        placeholder="18 digit angka">
                                    @error('nip_kepala_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-image mr-2 text-primary-500"></i>
                                        Foto Sekolah
                                    </label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors duration-200 bg-gray-50">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500 px-3 py-2 shadow-sm">
                                                    <span>Upload file</span>
                                                    <input id="foto" name="foto" type="file" class="sr-only" accept="image/*">
                                                </label>
                                                <p class="pl-1 pt-2">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF hingga 10MB
                                            </p>
                                            <div id="preview-container" class="hidden mt-4">
                                                <img id="preview-image" class="mx-auto h-40 object-cover rounded-lg shadow-sm" src="#" alt="Preview">
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
                    <div x-show="activeStep === 3" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="bg-gradient-to-r from-primary-600 to-primary-500 px-6 py-5">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-map-marker-alt mr-3"></i>
                                Informasi Lokasi
                            </h3>
                        </div>
                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label for="province_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-map mr-2 text-primary-500"></i>
                                        Provinsi
                                    </label>
                                    <select id="province_id" 
                                        class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('province_id') border-red-500 @enderror" 
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

                                <div class="space-y-2">
                                    <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-city mr-2 text-primary-500"></i>
                                        Kabupaten/Kota
                                    </label>
                                    <select id="city_id" 
                                        class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('city_id') border-red-500 @enderror" 
                                        name="city_id" required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                    @error('city_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="district_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-map-signs mr-2 text-primary-500"></i>
                                        Kecamatan
                                    </label>
                                    <select id="district_id" 
                                        class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('district_id') border-red-500 @enderror" 
                                        name="district_id" required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    @error('district_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="village_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-home mr-2 text-primary-500"></i>
                                        Kelurahan/Desa
                                    </label>
                                    <select id="village_id" 
                                        class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('village_id') border-red-500 @enderror" 
                                        name="village_id" required>
                                        <option value="">Pilih Kelurahan/Desa</option>
                                    </select>
                                    @error('village_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-mail-bulk mr-2 text-primary-500"></i>
                                        Kode Pos
                                    </label>
                                    <input id="kode_pos" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('kode_pos') border-red-500 @enderror" 
                                        name="kode_pos" value="{{ old('kode_pos') }}" required maxlength="5"
                                        placeholder="5 digit angka">
                                    @error('kode_pos')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="alamat_sekolah" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-map-marked-alt mr-2 text-primary-500"></i>
                                        Alamat Sekolah
                                    </label>
                                    <textarea id="alamat_sekolah" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('alamat_sekolah') border-red-500 @enderror" 
                                        name="alamat_sekolah" required rows="3"
                                        placeholder="Alamat lengkap sekolah">{{ old('alamat_sekolah') }}</textarea>
                                    @error('alamat_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Map Section -->
                                <div class="md:col-span-2 mt-4">
                                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                        <div class="bg-gradient-to-r from-primary-50 to-blue-50 px-6 py-4 border-b border-gray-100">
                                            <h5 class="font-medium text-gray-800 flex items-center">
                                                <i class="fas fa-map-marked-alt mr-2 text-primary-500"></i>
                                                Lokasi Sekolah pada Peta
                                            </h5>
                                        </div>
                                        <div class="p-6">
                                            <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-6 rounded-r-lg">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-info-circle text-blue-500"></i>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm">Tandai lokasi sekolah pada peta untuk mendapatkan koordinat yang akurat. Klik pada peta atau gunakan fitur pencarian untuk menandai lokasi.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="flex flex-wrap gap-4 mb-4">
                                                <button type="button" id="get-current-location" class="inline-flex items-center px-4 py-2 border border-primary-300 rounded-lg shadow-sm text-primary-700 bg-primary-50 hover:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                                    <i class="fas fa-map-marker-alt mr-2"></i> Gunakan Lokasi Saat Ini
                                                </button>
                                                <button type="button" id="search-address-button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                                    <i class="fas fa-search mr-2"></i> Cari Alamat di Peta
                                                </button>
                                            </div>
                                            
                                            <!-- Map Container -->
                                            <div id="map" class="rounded-xl shadow-md border border-gray-200"></div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                                    <div id="selected-coordinates" class="text-sm">
                                                        <strong class="text-gray-700">Koordinat belum dipilih</strong>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                                    <div id="address-from-map" class="text-sm">
                                                        <strong class="text-gray-700">Alamat dari peta akan muncul di sini</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Hidden fields for form submission -->
                                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                                            
                                            <div class="mt-4">
                                                <p class="text-xs text-gray-500 flex items-start">
                                                    <i class="fas fa-exclamation-circle mt-0.5 mr-2 text-gray-400"></i>
                                                    Pastikan lokasi yang ditandai sudah benar sebelum melanjutkan pendaftaran.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="px-8 py-5 bg-gray-50 flex justify-between items-center border-t border-gray-100 rounded-b-2xl">
                        <button 
                            type="button" 
                            class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
                            x-show="activeStep > 1"
                            @click="activeStep--">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Sebelumnya
                        </button>
                        <div x-show="activeStep === 1"></div>
                        <div class="flex space-x-3">
                            <button 
                                type="button" 
                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
                                x-show="activeStep < 3"
                                @click="activeStep++">
                                Selanjutnya
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
                                x-show="activeStep === 3">
                                <i class="fas fa-check mr-2"></i>
                                Daftar Sekolah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Help Text -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>Butuh bantuan? <a href="#" class="text-primary-600 hover:text-primary-500 font-medium">Hubungi kami</a> atau kunjungi <a href="#" class="text-primary-600 hover:text-primary-500 font-medium">pusat bantuan</a>.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    
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
                        <svg class="animate-spin h-5 w-5 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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

            // Initialize map
            initializeMap();

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

        // Map initialization
        function initializeMap() {
            // Initialize the map (centered on Indonesia)
            var map = L.map('map').setView([-2.5489, 118.0149], 5);
            
            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add search control with more options
            var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: 'Cari lokasi...',
                errorMessage: 'Lokasi tidak ditemukan.',
                suggestMinLength: 3,
                suggestTimeout: 250,
                queryMinLength: 3
            }).addTo(map);
            
            geocoder.on('markgeocode', function(e) {
                var bbox = e.geocode.bbox;
                var poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]).addTo(map);
                
                map.fitBounds(poly.getBounds());
                
                // Select this point
                updateMarkerPosition(e.geocode.center);
            });
            
            // Add zoom control
            L.control.zoom({
                position: 'bottomright'
            }).addTo(map);
            
            // Add scale control
            L.control.scale({
                imperial: false,
                metric: true
            }).addTo(map);
            
            // Initialize marker variable
            var marker;
            var latitude = document.getElementById('latitude').value;
            var longitude = document.getElementById('longitude').value;
            
            // If we have saved coordinates, set the marker and map view
            if (latitude && longitude) {
                map.setView([latitude, longitude], 15);
                marker = L.marker([latitude, longitude], {
                    draggable: true
                }).addTo(map);
                updateCoordinatesDisplay(latitude, longitude);
                
                // Add drag event to update coordinates
                marker.on('dragend', function(e) {
                    updateMarkerPosition(e.target.getLatLng());
                });
            }
            
            // Function to update the marker position and form values
            function updateMarkerPosition(latlng) {
                var lat = latlng.lat.toFixed(7);
                var lng = latlng.lng.toFixed(7);
                
                // Update hidden form fields
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                // Update the coordinates display
                updateCoordinatesDisplay(lat, lng);
                
                // Update or add marker
                if (marker) {
                    marker.setLatLng(latlng);
                } else {
                    marker = L.marker(latlng, {
                        draggable: true
                    }).addTo(map);
                    
                    // Add drag event to update coordinates
                    marker.on('dragend', function(e) {
                        updateMarkerPosition(e.target.getLatLng());
                    });
                }
                
                // Try to get address information from the coordinates
                fetchAddressFromCoordinates(lat, lng);
            }
            
            // Function to update the coordinates display
            function updateCoordinatesDisplay(lat, lng) {
                document.getElementById('selected-coordinates').innerHTML = 
                    '<strong class="text-gray-700">Latitude:</strong> ' + lat + '<br>' +
                    '<strong class="text-gray-700">Longitude:</strong> ' + lng;
            }
            
            // Handle map click event
            map.on('click', function(e) {
                updateMarkerPosition(e.latlng);
            });
            
            // Try to get user's location to center the map
            document.getElementById('get-current-location').addEventListener('click', function() {
                if (navigator.geolocation) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';
                    this.disabled = true;
                    
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;
                            
                            map.setView([lat, lng], 16);
                            updateMarkerPosition(L.latLng(lat, lng));
                            
                            document.getElementById('get-current-location').innerHTML = 
                                '<i class="fas fa-map-marker-alt"></i> Gunakan Lokasi Saat Ini';
                            document.getElementById('get-current-location').disabled = false;
                        },
                        function(error) {
                            console.error('Error getting location:', error);
                            alert('Gagal mendapatkan lokasi: ' + error.message);
                            
                            document.getElementById('get-current-location').innerHTML = 
                                '<i class="fas fa-map-marker-alt"></i> Gunakan Lokasi Saat Ini';
                            document.getElementById('get-current-location').disabled = false;
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    alert('Geolocation tidak didukung oleh browser Anda.');
                }
            });
            
            // Function to get address from coordinates
            function fetchAddressFromCoordinates(lat, lng) {
                // Show loading indicator
                document.getElementById('address-from-map').innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mencari alamat...';
                
                // Use your backend endpoint or direct Nominatim
                fetch(`/reverse-geocode?latitude=${lat}&longitude=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            document.getElementById('address-from-map').innerHTML = 
                                '<strong class="text-gray-700">Alamat:</strong> Tidak dapat menemukan alamat untuk lokasi ini.';
                            return;
                        }
                        
                        document.getElementById('address-from-map').innerHTML = 
                            `<strong class="text-gray-700">Alamat terdeteksi:</strong><br>${data.full_address}`;
                    })
                    .catch(error => {
                        console.error('Error fetching address:', error);
                        document.getElementById('address-from-map').innerHTML = 
                            '<strong class="text-gray-700">Alamat:</strong> Gagal mendapatkan alamat. Coba lagi nanti.';
                    });
            }
            
            // Update map when address fields change
            function updateMapFromAddressFields() {
                var addressParts = [];
                
                // Get values from address fields
                var alamat = document.querySelector('textarea[name="alamat_sekolah"]').value;
                if (alamat) addressParts.push(alamat);
                
                var villageSelect = document.querySelector('select[name="village_id"]');
                if (villageSelect && villageSelect.selectedIndex > 0) {
                    var villageName = villageSelect.options[villageSelect.selectedIndex].text;
                    if (villageName && villageName !== 'Pilih Kelurahan/Desa') addressParts.push(villageName);
                }
                
                var districtSelect = document.querySelector('select[name="district_id"]');
                if (districtSelect && districtSelect.selectedIndex > 0) {
                    var districtName = districtSelect.options[districtSelect.selectedIndex].text;
                    if (districtName && districtName !== 'Pilih Kecamatan') addressParts.push(districtName);
                }
                
                var citySelect = document.querySelector('select[name="city_id"]');
                if (citySelect && citySelect.selectedIndex > 0) {
                    var cityName = citySelect.options[citySelect.selectedIndex].text;
                    if (cityName && cityName !== 'Pilih Kabupaten/Kota') addressParts.push(cityName);
                }
                
                var provinceSelect = document.querySelector('select[name="province_id"]');
                if (provinceSelect && provinceSelect.selectedIndex > 0) {
                    var provinceName = provinceSelect.options[provinceSelect.selectedIndex].text;
                    if (provinceName && provinceName !== 'Pilih Provinsi') addressParts.push(provinceName);
                }
                
                addressParts.push('Indonesia');
                
                var fullAddress = addressParts.join(', ');
                if (fullAddress && fullAddress !== 'Indonesia') {
                    document.getElementById('search-address-button').disabled = true;
                    document.getElementById('search-address-button').innerHTML = 
                        '<i class="fas fa-spinner fa-spin mr-2"></i> Mencari...';
                    
                    // Use the geocoder to search for the address
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('search-address-button').disabled = false;
                            document.getElementById('search-address-button').innerHTML = 
                                '<i class="fas fa-search mr-2"></i> Cari Alamat di Peta';
                            
                            if (data && data.length > 0) {
                                var lat = parseFloat(data[0].lat);
                                var lon = parseFloat(data[0].lon);
                                
                                map.setView([lat, lon], 15);
                                updateMarkerPosition(L.latLng(lat, lon));
                            } else {
                                alert('Alamat tidak ditemukan di peta. Silakan coba dengan alamat yang lebih spesifik atau tandai lokasi secara manual.');
                            }
                        })
                        .catch(error => {
                            console.error('Error searching address:', error);
                            document.getElementById('search-address-button').disabled = false;
                            document.getElementById('search-address-button').innerHTML = 
                                '<i class="fas fa-search mr-2"></i> Cari Alamat di Peta';
                            alert('Gagal mencari alamat. Silakan coba lagi nanti.');
                        });
                } else {
                    alert('Silakan isi alamat sekolah dan pilih lokasi administratif terlebih dahulu.');
                }
            }
            
            // Add handler for searching address on the map
            document.getElementById('search-address-button').addEventListener('click', function(e) {
                e.preventDefault();
                updateMapFromAddressFields();
            });
            
            // Make the map resize properly when shown in tabs/accordions
            setTimeout(function() {
                map.invalidateSize();
            }, 0);
        }
    </script>
</body>
</html>
