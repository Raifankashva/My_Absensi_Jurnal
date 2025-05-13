<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#EFF6FF',
                            100: '#DBEAFE',
                            200: '#BFDBFE',
                            300: '#93C5FD',
                            400: '#60A5FA',
                            500: '#3B82F6',
                            600: '#2563EB',
                            700: '#1D4ED8',
                            800: '#1E40AF',
                            900: '#1E3A8A',
                            950: '#172554',
                        },
                        secondary: {
                            50: '#F8FAFC',
                            100: '#F1F5F9',
                            200: '#E2E8F0',
                            300: '#CBD5E1',
                            400: '#94A3B8',
                            500: '#64748B',
                            600: '#475569',
                            700: '#334155',
                            800: '#1E293B',
                            900: '#0F172A',
                            950: '#020617',
                        },
                        accent: {
                            50: '#ECFDF5',
                            100: '#D1FAE5',
                            200: '#A7F3D0',
                            300: '#6EE7B7',
                            400: '#34D399',
                            500: '#10B981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065F46',
                            900: '#064E3B',
                            950: '#022C22',
                        },
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'shimmer': 'shimmer 2s linear infinite',
                        'slide-in': 'slideIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
                        'bounce-in': 'bounceIn 0.5s ease-out',
                        'spin-slow': 'spin 3s linear infinite',
                        'blob': 'blob 15s infinite alternate',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-1000px 0' },
                            '100%': { backgroundPosition: '1000px 0' },
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.9)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.3)', opacity: '0' },
                            '50%': { transform: 'scale(1.05)', opacity: '0.9' },
                            '70%': { transform: 'scale(0.9)', opacity: '1' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        fadeIn: {
                            'from': { opacity: '0', transform: 'translateY(20px)' },
                            'to': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideIn: {
                            'from': { transform: 'translateX(-100%)' },
                            'to': { transform: 'translateX(0)' },
                        },
                        slideUp: {
                            'from': { transform: 'translateY(20px)', opacity: '0' },
                            'to': { transform: 'translateY(0)', opacity: '1' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                    },
                    boxShadow: {
                        'glow': '0 0 15px rgba(59, 130, 246, 0.5)',
                        'glow-lg': '0 0 25px rgba(59, 130, 246, 0.5)',
                        'inner-glow': 'inset 0 0 15px rgba(59, 130, 246, 0.3)',
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                    },
                },
            },
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Animations */
        @keyframes dotAnimation {
            0% {
                opacity: 0.2;
            }
            20% {
                opacity: 1;
            }
            60% {
                opacity: 0.2;
            }
            100% {
                opacity: 0.2;
            }
        }

        .loading-dots {
            display: inline-block;
            animation: dotAnimation 1.5s infinite;
        }

        .loader-fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .gradient-text {
            background: linear-gradient(90deg, #2563EB, #3B82F6, #60A5FA);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .animated-bg {
            background: linear-gradient(-45deg, #EFF6FF, #DBEAFE, #BFDBFE, #93C5FD);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .dark .animated-bg {
            background: linear-gradient(-45deg, #0F172A, #1E293B, #334155, #475569);
            background-size: 400% 400%;
        }

        /* Styling for navbar */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .navbar-glass.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .dark .navbar-glass {
            background: rgba(15, 23, 42, 0.7);
        }

        .dark .navbar-glass.scrolled {
            background: rgba(15, 23, 42, 0.95);
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(219, 234, 254, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(37, 99, 235, 0.7);
        }

        /* Add a delay to elements to create a cascade effect */
        .animate-delay-100 {
            animation-delay: 100ms;
        }

        .animate-delay-200 {
            animation-delay: 200ms;
        }

        .animate-delay-300 {
            animation-delay: 300ms;
        }

        .animate-delay-400 {
            animation-delay: 400ms;
        }

        .animate-delay-500 {
            animation-delay: 500ms;
        }
    </style>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
</head>

<body class="font-sans animated-bg min-h-screen" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true',
    navbarScrolled: false,
    mobileMenuOpen: false,
    activeTab: 'absensi',
    faqOpen: {}
}" x-init="
    window.addEventListener('scroll', () => {
        navbarScrolled = window.scrollY > 20;
    });
    
    if (darkMode) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
">
    <!-- Page Loader with Enhanced Animation -->
    <div id="page-loader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center animated-bg transition-opacity duration-500">
        <div class="relative w-28 h-28 mb-6">
            <div class="absolute inset-0 rounded-full border-4 border-t-primary-600 border-r-primary-500 border-b-primary-400 border-l-primary-500 animate-spin"></div>
            <div class="absolute inset-[8px] rounded-full bg-primary-600/20 animate-pulse flex items-center justify-center">
                <i class='bx bxs-school text-4xl text-primary-600 animate-bounce-in'></i>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-2xl font-bold gradient-text mb-3 relative overflow-hidden animate-pulse-slow">
                Welcome to School Management System
                <span class="loading-dots">...</span>
            </h2>
            <p class="text-sm text-primary-700/70 dark:text-primary-300/70 animate-fade-in">Please wait while we prepare the system</p>
        </div>
    </div>

    <!-- Transparent Navbar -->
    <header :class="{'scrolled': navbarScrolled}" class="navbar-glass fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl shadow-lg transform transition-transform duration-300 hover:scale-105">
                        <i class='bx bxs-school text-xl text-white'></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-primary-800 dark:text-white">Absensi Jurnal</h1>
                        <p class="text-xs text-primary-600 dark:text-primary-300">Management System</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-primary-600 dark:text-white hover:text-primary-500 dark:hover:text-primary-400 font-medium transition-colors">Features</a>
                    <a href="#panduan" class="text-primary-600 dark:text-white hover:text-primary-500 dark:hover:text-primary-400 font-medium transition-colors">Guide</a>
                    <a href="#faq" class="text-primary-600 dark:text-white hover:text-primary-500 dark:hover:text-primary-400 font-medium transition-colors">FAQ</a>
                    <a href="#contact" class="text-primary-600 dark:text-white hover:text-primary-500 dark:hover:text-primary-400 font-medium transition-colors">Contact</a>
                </nav>

                <!-- Right Side Buttons -->
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button 
                        @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); darkMode ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')" 
                        class="p-2 rounded-full hover:bg-primary-100 dark:hover:bg-primary-800/50 transition-colors focus:outline-none"
                        aria-label="Toggle Dark Mode">
                        <i class='bx text-xl' :class="darkMode ? 'bx-sun text-yellow-400' : 'bx-moon text-primary-600'"></i>
                    </button>

                    <!-- CTA Buttons -->
                    <a href="{{ route('login') }}" class="hidden md:flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 font-medium">
                        <i class='bx bx-log-in-circle mr-2'></i> Login
                    </a>
                    <a href="{{ route('school.register.form') }}" class="hidden md:flex items-center px-4 py-2 border border-primary-600 text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 rounded-lg transition-all duration-300 font-medium">
                        <i class='bx bx-user-plus mr-2'></i> Register
                    </a>

                    <!-- Mobile Menu Button -->
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden p-2 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-800/50 transition-colors focus:outline-none"
                        aria-label="Toggle Mobile Menu">
                        <i class='bx text-2xl text-primary-700 dark:text-white' :class="mobileMenuOpen ? 'bx-x' : 'bx-menu'"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="md:hidden mt-4 py-4 bg-white dark:bg-secondary-800 rounded-xl shadow-lg border border-primary-100 dark:border-secondary-700">
                <nav class="flex flex-col space-y-3 px-4">
                    <a href="#features" @click="mobileMenuOpen = false" class="py-2 px-4 hover:bg-primary-50 dark:hover:bg-secondary-700 rounded-lg text-primary-700 dark:text-white font-medium transition-colors">Features</a>
                    <a href="#panduan" @click="mobileMenuOpen = false" class="py-2 px-4 hover:bg-primary-50 dark:hover:bg-secondary-700 rounded-lg text-primary-700 dark:text-white font-medium transition-colors">Guide</a>
                    <a href="#faq" @click="mobileMenuOpen = false" class="py-2 px-4 hover:bg-primary-50 dark:hover:bg-secondary-700 rounded-lg text-primary-700 dark:text-white font-medium transition-colors">FAQ</a>
                    <a href="#contact" @click="mobileMenuOpen = false" class="py-2 px-4 hover:bg-primary-50 dark:hover:bg-secondary-700 rounded-lg text-primary-700 dark:text-white font-medium transition-colors">Contact</a>
                    <div class="pt-2 border-t border-primary-100 dark:border-secondary-700 flex flex-col space-y-3">
                        <a href="{{ route('login') }}" class="py-2 px-4 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow-md transition-all duration-300 font-medium text-center">
                            <i class='bx bx-log-in-circle mr-2'></i> Login
                        </a>
                        <a href="{{ route('school.register.form') }}" class="py-2 px-4 border border-primary-600 text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 rounded-lg transition-all duration-300 font-medium text-center">
                            <i class='bx bx-user-plus mr-2'></i> Register
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-16">
        <!-- Hero Section with animated background -->
        <section class="relative min-h-screen flex items-center overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 z-0 overflow-hidden">
                <!-- Gradient blobs -->
                <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-br from-blue-600/20 via-blue-500/20 to-indigo-600/20 rounded-full blur-3xl animate-blob"></div>
                <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-gradient-to-tr from-sky-500/20 via-blue-400/20 to-indigo-500/20 rounded-full blur-3xl animate-blob animate-delay-300"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-gradient-to-r from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl animate-blob animate-delay-500"></div>
                
                <!-- Decorative elements -->
                <div class="absolute top-20 left-[20%] w-8 h-8 bg-blue-500/30 rounded-full blur-sm animate-pulse"></div>
                <div class="absolute top-[40%] right-[15%] w-6 h-6 bg-indigo-500/30 rounded-full blur-sm animate-pulse animate-delay-200"></div>
                <div class="absolute bottom-[30%] left-[10%] w-10 h-10 bg-sky-500/30 rounded-full blur-sm animate-pulse animate-delay-400"></div>
                
                <!-- Grid pattern overlay -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMwLTkuOTQtOC4wNi0xOC0xOC0xOFYyYzcuNzMyIDAgMTQgNi4yNjggMTQgMTRoMnptLTIgMGMwIDcuNzMyLTYuMjY4IDE0LTE0IDE0djJjOS45NCAwIDE4LTguMDYgMTgtMThoLTJ6IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9Ii4wNSIvPjxwYXRoIGQ9Ik0yMCA0NGMwIDkuOTQgOC4wNiAxOCAxOCAxOHYtMmMtNy43MzIgMC0xNC02LjI2OC0xNC0xNGgtMnptMiAwYzAtNy43MzIgNi4yNjgtMTQgMTQtMTR2LTJjLTkuOTQgMC0xOCA4LjA2LTE4IDE4aDJ6IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9Ii4wNSIvPjwvZz48L3N2Zz4=')] opacity-30"></div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 container mx-auto px-4 py-16 md:py-24">
                <div class="text-center max-w-4xl mx-auto">
                    <div class="flex justify-center mb-8 opacity-0 animate-fade-in">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-5 rounded-2xl shadow-[0_0_30px_rgba(37,99,235,0.5)] transform hover:scale-110 transition-all duration-500 hover:shadow-[0_0_50px_rgba(37,99,235,0.7)]">
                            <i class="bx bxs-school text-5xl text-white"></i>
                        </div>
                    </div>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-4 opacity-0 animate-fade-in animate-delay-100">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700">My Absensi Jurnal</span>
                    </h1>
                    <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 bg-clip-text text-transparent mb-6 leading-tight opacity-0 animate-fade-in animate-delay-200">
                    Sistem Informasi Akademik Terpadu
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8 opacity-0 animate-fade-in animate-delay-300">
                    Platform digital untuk pengelolaan absensi, jurnal mengajar guru, dan data siswa secara efektif dan terintegrasi
                    </p>
                    
                    <!-- Hero CTA Buttons -->
                    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8 opacity-0 animate-fade-in animate-delay-400">
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center group">
                            <span>Log In</span>
                            <i class="bx bx-right-arrow-alt ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                        <a href="#panduan" class="px-8 py-4 bg-white dark:bg-secondary-800 text-blue-700 dark:text-blue-400 font-semibold rounded-xl shadow-lg hover:shadow-blue-500/20 transform hover:-translate-y-1 transition-all duration-300 border border-blue-100 dark:border-secondary-700 flex items-center justify-center">
                            <i class="bx bx-book-open mr-2"></i>
                            <span>Lihat Panduan</span>
                        </a>
                        <a href="{{ route('school.register.form')}}" class="px-8 py-4 bg-white dark:bg-secondary-800 text-blue-700 dark:text-blue-400 font-semibold rounded-xl shadow-lg hover:shadow-blue-500/20 transform hover:-translate-y-1 transition-all duration-300 border border-blue-100 dark:border-secondary-700 flex items-center justify-center">
                            <i class="bx bxs-school mr-2"></i>
                            <span>Daftar Sekolah</span>
                        </a>
                    </div>

                    <!-- Floating arrow down -->
                    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce opacity-0 animate-fade-in animate-delay-500">
                        <a href="#features" class="bg-white dark:bg-secondary-800 rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-300 block">
                            <i class="bx bx-chevron-down text-2xl text-primary-600 dark:text-primary-400"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 md:py-24 relative">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700">Key Features</h2>
                    
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
                    <div class="bg-white dark:bg-secondary-800/80 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:shadow-2xl transform transition-all duration-500 hover:-translate-y-2 border border-blue-50 dark:border-secondary-700 opacity-0 animate-fade-in" style="animation-delay: {{ 100 + ($index * 100) }}ms">
                        <div class="bg-gradient-to-br from-{{ $feature['color'] }}-500 to-{{ $feature['color'] }}-700 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500 shadow-lg shadow-{{ $feature['color'] }}-500/20">
                            <i class="bx {{ $feature['icon'] }} text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-blue-900 dark:text-blue-100 mb-3 group-hover:text-blue-700 transition-colors duration-300">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $feature['description'] }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Stats Counter Section -->
                <div class="mt-20 bg-white dark:bg-secondary-800/80 backdrop-blur-lg rounded-2xl p-8 lg:p-10 shadow-xl border border-blue-50 dark:border-secondary-700">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                        @php
                        $stats = [
                            ['number' => '99.8%', 'label' => 'Attendance Accuracy', 'icon' => 'bxs-check-circle', 'color' => 'blue'],
                            ['number' => '1000+', 'label' => 'Monthly Journals', 'icon' => 'bxs-book-open', 'color' => 'indigo'],
                            ['number' => '50+', 'label' => 'Active Classes', 'icon' => 'bxs-group', 'color' => 'sky'],
                            ['number' => '24/7', 'label' => 'System Support', 'icon' => 'bxs-help-circle', 'color' => 'blue']
                        ];
                        @endphp

                        @foreach ($stats as $index => $stat)
                        <div class="text-center group">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-{{ $stat['color'] }}-100 to-{{ $stat['color'] }}-200 dark:from-{{ $stat['color'] }}-900 dark:to-{{ $stat['color'] }}-800 p-4 rounded-full mb-4 group-hover:scale-110 transition-transform duration-500 shadow-inner">
                                <i class="bx {{ $stat['icon'] }} text-3xl text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400"></i>
                            </div>
                            <h4 class="text-2xl lg:text-3xl font-bold text-{{ $stat['color'] }}-700 dark:text-{{ $stat['color'] }}-400 mb-2 counter-value">{{ $stat['number'] }}</h4>
                            <p class="text-gray-600 dark:text-gray-300">{{ $stat['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Guide Section -->
        <section id="panduan" class="py-16 md:py-24 relative">
            <div class="container mx-auto px-4">
                <div class="bg-white dark:bg-secondary-800/80 backdrop-blur-lg rounded-2xl p-8 lg:p-10 shadow-xl border border-blue-50 dark:border-secondary-700">
                    <div class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg mb-4">
                            <i class="bx bx-book-open text-2xl text-white"></i>
                        </div>
                        <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 bg-clip-text text-transparent mb-4">System Usage Guide</h2>
                        <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Learn how to use the key features of the system to maximize your user experience</p>
                    </div>
                    
                    <!-- Tabs for different guides -->
                    <div class="mb-10">
                        <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-8 bg-blue-50/50 dark:bg-secondary-700/50 p-2 rounded-xl">
                            <button 
                                @click="activeTab = 'absensi'" 
                                :class="{ 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg': activeTab === 'absensi', 'bg-white dark:bg-secondary-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-secondary-700': activeTab !== 'absensi' }"
                                class="px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center">
                                <i class="bx bxs-time-five mr-2" :class="{ 'text-white': activeTab === 'absensi', 'text-blue-600 dark:text-blue-400': activeTab !== 'absensi' }"></i>
                                Digital Attendance
                            </button>
                            <button 
                                @click="activeTab = 'jurnal'" 
                                :class="{ 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg': activeTab === 'jurnal', 'bg-white dark:bg-secondary-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-secondary-700': activeTab !== 'jurnal' }"
                                class="px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center">
                                <i class="bx bxs-book-content mr-2" :class="{ 'text-white': activeTab === 'jurnal', 'text-blue-600 dark:text-blue-400': activeTab !== 'jurnal' }"></i>
                                Teaching Journal
                            </button>
                            <button 
                                @click="activeTab = 'siswa'" 
                                :class="{ 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg': activeTab === 'siswa', 'bg-white dark:bg-secondary-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-secondary-700': activeTab !== 'siswa' }"
                                class="px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center">
                                <i class="bx bxs-user-detail mr-2" :class="{ 'text-white': activeTab === 'siswa', 'text-blue-600 dark:text-blue-400': activeTab !== 'siswa' }"></i>
                                Student Data
                            </button>
                        </div>

                        <!-- Attendance Content -->
                        <div x-show="activeTab === 'absensi'" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-lg border border-blue-50 dark:border-secondary-700 hover:shadow-xl transition-all duration-300 hover:border-blue-100 dark:hover:border-secondary-600">
                                    <h3 class="text-xl font-semibold text-blue-800 dark:text-blue-300 mb-4 flex items-center">
                                        <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg mr-3">
                                            <i class="bx bx-list-ol text-xl text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        How to Fill Attendance
                                    </h3>
                                    <ol class="space-y-4">
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-blue-500/20">1</div>
                                            <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Log in to the system using your account</p>
                                            </div>
                                        </li>
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-blue-500/20">2</div>
                                            <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Use the QR Code on the dashboard to fill attendance</p>
                                            </div>
                                        </li>
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-blue-500/20">3</div>
                                            <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">When your name, NISN, and class appear, press the attendance confirmation button</p>
                                            </div>
                                        </li>
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-blue-500/20">4</div>
                                            <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Your attendance status depends on your entry time</p>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                                <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-lg border border-blue-50 dark:border-secondary-700 hover:shadow-xl transition-all duration-300 hover:border-blue-100 dark:hover:border-secondary-600">
                                    <h3 class="text-xl font-semibold text-blue-800 dark:text-blue-300 mb-4 flex items-center">
                                        <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg mr-3">
                                            <i class="bx bx-bulb text-xl text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        Attendance Features
                                    </h3>
                                    <ul class="space-y-4">
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg flex-1">Real-time attendance with statuses: Present, Permitted, Sick, and Absent</p>
                                        </li>
                                        
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg flex-1">Automatic notifications to parents for absences</p>
                                        </li>
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg flex-1">Export attendance data in Excel and PDF formats</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Journal Content -->
                        <div x-show="activeTab === 'jurnal'" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-lg border border-blue-50 dark:border-secondary-700 hover:shadow-xl transition-all duration-300 hover:border-blue-100 dark:hover:border-secondary-600">
                                    <h3 class="text-xl font-semibold text-indigo-800 dark:text-indigo-300 mb-4 flex items-center">
                                        <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-lg mr-3">
                                            <i class="bx bx-list-ol text-xl text-indigo-600 dark:text-indigo-400"></i>
                                        </div>
                                        Filling Teaching Journal
                                    </h3>
                                    <ol class="space-y-4">
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-indigo-500/20">1</div>
                                            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Access the "Teaching Journal" menu after logging in</p>
                                            </div>
                                        </li>
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-indigo-500/20">2</div>
                                            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Select the class and subject you're teaching</p>
                                            </div>
                                        </li>
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-indigo-500/20">3</div>
                                            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Fill in learning details including materials, methods, and evaluation</p>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                                <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-lg border border-blue-50 dark:border-secondary-700 hover:shadow-xl transition-all duration-300 hover:border-blue-100 dark:hover:border-secondary-600">
                                    <h3 class="text-xl font-semibold text-indigo-800 dark:text-indigo-300 mb-4 flex items-center">
                                        <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-lg mr-3">
                                            <i class="bx bx-bulb text-xl text-indigo-600 dark:text-indigo-400"></i>
                                        </div>
                                        Journal Features
                                    </h3>
                                    <ul class="space-y-4">
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-lg text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-indigo-50 dark:bg-indigo-900/30 p-3 rounded-lg flex-1">Structured documentation of teaching activities</p>
                                        </li>
                                        
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-lg text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-indigo-50 dark:bg-indigo-900/30 p-3 rounded-lg flex-1">Attachment support for learning materials</p>
                                        </li>
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-lg text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-indigo-50 dark:bg-indigo-900/30 p-3 rounded-lg flex-1">Comprehensive reporting and analytic tools</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Student Data Content -->
                        <div x-show="activeTab === 'siswa'" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-lg border border-blue-50 dark:border-secondary-700 hover:shadow-xl transition-all duration-300 hover:border-blue-100 dark:hover:border-secondary-600">
                                    <h3 class="text-xl font-semibold text-sky-800 dark:text-sky-300 mb-4 flex items-center">
                                        <div class="bg-sky-100 dark:bg-sky-900 p-2 rounded-lg mr-3">
                                            <i class="bx bx-list-ol text-xl text-sky-600 dark:text-sky-400"></i>
                                        </div>
                                        Student Data Management
                                    </h3>
                                    <ol class="space-y-4">
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-sky-500 to-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-sky-500/20">1</div>
                                            <div class="bg-sky-50 dark:bg-sky-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Access the "Student Data" menu in the dashboard</p>
                                            </div>
                                        </li>
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-sky-500 to-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-sky-500/20">2</div>
                                            <div class="bg-sky-50 dark:bg-sky-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Select a class or use the search feature</p>
                                            </div>
                                        </li>
                                        <li class="flex gap-3 items-start">
                                            <div class="bg-gradient-to-br from-sky-500 to-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shrink-0 shadow-md shadow-sky-500/20">3</div>
                                            <div class="bg-sky-50 dark:bg-sky-900/30 p-3 rounded-lg flex-1 transform transition-all duration-300 hover:translate-x-1 hover:shadow-md">
                                                <p class="text-gray-700 dark:text-gray-300">Add, edit, or view student data details</p>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                                <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-lg border border-blue-50 dark:border-secondary-700 hover:shadow-xl transition-all duration-300 hover:border-blue-100 dark:hover:border-secondary-600">
                                    <h3 class="text-xl font-semibold text-sky-800 dark:text-sky-300 mb-4 flex items-center">
                                        <div class="bg-sky-100 dark:bg-sky-900 p-2 rounded-lg mr-3">
                                            <i class="bx bx-bulb text-xl text-sky-600 dark:text-sky-400"></i>
                                        </div>
                                        Student Data Features
                                    </h3>
                                    <ul class="space-y-4">
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-sky-100 dark:bg-sky-900 p-2 rounded-lg text-sky-600 dark:text-sky-400 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-sky-50 dark:bg-sky-900/30 p-3 rounded-lg flex-1">Student personal data management</p>
                                        </li>
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-sky-100 dark:bg-sky-900 p-2 rounded-lg text-sky-600 dark:text-sky-400 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-sky-50 dark:bg-sky-900/30 p-3 rounded-lg flex-1">Student grouping by class</p>
                                        </li>
                                        <li class="flex items-start gap-3 group">
                                            <div class="bg-sky-100 dark:bg-sky-900 p-2 rounded-lg text-sky-600 dark:text-sky-400 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                                                <i class="bx bx-check-circle text-xl"></i>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 bg-sky-50 dark:bg-sky-900/30 p-3 rounded-lg flex-1">Export student data in Excel and PDF formats</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Support Section -->
                    <div class="mt-16 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-xl p-8 shadow-lg border border-blue-100 dark:border-blue-800/30">
                        <h3 class="text-2xl font-semibold text-blue-800 dark:text-blue-300 mb-6 text-center">Need Help?</h3>
                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center group">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                                    <i class="bx bx-help-circle text-3xl text-white"></i>
                                </div>
                                <h4 class="font-medium text-blue-800 dark:text-blue-300 mb-2">Help Center</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Visit our help center for comprehensive guides</p>
                                <a href="#" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-300 text-sm font-medium">
                                    <span>Open Help Center</span>
                                    <i class="bx bx-right-arrow-alt ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                </a>
                            </div>
                            <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center group">
                                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                                    <i class="bx bx-phone-call text-3xl text-white"></i>
                                </div>
                                <h4 class="font-medium text-indigo-800 dark:text-indigo-300 mb-2">Direct Contact</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Contact our support team during business hours</p>
                                <a href="#" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors duration-300 text-sm font-medium">
                                    <span>Contact Us</span>
                                    <i class="bx bx-right-arrow-alt ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                </a>
                            </div>
                            <div class="bg-white dark:bg-secondary-800 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center group">
                                <div class="bg-gradient-to-br from-sky-500 to-sky-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-sky-500/20 group-hover:scale-110 transition-transform duration-300">
                                    <i class="bx bx-video text-3xl text-white"></i>
                                </div>
                                <h4 class="font-medium text-sky-800 dark:text-sky-300 mb-2">Video Tutorials</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Learn the system through video guides</p>
                                <a href="#" class="inline-flex items-center text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-300 transition-colors duration-300 text-sm font-medium">
                                    <span>View Tutorials</span>
                                    <i class="bx bx-right-arrow-alt ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="py-16 md:py-24 relative">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-3xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700">Frequently Asked Questions</h2>
                    <p class="text-gray-600 dark:text-gray-300">Find answers to common questions about our system</p>
                </div>

                <div class="max-w-3xl mx-auto space-y-4">
                    @php
                    $faqs = [
                        [
                            'question' => 'What should I do if I forget my password?',
                            'answer' => 'You can use the "Forgot Password" feature on the login page. The system will send a password reset link to your registered email.'
                        ],
                        [
                            'question' => 'Can attendance data be modified after being saved?',
                            'answer' => 'Yes, attendance data can be modified by teachers or administrators within 24 hours after entry. Changes after 24 hours require administrator approval.'
                        ],
                        [
                            'question' => 'How do I download attendance reports?',
                            'answer' => 'Access the Reports menu, select the desired period, then click the "Download" button. Reports are available in Excel and PDF formats.'
                        ],
                        [
                            'question' => 'Can parents monitor student attendance?',
                            'answer' => 'Yes, parents can access attendance information through emails sent by the system.'
                        ]
                    ];
                    @endphp

                    @foreach ($faqs as $index => $faq)
                    <div x-data="{ open: false }" class="bg-white dark:bg-secondary-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-blue-50 dark:border-secondary-700 overflow-hidden">
                        <button 
                            @click="open = !open"
                            class="w-full px-6 py-4 text-left flex justify-between items-center group"
                        >
                            <span class="font-medium text-blue-800 dark:text-blue-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">{{ $faq['question'] }}</span>
                            <div class="bg-blue-100 dark:bg-blue-900/50 p-2 rounded-lg text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white dark:group-hover:bg-blue-700 transition-all duration-300">
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
                            class="px-6 pb-4 text-gray-600 dark:text-gray-300 bg-blue-50/50 dark:bg-blue-900/10"
                        >
                            <p class="py-2">{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 md:py-24 relative">
            <div class="container mx-auto px-4">
                <div class="bg-white dark:bg-secondary-800/80 backdrop-blur-lg rounded-2xl p-8 lg:p-10 shadow-xl border border-blue-50 dark:border-secondary-700">
                    <div class="grid md:grid-cols-2 gap-10">
                        <div>
                            <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 bg-clip-text text-transparent mb-6">Get in Touch</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">Have questions about our system? Contact us and we'll be happy to help.</p>
                            
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-lg text-blue-600 dark:text-blue-400">
                                        <i class="bx bx-envelope text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-blue-800 dark:text-blue-300 mb-1">Email Us</h3>
                                        <p class="text-gray-600 dark:text-gray-300">raifanramadhanputra06@gmail.com</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-4">
                                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-lg text-blue-600 dark:text-blue-400">
                                        <i class="bx bx-phone text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-blue-800 dark:text-blue-300 mb-1">Call Us</h3>
                                        <p class="text-gray-600 dark:text-gray-300">(021) 1234-5678</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-4">
                                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-lg text-blue-600 dark:text-blue-400">
                                        <i class="bx bx-map text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-blue-800 dark:text-blue-300 mb-1">Our Location</h3>
                                        <p class="text-gray-600 dark:text-gray-300">Depok, Indonesia</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8">
                                <h3 class="font-medium text-blue-800 dark:text-blue-300 mb-4">Follow Us</h3>
                                <div class="flex space-x-4">
                                    <a href="#" class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                        <i class="bx bxl-facebook text-xl"></i>
                                    </a>
                                    <a href="#" class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                        <i class="bx bxl-twitter text-xl"></i>
                                    </a>
                                    <a href="#" class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                        <i class="bx bxl-instagram text-xl"></i>
                                    </a>
                                    <a href="#" class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                        <i class="bx bxl-youtube text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 dark:bg-secondary-700/30 rounded-xl p-6 shadow-inner">
                            <h3 class="text-xl font-bold text-blue-800 dark:text-blue-300 mb-6">Send Us a Message</h3>
                            <form class="space-y-6" action="{{ route('contact.send') }}" method="POST">
    @csrf
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Name</label>
        <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-secondary-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-secondary-800 dark:text-white" value="{{ old('name') }}" required>
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Email</label>
        <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-secondary-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-secondary-800 dark:text-white" value="{{ old('email') }}" required>
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject</label>
        <input type="text" id="subject" name="subject" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-secondary-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-secondary-800 dark:text-white" value="{{ old('subject') }}" required>
        @error('subject')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
        <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-secondary-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-secondary-800 dark:text-white" required>{{ old('message') }}</textarea>
        @error('message')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1 transition-all duration-300">
        Send Message
    </button>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 bg-white/80 dark:bg-secondary-900/80 backdrop-blur-lg border-t border-blue-100 dark:border-secondary-800 py-8 lg:py-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-3 rounded-xl shadow-lg mr-3">
                            <i class="bx bxs-school text-2xl text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-blue-900 dark:text-blue-100">Academic Information System</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Digital Solutions for Education</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 max-w-md">Integrated education management platform to improve efficiency and effectiveness of academic processes</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-3 uppercase">Products</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 text-sm">Digital Attendance</a></li>
                            <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 text-sm">Teaching Journal</a></li>
                            <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 text-sm">Student Management</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-3 uppercase">Support</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 text-sm">Help Center</a></li>
                            <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 text-sm">Tutorials</a></li>
                            <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 text-sm">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-3 uppercase">Contact</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-600 dark:text-gray-300 text-sm">
                                <i class="bx bx-envelope mr-2 text-blue-600 dark:text-blue-400"></i>
                                raifanramadhanputra06@gmail.com
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-300 text-sm">
                                <i class="bx bx-phone mr-2 text-blue-600 dark:text-blue-400"></i>
                                (021) 1234-5678
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-300 text-sm">
                                <i class="bx bx-map mr-2 text-blue-600 dark:text-blue-400"></i>
                                Depok, Indonesia
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-blue-100 dark:border-secondary-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 dark:text-gray-300 text-sm">© {{ date('Y') }} Academic Information System. All Rights Reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                        <i class="bx bxl-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                        <i class="bx bxl-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                        <i class="bx bxl-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                        <i class="bx bxl-youtube text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize loading animation
            setTimeout(function() {
                const loader = document.getElementById('page-loader');
                loader.classList.add('loader-fade-out');
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1500);
            
            // Initialize fade-in animations on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100');
                        entry.target.classList.remove('opacity-0');
                    }
                });
            }, {
                threshold: 0.1
            });
            
            // Apply to elements with animate-fade-in class
            document.querySelectorAll('.animate-fade-in').forEach(el => {
                observer.observe(el);
            });
            
            // Counter animation for stats
            const counterElements = document.querySelectorAll('.counter-value');
            counterElements.forEach(el => {
                const target = el.textContent;
                // Skip special formats
                if (target.includes('%') || target.includes('+') || target.includes('/')) {
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
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80, // Account for fixed header
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>