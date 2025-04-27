@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="min-h-screen relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <!-- Primary gradient blob -->
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-br from-blue-600/20 via-blue-500/20 to-indigo-600/20 rounded-full blur-3xl animate-blob"></div>
        <!-- Secondary gradient blob -->
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-gradient-to-tr from-sky-500/20 via-blue-400/20 to-indigo-500/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <!-- Center gradient blob -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-gradient-to-r from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
        
        <!-- Decorative elements -->
        <div class="absolute top-20 left-[20%] w-8 h-8 bg-blue-500/30 rounded-full blur-sm animate-pulse"></div>
        <div class="absolute top-[40%] right-[15%] w-6 h-6 bg-indigo-500/30 rounded-full blur-sm animate-pulse animation-delay-1000"></div>
        <div class="absolute bottom-[30%] left-[10%] w-10 h-10 bg-sky-500/30 rounded-full blur-sm animate-pulse animation-delay-2000"></div>
        
        <!-- Grid pattern overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMwLTkuOTQtOC4wNi0xOC0xOC0xOFYyYzcuNzMyIDAgMTQgNi4yNjggMTQgMTRoMnptLTIgMGMwIDcuNzMyLTYuMjY4IDE0LTE0IDE0djJjOS45NCAwIDE4LTguMDYgMTgtMThoLTJ6IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9Ii4wNSIvPjxwYXRoIGQ9Ik0yMCA0NGMwIDkuOTQgOC4wNiAxOCAxOCAxOHYtMmMtNy43MzIgMC0xNC02LjI2OC0xNC0xNGgtMnptMiAwYzAtNy43MzIgNi4yNjgtMTQgMTQtMTR2LTJjLTkuOTQgMC0xOCA4LjA2LTE4IDE4aDJ6IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9Ii4wNSIvPjwvZz48L3N2Zz4=')] opacity-30"></div>
    </div>

    <!-- Hero Section -->
    <div class="relative z-10 container mx-auto px-4 py-12 lg:py-20">
        <div class="text-center mb-16 lg:mb-20 opacity-0 animate-fade-in">
            <div class="flex justify-center mb-8">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-5 rounded-2xl shadow-[0_0_30px_rgba(37,99,235,0.5)] transform hover:scale-110 transition-all duration-500 hover:shadow-[0_0_50px_rgba(37,99,235,0.7)]">
                    <i class="bx bxs-school text-5xl text-white"></i>
                </div>
            </div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-800 mb-4">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700">My Absensi Jurnal</span>
            </h1>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 bg-clip-text text-transparent mb-6 leading-tight">
                Sistem Informasi Akademik Terpadu
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-8">
                Platform digital untuk pengelolaan absensi, jurnal mengajar guru, dan data siswa secara efektif dan terintegrasi
            </p>
            
            <!-- Hero CTA Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
                <a href="{{ route('login') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center group">
                    <span>Masuk ke Sistem</span>
                    <i class="bx bx-right-arrow-alt ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
                <a href="#panduan" class="px-8 py-4 bg-white text-blue-700 font-semibold rounded-xl shadow-lg hover:shadow-blue-500/20 transform hover:-translate-y-1 transition-all duration-300 border border-blue-100 flex items-center justify-center">
                    <i class="bx bx-book-open mr-2"></i>
                    <span>Lihat Panduan</span>
                </a>
                <a href="{{ route('school.register.form')}}" class="px-8 py-4 bg-white text-blue-700 font-semibold rounded-xl shadow-lg hover:shadow-blue-500/20 transform hover:-translate-y-1 transition-all duration-300 border border-blue-100 flex items-center justify-center">
                <i class="bx bxs-registered     ">
                    <span>Daftar Sekolah</span>
                </i>
                </a>
            </div>
        </div>

        <!-- Main Features -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-16">
            @php
            $features = [
                [
                    'icon' => 'bxs-time-five',
                    'color' => 'blue',
                    'title' => 'Absensi Digital',
                    'description' => 'Sistem absensi digital yang mudah untuk guru dan siswa dengan laporan kehadiran real-time.'
                ],
                [
                    'icon' => 'bxs-book-content',
                    'color' => 'indigo',
                    'title' => 'Jurnal Mengajar',
                    'description' => 'Dokumentasi aktivitas pembelajaran harian guru lengkap dengan materi dan capaian pembelajaran.'
                ],
                [
                    'icon' => 'bxs-user-detail',
                    'color' => 'sky',
                    'title' => 'Data Siswa & Kelas',
                    'description' => 'Pengelolaan data siswa dan kelas yang terstruktur dengan informasi akademik lengkap.'
                ],
                [
                    'icon' => 'bxs-report',
                    'color' => 'blue',
                    'title' => 'Laporan & Analisis',
                    'description' => 'Generate laporan detail tentang kehadiran, aktivitas pembelajaran, dan perkembangan siswa.'
                ],
                [
                    'icon' => 'bxs-notification',
                    'color' => 'indigo',
                    'title' => 'Notifikasi Langsung',
                    'description' => 'Sistem notifikasi real-time untuk informasi penting terkait absensi dan aktivitas akademik.'
                ],
                [
                    'icon' => 'bxs-devices',
                    'color' => 'sky',
                    'title' => 'Akses Multi-Platform',
                    'description' => 'Akses sistem melalui berbagai perangkat dengan tampilan yang responsif.'
                ]
            ];
            @endphp

            @foreach ($features as $index => $feature)
            <div class="feature-card group bg-white/80 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:shadow-2xl transform transition-all duration-500 hover:-translate-y-2 border border-blue-50 opacity-0 animate-fade-in" style="animation-delay: {{ 100 + ($index * 100) }}ms">
                <div class="bg-gradient-to-br from-{{ $feature['color'] }}-500 to-{{ $feature['color'] }}-700 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500 shadow-lg shadow-{{ $feature['color'] }}-500/20">
                    <i class="bx {{ $feature['icon'] }} text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-blue-900 mb-3 group-hover:text-blue-700 transition-colors duration-300">{{ $feature['title'] }}</h3>
                <p class="text-gray-600">{{ $feature['description'] }}</p>
                
                <!-- Feature card hover effect -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-{{ $feature['color'] }}-500/0 to-{{ $feature['color'] }}-700/0 opacity-0 group-hover:opacity-10 transition-opacity duration-500 pointer-events-none"></div>
            </div>
            @endforeach
        </div>

        <!-- Quick Stats with animated counters -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-8 lg:p-10 shadow-xl mb-16 border border-blue-50 transform transition-all duration-500 hover:shadow-2xl opacity-0 animate-fade-in" style="animation-delay: 700ms">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @php
                $stats = [
                    ['number' => '99.8%', 'label' => 'Akurasi Absensi', 'icon' => 'bxs-check-circle', 'color' => 'blue'],
                    ['number' => '1000+', 'label' => 'Jurnal Per Bulan', 'icon' => 'bxs-book-open', 'color' => 'indigo'],
                    ['number' => '50+', 'label' => 'Kelas Aktif', 'icon' => 'bxs-group', 'color' => 'sky'],
                    ['number' => '24/7', 'label' => 'Dukungan Sistem', 'icon' => 'bxs-help-circle', 'color' => 'blue']
                ];
                @endphp

                @foreach ($stats as $index => $stat)
                <div class="text-center group" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-{{ $stat['color'] }}-100 to-{{ $stat['color'] }}-200 p-4 rounded-full mb-4 group-hover:scale-110 transition-transform duration-500 shadow-inner">
                        <i class="bx {{ $stat['icon'] }} text-3xl text-{{ $stat['color'] }}-600"></i>
                    </div>
                    <h4 class="text-2xl lg:text-3xl font-bold text-{{ $stat['color'] }}-700 mb-2 counter-value">{{ $stat['number'] }}</h4>
                    <p class="text-gray-600">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Login CTA with enhanced gradient -->
        <div class="text-center mb-20 opacity-0 animate-fade-in" style="animation-delay: 800ms">
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-700 rounded-2xl p-8 lg:p-10 shadow-2xl transform hover:scale-[1.02] transition-all duration-500 hover:shadow-blue-500/30 group">
                <!-- Animated background elements -->
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-2xl transform -translate-x-1/2 translate-y-1/2"></div>
                </div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Mulai Sekarang</h2>
                    <p class="text-blue-100 mb-8 max-w-2xl mx-auto">Bergabung dengan platform kami untuk pengalaman manajemen pendidikan yang lebih baik</p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('login') }}" class="bg-white text-blue-700 px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center group">
                            <i class="bx bx-log-in mr-2"></i>
                            <span>Masuk ke Sistem</span>
                            <i class="bx bx-chevron-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                        <a href="#panduan" class="bg-blue-700/50 backdrop-blur-sm text-white border border-white/20 px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                            <i class="bx bx-book-open mr-2"></i>
                            <span>Lihat Panduan</span>
                        </a>
                    </div>
                </div>
                
                <!-- Animated dots -->
                <div class="absolute top-1/4 right-1/4 w-2 h-2 bg-white rounded-full animate-ping"></div>
                <div class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-white rounded-full animate-ping animation-delay-1000"></div>
                <div class="absolute top-2/3 right-1/3 w-2 h-2 bg-white rounded-full animate-ping animation-delay-2000"></div>
            </div>
        </div>
    </div>

    <!-- Panduan Section with enhanced UI -->
    <div id="panduan" class="relative z-10 container mx-auto px-4 py-12 mb-16 opacity-0 animate-fade-in" style="animation-delay: 900ms">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-8 lg:p-10 shadow-xl border border-blue-50">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg mb-4">
                    <i class="bx bx-book-open text-2xl text-white"></i>
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 bg-clip-text text-transparent mb-4">Panduan Penggunaan Sistem</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Pelajari cara menggunakan fitur-fitur utama sistem untuk memaksimalkan pengalaman pengguna</p>
            </div>
            
            <!-- Panduan Tabs with enhanced styling -->
            <div x-data="{ activeTab: 'absensi' }" class="mb-10">
                <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-8 bg-blue-50/50 p-2 rounded-xl">
                    <button 
                        @click="activeTab = 'absensi'" 
                        :class="{ 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg': activeTab === 'absensi', 'bg-white text-gray-700 hover:bg-gray-50': activeTab !== 'absensi' }"
                        class="px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center">
                        <i class="bx bxs-time-five mr-2" :class="{ 'text-white': activeTab === 'absensi', 'text-blue-600': activeTab !== 'absensi' }"></i>
                        Absensi Digital
                    </button>
                    <button 
                        @click="activeTab = 'jurnal'" 
                        :class="{ 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg': activeTab === 'jurnal', 'bg-white text-gray-700 hover:bg-gray-50': activeTab !== 'jurnal' }"
                        class="px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center">
                        <i class="bx bxs-book-content mr-2" :class="{ 'text-white': activeTab === 'jurnal', 'text-blue-600': activeTab !== 'jurnal' }"></i>
                        Jurnal Mengajar
                    </button>
                    <button 
                        @click="activeTab = 'siswa'" 
                        :class="{ 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg': activeTab === 'siswa', 'bg-white text-gray-700 hover:bg-gray-50': activeTab !== 'siswa' }"
                        class="px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center">
                        <i class="bx bxs-user-detail mr-2" :class="{ 'text-white': activeTab === 'siswa', 'text-blue-600': activeTab !== 'siswa' }"></i>
                        Data Siswa
                    </button>
                </div>

                <!-- Absensi Content -->
                <div x-show="activeTab === 'absensi'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-blue-50 hover:shadow-xl transition-all duration-300 hover:border-blue-100">
                            <h3 class="text-xl font-semibold text-blue-800 mb-4 flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <i class="bx bx-list-ol text-xl text-blue-600"></i>
                                </div>
                                Cara Mengisi Absensi
                            </h3>
                            <ol class="space-y-4">
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-blue-500/20">1</div>
                                    <div class="bg-blue-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Login ke sistem menggunakan akun Anda</p>
                                    </div>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-blue-500/20">2</div>
                                    <div class="bg-blue-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Gunakan Qr Code untuk mengisi absensi yang berada pada halaman dashboard</p>
                                    </div>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-blue-500/20">3</div>
                                    <div class="bg-blue-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Jika sudah selesai dan muncul nama nisn dan kelas lalu tekan tombol konfirmasi absen</p>
                                    </div>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-blue-500/20">4</div>
                                    <div class="bg-blue-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Status kehadiran tergantung pada jam anda masuk </p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-blue-50 hover:shadow-xl transition-all duration-300 hover:border-blue-100">
                            <h3 class="text-xl font-semibold text-blue-800 mb-4 flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <i class="bx bx-bulb text-xl text-blue-600"></i>
                                </div>
                                Fitur Absensi
                            </h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3 group">
                                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                        <i class="bx bx-check-circle text-xl"></i>
                                    </div>
                                    <p class="text-gray-700 bg-blue-50 p-3 rounded-lg flex-1">Absensi real-time dengan status: Hadir, Izin, Sakit, dan Tanpa Keterangan</p>
                                </li>
                                
                                <li class="flex items-start gap-3 group">
                                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                        <i class="bx bx-check-circle text-xl"></i>
                                    </div>
                                    <p class="text-gray-700 bg-blue-50 p-3 rounded-lg flex-1">Notifikasi otomatis ke wali murid untuk ketidakhadiran</p>
                                </li>
                                <li class="flex items-start gap-3 group">
                                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                        <i class="bx bx-check-circle text-xl"></i>
                                    </div>
                                    <p class="text-gray-700 bg-blue-50 p-3 rounded-lg flex-1">Export data absensi dalam format Excel dan PDF</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Jurnal Content -->
                <div x-show="activeTab === 'jurnal'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-blue-50 hover:shadow-xl transition-all duration-300 hover:border-blue-100">
                            <h3 class="text-xl font-semibold text-indigo-800 mb-4 flex items-center">
                                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                    <i class="bx bx-list-ol text-xl text-indigo-600"></i>
                                </div>
                                Pengisian Jurnal Mengajar
                            </h3>
                            <ol class="space-y-4">
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-indigo-500/20">1</div>
                                    <div class="bg-indigo-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Akses menu "Jurnal Mengajar" setelah login</p>
                                    </div>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-indigo-500/20">2</div>
                                    <div class="bg-indigo-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Pilih kelas dan mata pelajaran yang diampu</p>
                                    </div>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-indigo-500/20">3</div>
                                    <div class="bg-indigo-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Isi detail pembelajaran termasuk materi, metode, dan evaluasi</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Data Siswa Content -->
                <div x-show="activeTab === 'siswa'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-blue-50 hover:shadow-xl transition-all duration-300 hover:border-blue-100">
                            <h3 class="text-xl font-semibold text-sky-800 mb-4 flex items-center">
                                <div class="bg-sky-100 p-2 rounded-lg mr-3">
                                    <i class="bx bx-list-ol text-xl text-sky-600"></i>
                                </div>
                                Pengelolaan Data Siswa
                            </h3>
                            <ol class="space-y-4">
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-sky-500 to-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-sky-500/20">1</div>
                                    <div class="bg-sky-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Akses menu "Data Siswa" di dashboard</p>
                                    </div>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-sky-500 to-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-sky-500/20">2</div>
                                    <div class="bg-sky-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Pilih kelas atau gunakan fitur pencarian</p>
                                    </div>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <div class="bg-gradient-to-br from-sky-500 to-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-sky-500/20">3</div>
                                    <div class="bg-sky-50 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                        <p class="text-gray-700">Tambah, edit, atau lihat detail data siswa</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-blue-50 hover:shadow-xl transition-all duration-300 hover:border-blue-100">
                            <h3 class="text-xl font-semibold text-sky-800 mb-4 flex items-center">
                                <div class="bg-sky-100 p-2 rounded-lg mr-3">
                                    <i class="bx bx-bulb text-xl text-sky-600"></i>
                                </div>
                                Fitur Data Siswa
                            </h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3 group">
                                    <div class="bg-sky-100 p-2 rounded-lg text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                                        <i class="bx bx-check-circle text-xl"></i>
                                    </div>
                                    <p class="text-gray-700 bg-sky-50 p-3 rounded-lg flex-1">Manajemen data pribadi siswa</p>
                                </li>
                                <li class="flex items-start gap-3 group">
                                    <div class="bg-sky-100 p-2 rounded-lg text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                                        <i class="bx bx-check-circle text-xl"></i>
                                    </div>
                                    <p class="text-gray-700 bg-sky-50 p-3 rounded-lg flex-1">Pengelompokan siswa berdasarkan kelas </p>
                                </li>
                                <li class="flex items-start gap-3 group">
                                    <div class="bg-sky-100 p-2 rounded-lg text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                                        <i class="bx bx-check-circle text-xl"></i>
                                    </div>
                                    <p class="text-gray-700 bg-sky-50 p-3 rounded-lg flex-1">export data siswa dalam format Excel dan PDF</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bantuan & Dukungan with enhanced styling -->
            <div class="mt-16 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8 shadow-lg border border-blue-100">
                <h3 class="text-2xl font-semibold text-blue-800 mb-6 text-center">Butuh Bantuan?</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center group">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                            <i class="bx bx-help-circle text-3xl text-white"></i>
                        </div>
                        <h4 class="font-medium text-blue-800 mb-2">Pusat Bantuan</h4>
                        <p class="text-sm text-gray-600 mb-4">Kunjungi pusat bantuan kami untuk panduan lengkap</p>
                        <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300 text-sm font-medium">
                            <span>Buka Pusat Bantuan</span>
                            <i class="bx bx-right-arrow-alt ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center group">
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                            <i class="bx bx-phone-call text-3xl text-white"></i>
                        </div>
                        <h4 class="font-medium text-indigo-800 mb-2">Kontak Langsung</h4>
                        <p class="text-sm text-gray-600 mb-4">Hubungi tim support kami di jam kerja</p>
                        <a href="#" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-300 text-sm font-medium">
                            <span>Hubungi Kami</span>
                            <i class="bx bx-right-arrow-alt ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center group">
                        <div class="bg-gradient-to-br from-sky-500 to-sky-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-sky-500/20 group-hover:scale-110 transition-transform duration-300">
                            <i class="bx bx-video text-3xl text-white"></i>
                        </div>
                        <h4 class="font-medium text-sky-800 mb-2">Video Tutorial</h4>
                        <p class="text-sm text-gray-600 mb-4">Pelajari sistem melalui video panduan</p>
                        <a href="#" class="inline-flex items-center text-sky-600 hover:text-sky-800 transition-colors duration-300 text-sm font-medium">
                            <span>Lihat Tutorial</span>
                            <i class="bx bx-right-arrow-alt ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ Section with enhanced animations -->
            <div class="mt-16">
                <h3 class="text-2xl font-semibold text-blue-800 mb-6 text-center">Pertanyaan Umum</h3>
                <div class="space-y-4">
                    @php
                    $faqs = [
                        [
                            'question' => 'Bagaimana jika saya lupa password?',
                            'answer' => 'Anda dapat menggunakan fitur "Lupa Password" di halaman login. Sistem akan mengirimkan link reset password ke email terdaftar Anda.'
                        ],
                        [
                            'question' => 'Apakah data absensi bisa diubah setelah disimpan?',
                            'answer' => 'Ya, data absensi dapat diubah oleh guru atau admin dalam waktu 24 jam setelah pengisian. Perubahan setelah 24 jam memerlukan persetujuan admin.'
                        ],
                        [
                            'question' => 'Bagaimana cara mengunduh laporan absensi?',
                            'answer' => 'Akses menu Laporan, pilih periode yang diinginkan, lalu klik tombol "Unduh". Laporan tersedia dalam format Excel dan PDF.'
                        ],
                        [
                            'question' => 'Apakah orang tua bisa memantau absensi siswa?',
                            'answer' => 'Ya, orang tua dapat mengakses informasi absensi melalui email yang dikirimkan oleh sistem.'
                        ]
                    ];
                    @endphp

                    @foreach ($faqs as $index => $faq)
                    <div x-data="{ open: false }" class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-blue-50 overflow-hidden" style="animation-delay: {{ 100 + ($index * 100) }}ms">
                        <button 
                            @click="open = !open"
                            class="w-full px-6 py-4 text-left flex justify-between items-center group"
                        >
                            <span class="font-medium text-blue-800 group-hover:text-blue-600 transition-colors duration-300">{{ $faq['question'] }}</span>
                            <div class="bg-blue-100 p-2 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                <i class="bx" :class="{ 'bx-chevron-up': open, 'bx-chevron-down': !open }"></i>
                            </div>
                        </button>
                        <div 
                            x-show="open" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-4"
                            class="px-6 pb-4 text-gray-600 bg-blue-50/50"
                        >
                            <p class="py-2">{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Links with enhanced styling -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#" class="flex items-center gap-2 px-4 py-3 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-blue-50 group">
                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="bx bx-book-open"></i>
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-blue-600 transition-colors duration-300">Manual Pengguna</span>
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-3 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-blue-50 group">
                    <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <i class="bx bx-video-plus"></i>
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-indigo-600 transition-colors duration-300">Video Tutorial</span>
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-3 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-blue-50 group">
                    <div class="bg-sky-100 p-2 rounded-lg text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                        <i class="bx bx-support"></i>
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-sky-600 transition-colors duration-300">Pusat Bantuan</span>
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-3 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-blue-50 group">
                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="bx bx-message-square-dots"></i>
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-blue-600 transition-colors duration-300">Hubungi Kami</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer with enhanced styling -->
    <footer class="relative z-10 bg-white/80 backdrop-blur-lg border-t border-blue-100 py-8 lg:py-10 mt-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-3 rounded-xl shadow-lg mr-3">
                            <i class="bx bxs-school text-2xl text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-blue-900">Sistem Informasi Akademik</h2>
                            <p class="text-sm text-gray-600">Solusi Digital untuk Pendidikan</p>
                        </div>
                    </div>
                    <p class="text-gray-600 max-w-md">Platform manajemen pendidikan terpadu untuk meningkatkan efisiensi dan efektivitas proses akademik</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-blue-900 mb-3 uppercase">Produk</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 text-sm">Absensi Digital</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 text-sm">Jurnal Mengajar</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 text-sm">Manajemen Siswa</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-blue-900 mb-3 uppercase">Bantuan</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 text-sm">Pusat Bantuan</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 text-sm">Tutorial</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 text-sm">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-blue-900 mb-3 uppercase">Kontak</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-600 text-sm">
                                <i class="bx bx-envelope mr-2 text-blue-600"></i>
                            raifanramadhanputra06@gmail.com
                            </li>
                            <li class="flex items-center text-gray-600 text-sm">
                                <i class="bx bx-phone mr-2 text-blue-600"></i>
                                (021) 1234-5678
                            </li>
                            <li class="flex items-center text-gray-600 text-sm">
                                <i class="bx bx-map mr-2 text-blue-600"></i>
                                Depok, Indonesia
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-blue-100 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm">© {{ date('Y') }} Sistem Informasi Akademik. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                        <i class="bx bxl-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                        <i class="bx bxl-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                        <i class="bx bxl-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                        <i class="bx bxl-youtube text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</div>

<style>
    /* Enhanced animations */
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }
    
    .animate-fade-in {
        opacity: 0;
        animation: fade-in 1s ease-out forwards;
    }
    
    .animate-blob {
        animation: blob 15s infinite alternate;
    }
    
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    /* Feature card styling */
    .feature-card {
        position: relative;
        overflow: hidden;
    }
    
    /* Ensure all elements are visible on page load for animations */
    .opacity-0 {
        opacity: 0;
    }
    
    /* Intersection Observer for scroll animations */
    [data-aos] {
        opacity: 0;
        transition-property: opacity, transform;
        transition-duration: 0.8s;
    }
    
    [data-aos="fade-up"] {
        transform: translateY(20px);
    }
    
    [data-aos].aos-animate {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize animations
        setTimeout(() => {
            document.querySelectorAll('.opacity-0').forEach(el => {
                el.classList.remove('opacity-0');
            });
        }, 100);
        
        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                }
            });
        }, {
            threshold: 0.1
        });
        
        document.querySelectorAll('[data-aos]').forEach(el => {
            observer.observe(el);
        });
        
        // Counter animation for stats
        const counterElements = document.querySelectorAll('.counter-value');
        counterElements.forEach(el => {
            const target = el.textContent;
            if (target.includes('%') || target.includes('+') || target.includes('/')) {
                // Skip special formats
                return;
            }
            
            const start = 0;
            const end = parseInt(target.replace(/,/g, ''));
            const duration = 2000;
            const startTime = performance.now();
            
            function updateCounter(currentTime) {
                const elapsedTime = currentTime - startTime;
                if (elapsedTime < duration) {
                    const value = Math.floor(easeOutQuad(elapsedTime, start, end, duration));
                    el.textContent = value.toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    el.textContent = target;
                }
            }
            
            function easeOutQuad(t, b, c, d) {
                t /= d;
                return -c * t * (t - 2) + b;
            }
            
            requestAnimationFrame(updateCounter);
        });
    });
</script>
@endsection

