<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0ea5e9">
    <title>@yield('title', 'Teacher Dashboard') - School System</title>
    
    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
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
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
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
        
        /* Loader animation */
        @keyframes loader-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loader {
            animation: loader-spin 1.2s linear infinite;
        }
        
        /* Bottom nav indicator animation */
        @keyframes indicator-slide {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        
        .nav-indicator {
            animation: indicator-slide 0.3s ease-out forwards;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(224, 242, 254, 0.3);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.5);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(2, 132, 199, 0.7);
        }
        
        /* Safe area for bottom navigation */
        .safe-area-bottom {
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #0284c7, #0ea5e9, #38bdf8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        /* Card hover effect */
        .hover-card {
            transition: all 0.3s ease;
        }
        
        .hover-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.1);
        }
        
        /* Dark mode styles */
        .dark {
            color-scheme: dark;
        }
    </style>
    
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
</head>

<body class="font-sans bg-gray-50 text-gray-900 min-h-screen flex flex-col" 
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true',
          activeTab: window.location.pathname,
          showProfileMenu: false,
          showNotifications: false,
          notifications: [],
          
          toggleDarkMode() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('darkMode', this.darkMode);
              
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          },
          
          init() {
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              }
              
              // Set active tab based on current route
              const path = window.location.pathname;
              if (path.includes('dashboard')) {
                  this.activeTab = 'dashboard';
              } else if (path.includes('jadwal')) {
                  this.activeTab = 'jadwal';
              } else if (path.includes('jurnal')) {
                  this.activeTab = 'jurnal';
              } else if (path.includes('absensi.pelajaran.jadwal-hari-ini')) {
                  this.activeTab = 'absensi.pelajaran.jadwal-hari-ini';
              } else if (path.includes('profile')) {
                  this.activeTab = 'profile';
              }
          }
      }"
      x-init="init()"
      :class="{ 'dark bg-gray-900 text-gray-100': darkMode }">
    
    <!-- Page Loader -->
    <div id="page-loader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-white dark:bg-gray-900 transition-opacity duration-500">
        <div class="relative w-20 h-20 mb-4">
            <div class="absolute inset-0 rounded-full border-4 border-t-primary-500 border-r-primary-400 border-b-primary-300 border-l-primary-400 loader"></div>
            <div class="absolute inset-[6px] rounded-full bg-primary-500/20 flex items-center justify-center">
                <i class='bx bxs-school text-3xl text-primary-500'></i>
            </div>
        </div>
        <p class="text-primary-600 dark:text-primary-400 font-medium">Loading...</p>
    </div>

    <!-- Top App Bar -->
    <header class="sticky top-0 z-30 bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-800">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo and Title -->
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg shadow-md">
                        <i class='bx bxs-school text-xl text-white'></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">Jurnal Guru</h1>
                        <div class="flex items-center">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-400 mr-1.5 animate-pulse"></span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Online</p>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-2">
                    <!-- Dark Mode Toggle -->
                    <button @click="toggleDarkMode()" 
                            class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <i class="bx text-xl" :class="darkMode ? 'bx-sun text-yellow-400' : 'bx-moon text-gray-600'"></i>
                    </button>
                    
                    <!-- Notifications -->
                    <div class="relative">
                        <button @click="showNotifications = !showNotifications"
                                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors relative">
                            <i class='bx bx-bell text-xl text-gray-600 dark:text-gray-300'></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full" x-show="notifications.length > 0"></span>
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div x-show="showNotifications" 
                             x-cloak
                             @click.away="showNotifications = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                            <div class="p-4">
                                <h3 class="text-base font-semibold mb-2">Notifications</h3>
                                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <template x-if="notifications.length === 0">
                                        <div class="py-6 text-center">
                                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-3">
                                                <i class='bx bx-bell-off text-xl text-gray-500 dark:text-gray-400'></i>
                                            </div>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm">No new notifications</p>
                                        </div>
                                    </template>
                                    <template x-for="notification in notifications" :key="notification.id">
                                        <div class="py-3">
                                            <p class="text-sm" x-text="notification.message"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="notification.time"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Menu -->
                    <div class="relative">
                        <button @click="showProfileMenu = !showProfileMenu"
                                class="flex items-center space-x-1 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white">
                                <span class="text-sm font-medium">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                            </div>
                        </button>
                        
                        <!-- Profile Dropdown -->
                        <div x-show="showProfileMenu" 
                             x-cloak
                             @click.away="showProfileMenu = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                            <div class="p-2">
                                @if(auth()->check())
                                <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                </div>
                                @endif
                                
                                <a href="{{ route('guru.profile') }}" class="flex items-center px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <i class='bx bx-user text-lg mr-2 text-gray-500 dark:text-gray-400'></i>
                                    Profile
                                </a>
                                
                                <a href="{{ route('guru.profile.edit')}}" class="flex items-center px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <i class='bx bx-cog text-lg mr-2 text-gray-500 dark:text-gray-400'></i>
                                    Settings
                                </a>
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-red-600 dark:text-red-400">
                                        <i class='bx bx-log-out text-lg mr-2'></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="page-enter page-enter-active">
        @if(session('success'))
            <div class="mx-4 mt-4 rounded-md bg-green-50 p-4 border-l-4 border-green-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class='bx bx-check-circle text-green-400'></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>
    <!-- Bottom Navigation (Mobile) -->
    <nav class="fixed bottom-0 inset-x-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 shadow-lg md:hidden z-40 safe-area-bottom">
        <div class="grid grid-cols-5 h-16">
            <!-- Dashboard -->
            <a href="{{ route('guru.dashboard') }}" 
               class="flex flex-col items-center justify-center relative"
               @click="activeTab = 'dashboard'">
                <div class="p-1.5 rounded-full" :class="activeTab === 'dashboard' ? 'text-primary-500' : 'text-gray-500 dark:text-gray-400'">
                    <i class='bx bxs-dashboard text-2xl'></i>
                </div>
                <span class="text-xs mt-0.5" :class="activeTab === 'dashboard' ? 'text-primary-500 font-medium' : 'text-gray-500 dark:text-gray-400'">Dashboard</span>
                <div x-show="activeTab === 'dashboard'" class="absolute bottom-0 inset-x-0 h-0.5 bg-primary-500 nav-indicator"></div>
            </a>
            
            <!-- Jadwal -->
            <a href="{{ route('jadwal-pelajaran.index') }}" 
               class="flex flex-col items-center justify-center relative"
               @click="activeTab = 'jadwal'">
                <div class="p-1.5 rounded-full" :class="activeTab === 'jadwal' ? 'text-primary-500' : 'text-gray-500 dark:text-gray-400'">
                    <i class='bx bx-calendar-check text-2xl'></i>
                </div>
                <span class="text-xs mt-0.5" :class="activeTab === 'jadwal' ? 'text-primary-500 font-medium' : 'text-gray-500 dark:text-gray-400'">Jadwal</span>
                <div x-show="activeTab === 'jadwal'" class="absolute bottom-0 inset-x-0 h-0.5 bg-primary-500 nav-indicator"></div>
            </a>
            
            <!-- Quick Add Button (Center) -->
            <div class="flex items-center justify-center">
                <a href="{{ route('jurnal-guru.create') }}" class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center shadow-lg transform -translate-y-2 hover:scale-110 transition-transform">
                    <i class='bx bx-plus text-2xl text-white'></i>
                </a>
            </div>
            
            <!-- Jurnal -->
            <a href="{{ route('jurnal-guru.index') }}" 
               class="flex flex-col items-center justify-center relative"
               @click="activeTab = 'jurnal'">
                <div class="p-1.5 rounded-full" :class="activeTab === 'jurnal' ? 'text-primary-500' : 'text-gray-500 dark:text-gray-400'">
                    <i class='bx bx-book-open text-2xl'></i>
                </div>
                <span class="text-xs mt-0.5" :class="activeTab === 'jurnal' ? 'text-primary-500 font-medium' : 'text-gray-500 dark:text-gray-400'">Jurnal</span>
                <div x-show="activeTab === 'jurnal'" class="absolute bottom-0 inset-x-0 h-0.5 bg-primary-500 nav-indicator"></div>
            </a>
            
            <!-- absensi.pelajaran.jadwal-hari-ini -->
            <a href="{{ route('absensi.pelajaran.jadwal-hari-ini') }}" 
               class="flex flex-col items-center justify-center relative"
               @click="activeTab = 'absensi.pelajaran.jadwal-hari-ini'">
                <div class="p-1.5 rounded-full" :class="activeTab === 'absensi.pelajaran.jadwal-hari-ini' ? 'text-primary-500' : 'text-gray-500 dark:text-gray-400'">
                    <i class='bx bx-user-check text-2xl'></i>
                </div>
                <span class="text-xs mt-0.5" :class="activeTab === 'absensi.pelajaran.jadwal-hari-ini' ? 'text-primary-500 font-medium' : 'text-gray-500 dark:text-gray-400'">absensi</span>
                <div x-show="activeTab === 'absensi.pelajaran.jadwal-hari-ini'" class="absolute bottom-0 inset-x-0 h-0.5 bg-primary-500 nav-indicator"></div>
            </a>
        </div>
    </nav>

    <!-- Desktop Navigation (Sidebar) -->
    <div class="hidden md:block fixed left-0 top-16 bottom-0 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 shadow-sm z-30 overflow-y-auto">
        <div class="p-4">
            <!-- User Profile Summary -->
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-primary-500 flex items-center justify-center text-white">
                        <span class="text-lg font-medium">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-medium">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? 'email@example.com' }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-xs font-medium bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200">
                            Guru
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Links -->
            <nav class="space-y-1">
                <a href="{{ route('guru.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors"
                   :class="activeTab === 'dashboard' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : 'hover:bg-gray-100 dark:hover:bg-gray-800'">
                    <i class='bx bxs-dashboard text-xl mr-3' :class="activeTab === 'dashboard' ? 'text-primary-500' : 'text-gray-500 dark:text-gray-400'"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('jadwal-pelajaran.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors"
                   :class="activeTab === 'jadwal' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : 'hover:bg-gray-100 dark:hover:bg-gray-800'">
                    <i class='bx bx-calendar-check text-xl mr-3' :class="activeTab === 'jadwal' ? 'text-primary-500' : 'text-gray-500 dark:text-gray-400'"></i>
                    <span>Jadwal Pelajaran</span>
                </a>
                
                <a href="{{ route('jurnal-guru.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors"
                   :class="activeTab === 'jurnal' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : 'hover:bg-gray-100 dark:hover:bg-gray-800'">
                    <i class='bx bx-book-open text-xl mr-3' :class="activeTab === 'jurnal' ? 'text-primary-500' : 'text-gray-500 dark:text-gray-400'"></i>
                    <span>Jurnal Mengajar</span>
                </a>
                
                <a href="{{ route('absensi.pelajaran.jadwal-hari-ini') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors"
                   :class="activeTab === 'absensi.pelajaran.jadwal-hari-ini' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : 'hover:bg-gray-100 dark:hover:bg-gray-800'">
                    <i class='bx bx-user-check text-xl mr-3' :class="activeTab === 'absensi.pelajaran.jadwal-hari-ini' ? 'text-primary-500' : 'text-gray-500 dark:text-gray-400'"></i>
                    <span>absensi</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Quick Actions
                    </h3>
                    
                    <a href="{{ route('jurnal-guru.create') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 text-primary-600 dark:text-primary-400">
                        <i class='bx bx-plus-circle text-xl mr-3'></i>
                        <span>Tambah Jurnal</span>
                    </a>
                    
                    <a href="#" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i class='bx bx-help-circle text-xl mr-3 text-gray-500 dark:text-gray-400'></i>
                        <span>Bantuan</span>
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container" class="fixed bottom-20 md:bottom-4 right-4 z-50 space-y-2"></div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simulate loading time (remove setTimeout in production)
            setTimeout(function() {
                const loader = document.getElementById('page-loader');
                loader.classList.add('opacity-0');
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 800);
            
            // Function to show toast notifications
            window.showToast = function(message, type = 'success') {
                const toast = document.createElement('div');
                const bgColor = type === 'success' ? 'bg-green-500' : 
                                type === 'error' ? 'bg-red-500' : 
                                'bg-primary-500';
                const icon = type === 'success' ? 'bx-check-circle' : 
                            type === 'error' ? 'bx-x-circle' : 
                            'bx-info-circle';
                
                toast.className = `p-3 rounded-lg shadow-lg ${bgColor} text-white flex items-center max-w-xs transform transition-all duration-300`;
                toast.innerHTML = `
                    <i class='bx ${icon} text-xl mr-2'></i>
                    <span>${message}</span>
                `;
                
                document.getElementById('toast-container').appendChild(toast);
                
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-x-full');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            };
            
            // Example: Show welcome toast (remove in production)
            // showToast('Welcome back, Teacher!');
        });
    </script>
</body>
</html>
