@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Pengaturan Jam Sekolah
            </h1>
            <p class="mt-3 text-lg text-gray-500">
                Atur jam masuk dan batas keterlambatan untuk setiap sekolah
            </p>
        </div>

        <!-- Card Container -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-5">
                <div class="flex items-center">
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="ml-4 text-xl font-bold text-white">
                        Pengaturan Jam Masuk Sekolah
                    </h2>
                </div>
            </div>

            <!-- Form Section -->
            <form action="{{ route('settings.store') }}" method="POST" class="px-6 py-8">
                @csrf
                
                <!-- School Selection -->
                <div class="mb-6">
                    <label for="sekolah_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Sekolah <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="sekolah_id" name="sekolah_id" class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                            <option value="">-- Pilih Sekolah --</option>
                            @foreach ($sekolahs as $sekolah)
                                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Pilih sekolah yang akan diatur jam masuknya</p>
                </div>

                <!-- Time Settings -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Entry Time -->
                    <div class="space-y-2">
                        <label for="jam_masuk" class="block text-sm font-medium text-gray-700">
                            Jam Masuk <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="time" id="jam_masuk" name="jam_masuk" class="pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                        </div>
                        <p class="text-sm text-gray-500">Waktu siswa harus sudah berada di sekolah</p>
                    </div>

                    <!-- Late Limit -->
                    <div class="space-y-2">
                        <label for="batas_terlambat" class="block text-sm font-medium text-gray-700">
                            Batas Terlambat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="time" id="batas_terlambat" name="batas_terlambat" class="pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                        </div>
                        <p class="text-sm text-gray-500">Batas waktu maksimal keterlambatan</p>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Pengaturan jam masuk akan berpengaruh pada perhitungan keterlambatan siswa. Pastikan pengaturan sudah sesuai dengan kebijakan sekolah.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Help Text -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Butuh bantuan? Hubungi administrator sistem di 
                <a href="mailto:admin@sekolah.com" class="text-blue-600 hover:text-blue-800 font-medium">admin@sekolah.com</a>
            </p>
        </div>
    </div>
</div>
@endsection
