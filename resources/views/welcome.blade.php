@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="min-h-screen relative overflow-hidden">
    <!-- Background Design Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Hero Section -->
    <div class="relative z-10 container mx-auto px-4 py-12 lg:py-16">
        <div class="text-center mb-12 lg:mb-16 animate-fade-in">
            <div class="flex justify-center mb-8">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-4 rounded-2xl shadow-2xl transform hover:scale-110 transition-all duration-300">
                    <i class="bx bxs-school text-5xl text-white"></i>
                </div>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-emerald-900 mb-4">
                Sistem Informasi Akademik Terpadu
            </h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Platform digital untuk pengelolaan absensi, jurnal mengajar guru, dan data siswa secara efektif dan terintegrasi
            </p>
        </div>

        <!-- Main Features -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">
            @php
            $features = [
                [
                    'icon' => 'bxs-time-five',
                    'color' => 'emerald',
                    'title' => 'Absensi Digital',
                    'description' => 'Sistem absensi digital yang mudah untuk guru dan siswa dengan laporan kehadiran real-time.'
                ],
                [
                    'icon' => 'bxs-book-content',
                    'color' => 'teal',
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
                    'color' => 'emerald',
                    'title' => 'Laporan & Analisis',
                    'description' => 'Generate laporan detail tentang kehadiran, aktivitas pembelajaran, dan perkembangan siswa.'
                ],
                [
                    'icon' => 'bxs-notification',
                    'color' => 'teal',
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

            @foreach ($features as $feature)
            <div class="group bg-white/50 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="bg-gradient-to-r from-{{ $feature['color'] }}-500 to-{{ $feature['color'] }}-600 w-14 h-14 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="bx {{ $feature['icon'] }} text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-emerald-900 mb-2">{{ $feature['title'] }}</h3>
                <p class="text-gray-600">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Quick Stats -->
        <div class="bg-white/50 backdrop-blur-lg rounded-2xl p-6 lg:p-8 shadow-lg mb-12">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @php
                $stats = [
                    ['number' => '99.8%', 'label' => 'Akurasi Absensi', 'icon' => 'bxs-check-circle', 'color' => 'emerald'],
                    ['number' => '1000+', 'label' => 'Jurnal Per Bulan', 'icon' => 'bxs-book-open', 'color' => 'teal'],
                    ['number' => '50+', 'label' => 'Kelas Aktif', 'icon' => 'bxs-group', 'color' => 'sky'],
                    ['number' => '24/7', 'label' => 'Dukungan Sistem', 'icon' => 'bxs-help-circle', 'color' => 'emerald']
                ];
                @endphp

                @foreach ($stats as $stat)
                <div class="text-center group">
                    <div class="inline-block bg-{{ $stat['color'] }}-100 p-4 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="bx {{ $stat['icon'] }} text-3xl text-{{ $stat['color'] }}-600"></i>
                    </div>
                    <h4 class="text-2xl lg:text-3xl font-bold text-{{ $stat['color'] }}-600 mb-2">{{ $stat['number'] }}</h4>
                    <p class="text-gray-600">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Login CTA -->
        <div class="text-center">
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 lg:p-8 shadow-lg transform hover:scale-105 transition-all duration-300">
                <h2 class="text-2xl lg:text-3xl font-bold text-white mb-4">Mulai Sekarang</h2>
                <p class="text-emerald-100 mb-6">Bergabung dengan platform kami untuk pengalaman manajemen pendidikan yang lebih baik</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('login') }}" class="bg-white text-emerald-600 px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        Masuk ke Sistem
                    </a>
                    <a href="#panduan" class="bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        Lihat Panduan
                    </a>
                </div>
            </div>
        </div>
    </div>
 <!-- Panduan Section -->
 <div id="panduan" class="relative z-10 container mx-auto px-4 py-12 mt-8">
        <div class="bg-white/50 backdrop-blur-lg rounded-2xl p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-emerald-900 mb-8 text-center">Panduan Penggunaan Sistem</h2>
            
            <!-- Panduan Tabs -->
            <div x-data="{ activeTab: 'absensi' }" class="mb-8">
                <div class="flex flex-wrap justify-center gap-4 mb-8">
                    <button 
                        @click="activeTab = 'absensi'" 
                        :class="{ 'bg-emerald-600 text-white': activeTab === 'absensi', 'bg-gray-100 text-gray-600 hover:bg-gray-200': activeTab !== 'absensi' }"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-300">
                        Absensi Digital
                    </button>
                    <button 
                        @click="activeTab = 'jurnal'" 
                        :class="{ 'bg-emerald-600 text-white': activeTab === 'jurnal', 'bg-gray-100 text-gray-600 hover:bg-gray-200': activeTab !== 'jurnal' }"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-300">
                        Jurnal Mengajar
                    </button>
                    <button 
                        @click="activeTab = 'siswa'" 
                        :class="{ 'bg-emerald-600 text-white': activeTab === 'siswa', 'bg-gray-100 text-gray-600 hover:bg-gray-200': activeTab !== 'siswa' }"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-300">
                        Data Siswa
                    </button>
                </div>

                <!-- Absensi Content -->
                <div x-show="activeTab === 'absensi'" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white rounded-xl p-6 shadow-md">
                            <h3 class="text-xl font-semibold text-emerald-800 mb-4">Cara Mengisi Absensi</h3>
                            <ol class="space-y-4">
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">1</div>
                                    <div>
                                        <p class="text-gray-600">Login ke sistem menggunakan akun Anda</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">2</div>
                                    <div>
                                        <p class="text-gray-600">Pilih menu "Absensi Digital" pada dashboard</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">3</div>
                                    <div>
                                        <p class="text-gray-600">Pilih kelas dan tanggal yang sesuai</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">4</div>
                                    <div>
                                        <p class="text-gray-600">Isi status kehadiran untuk setiap siswa</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-md">
                            <h3 class="text-xl font-semibold text-emerald-800 mb-4">Fitur Absensi</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Absensi real-time dengan status: Hadir, Izin, Sakit, dan Tanpa Keterangan</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Rekap absensi otomatis harian, mingguan, dan bulanan</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Notifikasi otomatis ke wali murid untuk ketidakhadiran</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Export data absensi dalam format Excel dan PDF</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Jurnal Content -->
                <div x-show="activeTab === 'jurnal'" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white rounded-xl p-6 shadow-md">
                            <h3 class="text-xl font-semibold text-emerald-800 mb-4">Pengisian Jurnal Mengajar</h3>
                            <ol class="space-y-4">
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">1</div>
                                    <div>
                                        <p class="text-gray-600">Akses menu "Jurnal Mengajar" setelah login</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">2</div>
                                    <div>
                                        <p class="text-gray-600">Pilih kelas dan mata pelajaran yang diampu</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">3</div>
                                    <div>
                                        <p class="text-gray-600">Isi detail pembelajaran termasuk materi, metode, dan evaluasi</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">4</div>
                                    <div>
                                        <p class="text-gray-600">Unggah lampiran pendukung jika ada</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-md">
                            <h3 class="text-xl font-semibold text-emerald-800 mb-4">Fitur Jurnal</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Template jurnal yang dapat disesuaikan dengan kebutuhan</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Penyimpanan file lampiran (RPP, materi, dll)</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Analisis pencapaian pembelajaran otomatis</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Rekap jurnal untuk keperluan supervisi</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Data Siswa Content -->
                <div x-show="activeTab === 'siswa'" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white rounded-xl p-6 shadow-md">
                            <h3 class="text-xl font-semibold text-emerald-800 mb-4">Pengelolaan Data Siswa</h3>
                            <ol class="space-y-4">
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">1</div>
                                    <div>
                                        <p class="text-gray-600">Akses menu "Data Siswa" di dashboard</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">2</div>
                                    <div>
                                        <p class="text-gray-600">Pilih kelas atau gunakan fitur pencarian</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">3</div>
                                    <div>
                                        <p class="text-gray-600">Tambah, edit, atau lihat detail data siswa</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0">4</div>
                                    <div>
                                        <p class="text-gray-600">Kelola riwayat akademik dan dokumen siswa</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-md">
                            <h3 class="text-xl font-semibold text-emerald-800 mb-4">Fitur Data Siswa</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Manajemen data pribadi dan akademik siswa</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Pengelompokan siswa berdasarkan kelas dan tahun ajaran</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Riwayat prestasi dan kegiatan ekstrakurikuler</p>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bx-check-circle text-emerald-600 text-xl mt-1"></i>
                                    <p class="text-gray-600">Sistem pengarsipan dokumen digital</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bantuan & Dukungan -->
            <div class="mt-12 bg-emerald-50 rounded-xl p-6">
                <h3 class="text-xl font-semibold text-emerald-800 mb-4 text-center">Butuh Bantuan?</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                            <i class="bx bx-help-circle text-3xl text-emerald-600"></i>
                        </div>
                        <h4 class="font-medium text-emerald-800 mb-2">Pusat Bantuan</h4>
                        <p class="text-sm text-gray-600">Kunjungi pusat bantuan kami untuk panduan lengkap</p>
                    </div>
                    <div class="text-center">
                    <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                            <i class="bx bx-phone-call text-3xl text-emerald-600"></i>
                        </div>
                        <h4 class="font-medium text-emerald-800 mb-2">Kontak Langsung</h4>
                        <p class="text-sm text-gray-600">Hubungi tim support kami di jam kerja</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                            <i class="bx bx-video text-3xl text-emerald-600"></i>
                        </div>
                        <h4 class="font-medium text-emerald-800 mb-2">Video Tutorial</h4>
                        <p class="text-sm text-gray-600">Pelajari sistem melalui video panduan</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-12">
                <h3 class="text-xl font-semibold text-emerald-800 mb-6 text-center">Pertanyaan Umum</h3>
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
                            'answer' => 'Ya, orang tua dapat mengakses informasi absensi melalui portal orang tua dengan menggunakan akun yang telah diberikan oleh sekolah.'
                        ]
                    ];
                    @endphp

                    @foreach ($faqs as $faq)
                    <div x-data="{ open: false }" class="bg-white rounded-xl shadow-md">
                        <button 
                            @click="open = !open"
                            class="w-full px-6 py-4 text-left flex justify-between items-center"
                        >
                            <span class="font-medium text-emerald-800">{{ $faq['question'] }}</span>
                            <i class="bx" :class="{ 'bx-chevron-up': open, 'bx-chevron-down': !open }"></i>
                        </button>
                        <div 
                            x-show="open" 
                            x-transition
                            class="px-6 pb-4 text-gray-600"
                        >
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Links -->
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#" class="flex items-center gap-2 px-4 py-3 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="bx bx-book-open text-emerald-600"></i>
                    <span class="text-sm text-gray-600">Manual Pengguna</span>
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-3 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="bx bx-video-plus text-emerald-600"></i>
                    <span class="text-sm text-gray-600">Video Tutorial</span>
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-3 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="bx bx-support text-emerald-600"></i>
                    <span class="text-sm text-gray-600">Pusat Bantuan</span>
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-3 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="bx bx-message-square-dots text-emerald-600"></i>
                    <span class="text-sm text-gray-600">Hubungi Kami</span>
                </a>
            </div>
        </div>
    </div>


<!-- Styles remain the same -->
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
</style>

    <!-- Footer -->
    <footer class="relative z-10 bg-white/50 backdrop-blur-lg border-t border-gray-200 py-6 lg:py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-600">© {{ date('Y') }} Sistem Informasi Akademik. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
</style>
@endsection