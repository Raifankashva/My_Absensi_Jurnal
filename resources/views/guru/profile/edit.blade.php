@extends('layouts.app3')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header with back button -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-white">Edit Profil</h1>
            <a href="{{ route('guru.profile') }}" class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 text-sm font-medium rounded-md shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
        
        <!-- Error messages -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm text-red-700">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        
        <div class="p-6">
            <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Profile image section -->
                    <div class="md:w-1/3 flex flex-col items-center">
                        <div class="mb-4 relative">
                            @if($guru->foto)
                                <img id="profile-preview" src="{{ asset('storage/guru-photos/' . $guru->foto) }}" 
                                    alt="Foto {{ $guru->nama_lengkap }}" class="w-48 h-48 rounded-full object-cover border-4 border-indigo-100 shadow-md">
                            @else
                                <img id="profile-preview" src="{{ asset('images/default-profile.png') }}" 
                                    alt="Default Profile" class="w-48 h-48 rounded-full object-cover border-4 border-indigo-100 shadow-md">
                            @endif
                        </div>
                        
                        <div class="w-full max-w-xs">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="foto">
                                Foto Profil
                            </label>
                            <div class="mt-1 flex items-center justify-center">
                                <label for="foto" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                    <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Pilih foto profil baru
                                </label>
                                <input id="foto" name="foto" type="file" accept="image/*" class="sr-only">
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Ukuran maksimal 2MB (JPG, JPEG, PNG)
                            </p>
                        </div>
                    </div>
                    
                    <!-- Form fields section -->
                    <div class="md:w-2/3">
                        <!-- Basic Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">
                                Informasi Dasar
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Lengkap
                                    </label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" 
                                        value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email" 
                                        value="{{ old('email', $user->email) }}" required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">
                                        No. HP
                                    </label>
                                    <input type="text" id="no_hp" name="no_hp" 
                                        value="{{ old('no_hp', $guru->no_hp) }}" required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                                        Alamat
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="3" required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('alamat', $guru->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Password Change -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">
                                Ubah Password
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Password Saat Ini
                                    </label>
                                    <input type="password" id="current_password" name="current_password"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Kosongkan jika tidak ingin mengubah password
                                    </p>
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Password Baru
                                    </label>
                                    <input type="password" id="password" name="password"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Konfirmasi Password Baru
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
</div>

<script>
    // Preview foto yang dipilih
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('profile-preview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
