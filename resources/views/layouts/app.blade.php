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

        /* Animations */
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

        /* Glass morphism */
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

        /* Card hover effects */
        .hover-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hover-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* Task cards */
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

        /* Loading dots */
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

        /* Loader fade out */
        .loader-fade-out {
            opacity: 0;
            pointer-events: none;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #2563EB, #3B82F6, #60A5FA);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Gradient borders */
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

        /* Sidebar active item */
        .sidebar-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.5), rgba(37, 99, 235, 0.2));
            border-left: 3px solid #3B82F6;
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

        /* Animated background */
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

        /* Dark mode styles */
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
    <!-- Page Loader -->
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

    <!-- Theme Toggle -->
    <button 
        @click="toggleDarkMode()" 
        class="fixed top-4 right-20 z-50 p-2 rounded-full shadow-lg transition transform hover:scale-110 active:scale-95 glass-morphism dark:glass-morphism-dark">
        <i class="bx" :class="darkMode ? 'bx-sun text-yellow-400' : 'bx-moon text-primary-600'"></i>
    </button>

    <!-- Notification Center -->
    <div x-data="{ showNotifications: false }" class="fixed top-4 right-36 z-50">
        <button
            @click="showNotifications = !showNotifications"
            class="p-2 rounded-full shadow-lg transition transform hover:scale-110 active:scale-95 glass-morphism dark:glass-morphism-dark"
            :class="darkMode ? 'text-white' : 'text-primary-800'">
            <i class="bx bx-bell"></i>
        </button>

        <div x-show="showNotifications"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute right-0 mt-3 w-80 rounded-xl shadow-xl glass-morphism dark:glass-morphism-dark"
            @click.away="showNotifications = false">
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-3 gradient-text">Notifications</h3>
                <template x-if="notifications.length === 0">
                    <div class="py-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 dark:bg-primary-900/30 mb-4">
                            <i class="bx bx-bell-off text-2xl text-primary-500"></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">No new notifications</p>
                    </div>
                </template>
                <template x-for="notification in notifications" :key="notification.id">
                    <div class="p-3 mb-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/30 transition-all duration-300">
                        <p x-text="notification.message"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Toggle -->
    <button
        @click="sidebarOpen = !sidebarOpen"
        class="md:hidden fixed top-4 right-4 z-50 bg-gradient-to-r from-primary-600 to-primary-700 text-white p-2 rounded-full shadow-lg 
               transition transform hover:scale-110 hover:shadow-primary-500/20 active:scale-95">
        <i class='bx' :class="sidebarOpen ? 'bx-x' : 'bx-menu'"></i>
    </button>

    <!-- Sidebar -->
    <aside
        x-cloak
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
        class="fixed inset-y-0 left-0 w-72 bg-gradient-to-b from-primary-900 via-primary-800 to-primary-900 
               shadow-2xl transform transition-all duration-300 ease-in-out z-40 backdrop-blur-lg">
        <!-- Logo Section -->
        <div class="flex items-center h-16 px-6 border-b border-primary-700/50 bg-primary-900/50 backdrop-blur-md">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg shadow-lg">
                    <i class='bx bxs-school text-2xl text-white'></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">Absensi Jurnal</h1>
                    <p class="text-xs text-primary-200">Management System</p>
                </div>
            </div>
            <button
                @click="sidebarOpen = false"
                class="md:hidden ml-auto text-white hover:text-primary-200 transition">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="p-4 overflow-y-auto h-[calc(100vh-4rem)] scrollbar-thin scrollbar-thumb-primary-700 scrollbar-track-primary-900/30">
            @if (auth()->check())
            <!-- User Profile Section -->
            <div class="mb-6">
                <div class="px-4 py-4 bg-gradient-to-r from-primary-800 to-primary-700 rounded-xl mb-4 
                            shadow-lg group hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center 
                                      shadow-lg group-hover:scale-110 transition-all duration-300">
                                <i class='bx bxs-user text-2xl text-white'></i>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full 
                                      border-2 border-primary-800 animate-pulse"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-primary-100">Welcome back,</p>
                            <p class="text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                            <span class="inline-block px-2 py-1 bg-primary-600/50 rounded-full text-xs 
                                       text-primary-100 mt-1">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-1">
                    @php
                    function renderSidebarLink($route, $icon, $label, $badge = null) {
                    $isActive = request()->routeIs($route);
                    $activeClass = $isActive ? 'sidebar-active shadow-lg' : 'hover:bg-primary-700/50';
                    $badgeHtml = $badge ? "<span class='px-2 py-1 bg-red-500 rounded-full text-xs text-white animate-pulse'>$badge</span>" : '';

                    return <<< HTML
                        <a href="$route"
                        class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 text-primary-100 
                                  $activeClass hover:text-white group relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-600/20 to-transparent 
                                      opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="bg-primary-800/50 p-2 rounded-lg shadow-inner mr-3 
                                      group-hover:bg-primary-700 group-hover:scale-110 transition-all duration-300">
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
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-primary-400 uppercase tracking-wider mb-2">
                                Main Menu
                            </h2>
                            {!! renderSidebarLink(route('admin.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                        </div>

                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-primary-400 uppercase tracking-wider mb-2">
                                Management
                            </h2>
                            {!! renderSidebarLink(route('sekolahs.index'), 'bxs-school', 'Sekolah', ) !!}
                            {!! renderSidebarLink(route('kelas.index'), 'bx-chalkboard', 'Kelas') !!}
                            {!! renderSidebarLink(route('adminguru.index'), 'bxs-user-detail', 'Guru') !!}
                            {!! renderSidebarLink(route('adminsiswa.index'), 'bxs-group', 'Siswa') !!}
                            {!! renderSidebarLink(route('jurnal-guru.index'), 'bx-calendar', 'Jadwal Pelajaran') !!}
                        </div>
                        @elseif (auth()->user()->role == 'guru')
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-primary-400 uppercase tracking-wider mb-2">
                                Teacher Menu
                            </h2>
                            {!! renderSidebarLink(route('guru.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderSidebarLink(route('jadwal-pelajaran.index'), 'bx-calendar', 'Jadwal Pelajaran') !!}
                            {!! renderSidebarLink(route('jurnal-guru.index'), 'bx-book-open', 'Jurnal Mengajar') !!}
                            {!! renderSidebarLink(route('absensi.select.school'), 'bx-user-check', 'Absensi') !!}
                            
                        </div>
                        @elseif (auth()->user()->role == 'siswa')
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-primary-400 uppercase tracking-wider mb-2">
                                Student Menu
                            </h2>
                            {!! renderSidebarLink(route('siswa.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderSidebarLink('#', 'bx-book', 'Jadwal') !!}
                            {!! renderSidebarLink('#', 'bx-notepad', 'Nilai', '2') !!}
                        </div>
                        @elseif (auth()->user()->role == 'sekolah')
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-primary-400 uppercase tracking-wider mb-2">
                                Sekolah Menu
                            </h2>
                            {!! renderSidebarLink(route('school.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderSidebarLink(route('kelassekolah.index'), 'bx-chalkboard', 'Kelas') !!}
                            {!! renderSidebarLink(route('adminguru.index'), 'bxs-user-detail', 'Guru') !!}
                        </div>
                        @endif

                        <!-- Quick Actions -->
                        <div class="mt-8">
                            <h2 class="px-4 text-xs font-semibold text-primary-400 uppercase tracking-wider mb-2">
                                Quick Actions
                            </h2>
                            <div class="grid grid-cols-2 gap-2 p-2">
                                <x-task-modal />
                                <x-schedule-create />
                            </div>
                        </div>
                </div>
            </div>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <div :class="{'md:ml-72': sidebarOpen, 'ml-0': !sidebarOpen}"
        class="transition-all duration-300 ease-in-out">
        <!-- Top Navigation -->
        <header class="h-16 glass-morphism dark:glass-morphism-dark border-b border-primary-100 dark:border-primary-800 flex items-center 
                       justify-between px-6 shadow-sm sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-semibold gradient-text">@yield('title')</span>
            </div>

            @if (auth()->check())
            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="relative hidden md:block">
                    <input type="text"
                        placeholder="Search..."
                        class="w-64 px-4 py-2 rounded-lg bg-white/50 dark:bg-gray-800/50 border border-primary-100 dark:border-primary-800
                                  focus:outline-none focus:ring-2 focus:ring-primary-400 focus:bg-white dark:focus:bg-gray-800
                                  transition-all duration-300">
                    <i class="bx bx-search absolute right-3 top-2.5 text-gray-400"></i>
                </div>

                <!-- Quick Actions Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all duration-300">
                        <i class="bx bx-grid-alt text-xl text-primary-600 dark:text-primary-400"></i>
                    </button>

                    <div x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-3 w-56 rounded-xl shadow-xl glass-morphism dark:glass-morphism-dark">
                        <div class="p-2">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all duration-300">
                                <i class="bx bx-user mr-2 text-primary-500"></i> Profile
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all duration-300">
                                <i class="bx bx-cog mr-2 text-primary-500"></i> Settings
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-800/50 transition-all duration-300">
                                <i class="bx bx-help-circle mr-2 text-primary-500"></i> Help Center
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Logout Button -->
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

        <!-- Page Content -->
        <main class="p-6 glass-morphism dark:glass-morphism-dark min-h-[calc(100vh-4rem)] animate-[fadeIn_0.5s_ease-in-out]">
            <!-- Breadcrumbs -->
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

            <!-- Content Area -->
            <div class="space-y-6 animate-[slideUp_0.5s_ease-in-out]">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="glass-morphism dark:glass-morphism-dark border-t border-primary-100 dark:border-primary-800 py-4 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    © 2024 School Management System. All rights reserved.
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

    <!-- Toast Notifications -->
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

    <!-- Scripts -->
    <script>
        // Initialize Alpine.js components
        document.addEventListener('alpine:init', () => {
            Alpine.store('app', {
                // Add any global state here
            });
        });

        // Handle responsive sidebar
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                Alpine.store('sidebarOpen', true);
            }
        });

        // Example function to show a toast notification
        function showNotification(message, type = 'success') {
            Alpine.evaluate(document.getElementById('toast-container'), 'showToast')(message, type);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simulate loading time (you can remove this setTimeout in production)
            setTimeout(function() {
                // Get the loader element
                const loader = document.getElementById('page-loader');

                // Add the fade-out class
                loader.classList.add('loader-fade-out');

                // Remove the loader from DOM after transition completes
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1500); // Adjust this value for desired loading time
        });
    </script>
</body>

</html>

