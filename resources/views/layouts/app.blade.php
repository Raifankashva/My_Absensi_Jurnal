<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
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
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'shimmer': 'shimmer 2s linear infinite',
                        'slide-in': 'slideIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
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
                    },
                },
            },
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.85;
                transform: scale(1.02);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        /* Menu hover effect */
        .menu-item-hover {
            position: relative;
            overflow: hidden;
        }

        .menu-item-hover::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            background: linear-gradient(90deg, #60A5FA, #3B82F6);
            transition: width 0.3s ease;
        }

        .menu-item-hover:hover::after {
            width: 100%;
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }

        .glass-morphism-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 41, 59, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .hover-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hover-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .task-card {
            @apply p-4 rounded-xl shadow-sm transition-all duration-300;
        }

        .task-card.due {
            @apply bg-red-50 border-red-200;
            animation: pulse 2s infinite;
        }

        .task-card.upcoming {
            @apply bg-yellow-50 border-yellow-200;
        }

        .task-card.normal {
            @apply bg-white border-gray-200;
        }

        .loading-dots {
            display: inline-block;
            animation: dotAnimation 1.5s infinite;
        }

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

        .gradient-border {
            position: relative;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 1px;
            border-radius: 0.75rem;
            background: linear-gradient(45deg, #2563EB, #60A5FA, #93C5FD, #2563EB);
            background-size: 200% 200%;
            animation: shimmer 3s linear infinite;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .sidebar-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.05));
            border-left: 3px solid #3B82F6;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }

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

        .dark {
            color-scheme: dark;
        }

        .dark .glass-morphism {
            background: rgba(15, 23, 42, 0.8);
            border-color: rgba(30, 41, 59, 0.3);
        }

        .dark .animated-bg {
            background: linear-gradient(-45deg, #0F172A, #1E293B, #334155, #475569);
            background-size: 400% 400%;
        }

        .sidebar-bg {
            background-image: radial-gradient(circle at 0% 100%, #1E3A8A, #1E40AF 40%, #1D4ED8);
            position: relative;
            overflow: hidden;
        }

        .sidebar-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232563EB' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .sidebar-menu-item {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu-item::after {
            content: '';
            position: absolute;
            height: 100%;
            width: 3px;
            background: linear-gradient(to bottom, #60A5FA, #3B82F6);
            left: 0;
            top: 0;
            transform: scaleY(0);
            transition: transform 0.2s ease;
            transform-origin: top;
        }

        .sidebar-menu-item:hover::after {
            transform: scaleY(1);
        }

        .sidebar-icon-container {
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .sidebar-icon-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.2), rgba(37, 99, 235, 0.1));
            border-radius: inherit;
            z-index: -1;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .sidebar-menu-item:hover .sidebar-icon-container::before {
            opacity: 1;
        }

        .sidebar-category {
            position: relative;
            padding-left: 0.75rem;
        }

        .sidebar-category::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 1rem;
            background: linear-gradient(to bottom, #60A5FA, #3B82F6);
            border-radius: 1rem;
        }

        .sidebar-quick-action {
            transition: all 0.3s ease;
            transform: translateY(0);
        }

        .sidebar-quick-action:hover {
            transform: translateY(-3px);
        }
    </style>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
</head>

<body class="font-sans animated-bg min-h-screen" x-data="{ 
    darkMode: false,
    sidebarOpen: window.innerWidth >= 768,
    notifications: [],
    initTheme() {
        if (localStorage.getItem('darkMode') === 'true') {
            this.darkMode = true;
            document.documentElement.classList.add('dark');
        }
    },
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" x-init="initTheme()">
    <div id="page-loader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center animated-bg transition-opacity duration-500">
        <div class="relative w-28 h-28 mb-6 animate-pulse-slow">
            <div class="absolute inset-0 rounded-full border-4 border-t-primary-600 border-r-primary-500 border-b-primary-400 border-l-primary-500 animate-spin"></div>
            <div class="absolute inset-[8px] rounded-full bg-primary-600/20 animate-pulse flex items-center justify-center">
                <i class='bx bxs-school text-4xl text-primary-600'></i>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-2xl font-bold gradient-text mb-3 relative overflow-hidden">
                Memuat Sistem Sekolah
                <span class="loading-dots">...</span>
            </h2>
            <p class="text-sm text-primary-700/70 dark:text-primary-300/70">Harap tunggu sementara kami menyiapkan</p>
        </div>
    </div>

 
    

  

    <aside
        x-cloak
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
        class="fixed inset-y-0 left-0 w-72 sidebar-bg shadow-2xl transform transition-all duration-300 ease-in-out z-40 backdrop-blur-lg">
        
        <!-- Logo Section with Enhanced Design -->
        <div class="relative overflow-hidden">
            <!-- Decorative top wave -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-400 via-primary-500 to-primary-400"></div>
            
            <div class="flex items-center h-20 px-6 border-b border-primary-700/30 backdrop-blur-md">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl shadow-lg transform transition-transform duration-300 hover:scale-105 group">
                        <i class='bx bxs-school text-2xl text-white group-hover:animate-pulse'></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Absensi Jurnal</h1>
                        <div class="flex items-center">
                            <span class="inline-block w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
                            <p class="text-xs text-primary-200">Management System</p>
                        </div>
                    </div>
                </div>
                <button
                    @click="sidebarOpen = false"
                    class="md:hidden ml-auto text-white hover:text-primary-200 transition">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
        </div>

        <nav class="p-4 overflow-y-auto h-[calc(100vh-5rem)] scrollbar-thin scrollbar-thumb-primary-700 scrollbar-track-primary-900/30">
            @if (auth()->check())
            <div class="mb-6 animate-fade-in">
                <div class="px-4 py-5 bg-gradient-to-r from-primary-800/80 to-primary-700/80 rounded-xl mb-4 
                            shadow-lg group hover:scale-[1.02] transition-all duration-300 backdrop-blur-sm border border-primary-600/20">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center 
                                      shadow-lg group-hover:scale-110 transition-all duration-300 border-2 border-primary-300/20">
                                <i class='bx bxs-user text-2xl text-white'></i>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full 
                                      border-2 border-primary-800 animate-pulse"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-primary-100">Welcome back,</p>
                            <p class="text-base font-bold text-white mb-1">{{ auth()->user()->name }}</p>
                            <div class="flex items-center">
                                <span class="inline-block px-3 py-1 bg-primary-600/50 rounded-full text-xs 
                                       text-primary-100 border border-primary-500/30 shadow-inner">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                                <span class="ml-2 text-xs text-primary-300 flex items-center">
                                    <i class='bx bxs-circle text-green-400 text-[8px] mr-1'></i> Online
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5 animate-slide-in" style="--delay: 0.2s">
                    @php
                    function renderEnhancedSidebarLink($routeName, $icon, $label, $badge = null) {
    $isActive = request()->routeIs($routeName);
    $activeClass = $isActive ? 'sidebar-active shadow-lg bg-primary-700 text-white' : '';
    $url = route($routeName);
    $badgeHtml = $badge ? "<span class='px-2 py-0.5 bg-red-500 rounded-full text-xs text-white animate-pulse ml-auto'>$badge</span>" : '';

    return <<< HTML
        <a href="$url"
           class="sidebar-menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-300 
                  $activeClass hover:text-white group relative overflow-hidden">
            <div class="sidebar-icon-container bg-primary-800/50 p-2.5 rounded-lg shadow-inner mr-3 
                        group-hover:bg-primary-700 transition-all duration-300">
                <i class='bx $icon text-xl'></i>
            </div>
            <span class="font-medium">$label</span>
            $badgeHtml
            <div class="ml-auto opacity-0 transform translate-x-2 
                        group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                <i class='bx bx-chevron-right'></i>
            </div>
        </a>
    HTML;
}

                    @endphp

                    @if (auth()->user()->role == 'admin')
                    <div class="mb-6">
                        <h2 class="sidebar-category px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider mb-3 flex items-center">
                            <i class='bx bx-category-alt mr-2'></i> Main Menu
                        </h2>
                        <div class="space-y-1 pl-1">
                            {!! renderEnhancedSidebarLink(('admin.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="sidebar-category px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider mb-3 flex items-center">
                            <i class='bx bx-cog mr-2'></i> Management
                        </h2>
                        <div class="space-y-1 pl-1">
                            {!! renderEnhancedSidebarLink(('adminsekolah.index'), 'bxs-school', 'Sekolah') !!}
                        </div>
                    </div>
                    @elseif (auth()->user()->role == 'guru')
                    <div class="mb-6">
                        <h2 class="sidebar-category px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider mb-3 flex items-center">
                            <i class='bx bx-chalkboard mr-2'></i> Teacher Menu
                        </h2>
                        <div class="space-y-1 pl-1">
                            {!! renderEnhancedSidebarLink(('guru.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderEnhancedSidebarLink(('jadwal-pelajaran.index'), 'bx-calendar-check', 'Jadwal Pelajaran') !!}
                            {!! renderEnhancedSidebarLink(('jadwal-pelajaran.index'), 'bx-calendar-check', 'Jadwal Pelajaran') !!}
                            {!! renderEnhancedSidebarLink(('jurnal-guru.index'), 'bx-book-open', 'Jurnal Mengajar') !!}
                            {!! renderEnhancedSidebarLink(('absensi.select.school'), 'bx-user-check', 'Absensi') !!}
                        </div>
                    </div>
                    @elseif (auth()->user()->role == 'siswa')
                    <div class="mb-6">
                        <h2 class="sidebar-category px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider mb-3 flex items-center">
                            <i class='bx bx-book-reader mr-2'></i> Student Menu
                        </h2>
                        <div class="space-y-1 pl-1">
                            {!! renderEnhancedSidebarLink(('siswa.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderEnhancedSidebarLink('#', 'bx-calendar-event', 'Jadwal') !!}
                            {!! renderEnhancedSidebarLink('#', 'bx-medal', 'Nilai', '2') !!}
                        </div>
                    </div>
                    @elseif (auth()->user()->role == 'sekolah')
                    <div class="mb-6">
                        <h2 class="sidebar-category px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider mb-3 flex items-center">
                            <i class='bx bx-building-house mr-2'></i> Sekolah Menu
                        </h2>
                        <div class="space-y-1 pl-1">
                            {!! renderEnhancedSidebarLink('school.dashboard', 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderEnhancedSidebarLink('adminguru.index', 'bxs-user-detail', 'Guru') !!}
                            {!! renderEnhancedSidebarLink(('kelassekolah.index'), 'bx-chalkboard', 'Kelas') !!}
                            {!! renderEnhancedSidebarLink(('adminsiswa.index'), 'bxs-group', 'Siswa') !!}
                            {!! renderEnhancedSidebarLink(('jadwal-pelajaran.index'),'bx-calendar','Jadwal Pelajaran' ) !!}
                            {!! renderEnhancedSidebarLink(('absensi.index'), 'bx-calendar-check', 'Data Absensi') !!}
                            {!! renderEnhancedSidebarLink(('absensi.scan'), 'bx-scan', 'Scan Absensi') !!}
                            {!! renderEnhancedSidebarLink(('settings.view'), 'bx-cog', 'Pengaturan') !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </nav>

        
    </aside>

    <div :class="{'md:ml-72': sidebarOpen, 'ml-0': !sidebarOpen}"
        class="transition-all duration-300 ease-in-out">
        <header class="h-16 glass-morphism dark:glass-morphism-dark border-b border-primary-100 dark:border-primary-800 flex items-center 
                       justify-between px-6 shadow-sm sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-semibold gradient-text">@yield('title')</span>
            </div>

            @if (auth()->check())
            <div class="flex items-center space-x-4">


                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg 
                                   transition transform hover:scale-105 focus:outline-none focus:ring-2 
                                   focus:ring-red-500 focus:ring-opacity-50 active:scale-95">
                        <i class='bx bx-log-out mr-2'></i>
                        Logout
                    </button>
                </form>
            </div>
            @endif
        </header>

        <main class="p-6 glass-morphism dark:glass-morphism-dark min-h-[calc(100vh-4rem)] animate-[fadeIn_0.5s_ease-in-out]">
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="#" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-300">Home</a>
                    </li>
                    <li class="text-gray-500 dark:text-gray-400">
                        <i class='bx bx-chevron-right'></i>
                    </li>
                    <li class="text-gray-600 dark:text-gray-300">@yield('title')</li>
                </ol>
            </nav>

            <div class="space-y-6 animate-[slideUp_0.5s_ease-in-out]">
                @yield('content')
            </div>
        </main>

        <footer class="glass-morphism dark:glass-morphism-dark border-t border-primary-100 dark:border-primary-800 py-4 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    © 2025 School Management System. All rights reserved.
                </p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300">
                        <i class="bx bxl-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300">
                        <i class="bx bxl-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300">
                        <i class="bx bxl-instagram text-xl"></i>
                    </a>
                </div>
            </div>
        </footer>
    </div>

    <div id="toast-container"
        class="fixed bottom-4 right-4 z-50 space-y-2"
        x-data="{ 
             showToast(message, type = 'success') {
                 const toast = document.createElement('div');
                 toast.className = `p-4 rounded-lg shadow-lg glass-morphism transform translate-y-0 opacity-100 
                                   transition-all duration-300 flex items-center ${
                     type === 'success' ? 'bg-green-500' : 
                     type === 'error' ? 'bg-red-500' : 
                     'bg-primary-500'
                 } text-white`;
                 toast.innerHTML = `
                     <i class='bx ${
                         type === 'success' ? 'bx-check' : 
                         type === 'error' ? 'bx-x' : 
                         'bx-info-circle'
                     } text-xl mr-2'></i>
                     <span>${message}</span>
                 `;
                 document.getElementById('toast-container').appendChild(toast);
                 setTimeout(() => {
                     toast.classList.add('translate-y-2', 'opacity-0');
                     setTimeout(() => toast.remove(), 300);
                 }, 3000);
             }
         }">
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('app', {

            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                Alpine.store('sidebarOpen', true);
            }
        });

        function showNotification(message, type = 'success') {
            Alpine.evaluate(document.getElementById('toast-container'), 'showToast')(message, type);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const loader = document.getElementById('page-loader');

                loader.classList.add('loader-fade-out');

                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1500);
        });
    </script>
</body>

</html>
