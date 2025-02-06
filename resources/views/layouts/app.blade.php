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
    <style>
        [x-cloak] { display: none !important; }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

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
            background-color: #60A5FA;
            transition: width 0.3s ease;
        }

        .menu-item-hover:hover::after {
            width: 100%;
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .dark-theme {
            --bg-primary: #1a1a1a;
            --text-primary: #ffffff;
        }
        .task-card {
    @apply p-4 rounded-lg shadow-sm transition-all duration-300;
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

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}
    </style>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen" x-data="{ 
    darkMode: false,
    sidebarOpen: window.innerWidth >= 768,
    notifications: [],
    initTheme() {
        if (localStorage.getItem('darkMode') === 'true') {
            this.darkMode = true;
            document.documentElement.classList.add('dark');
        }
    }
}" x-init="initTheme()">
    <!-- Theme Toggle -->
    
    <!-- Notification Center -->
    <div x-data="{ showNotifications: false }" class="fixed top-4 right-36 z-50">
        <button 
            @click="showNotifications = !showNotifications"
            class="p-2 rounded-lg shadow-lg transition transform hover:scale-105 glass-morphism"
            :class="darkMode ? 'bg-gray-800 text-white' : 'bg-white text-gray-800'">
            <i class="bx bx-bell"></i>
        </button>
        
        <div x-show="showNotifications" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="absolute right-0 mt-2 w-80 rounded-lg shadow-lg glass-morphism"
             @click.away="showNotifications = false">
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">Notifications</h3>
                <template x-if="notifications.length === 0">
                    <p class="text-gray-500">No new notifications</p>
                </template>
                <template x-for="notification in notifications" :key="notification.id">
                    <div class="p-2 mb-2 rounded-lg hover:bg-blue-50 transition">
                        <p x-text="notification.message"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Toggle -->
    <button 
        @click="sidebarOpen = !sidebarOpen"
        class="md:hidden fixed top-4 right-4 z-50 bg-blue-600 text-white p-2 rounded-lg shadow-lg 
               transition transform hover:scale-105 hover:bg-blue-700 active:scale-95">
        <i class='bx bx-menu text-2xl'></i>
    </button>

    <!-- Sidebar -->
    <aside 
        x-cloak
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
        class="fixed inset-y-0 left-0 w-72 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900 
               shadow-2xl transform transition-all duration-300 ease-in-out z-40 backdrop-blur-lg">
        <!-- Logo Section -->
        <div class="flex items-center h-16 px-6 border-b border-blue-700/50 bg-blue-900/50 backdrop-blur-md">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-600 rounded-lg shadow-lg">
                    <i class='bx bxs-school text-2xl text-white'></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">Absensi Jurnal</h1>
                    <p class="text-xs text-blue-200">Management System</p>
                </div>
            </div>
            <button 
                @click="sidebarOpen = false"
                class="md:hidden ml-auto text-white hover:text-blue-200 transition">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="p-4 overflow-y-auto h-[calc(100vh-4rem)]">
            @if (auth()->check())
            <!-- User Profile Section -->
            <div class="mb-6">
                <div class="px-4 py-4 bg-gradient-to-r from-blue-800 to-blue-700 rounded-xl mb-4 
                            shadow-lg group hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center 
                                      shadow-lg group-hover:scale-110 transition-all duration-300">
                                <i class='bx bxs-user text-2xl text-white'></i>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full 
                                      border-2 border-white"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-100">Welcome back,</p>
                            <p class="text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                            <span class="inline-block px-2 py-1 bg-blue-600/50 rounded-full text-xs 
                                       text-blue-100 mt-1">
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
                        $activeClass = $isActive ? 'bg-blue-600/50 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-700/50';
                        $badgeHtml = $badge ? "<span class='px-2 py-1 bg-red-500 rounded-full text-xs text-white'>{$badge}</span>" : '';
                        
                        return <<< HTML
                        <a href="{$route}" 
                           class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {$activeClass}
                                  hover:text-white group relative overflow-hidden hover:shadow-md">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-transparent 
                                      opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="bg-blue-800/50 p-2 rounded-lg shadow-inner mr-3 
                                      group-hover:scale-110 transition-transform duration-300">
                                <i class='bx {$icon} text-xl'></i>
                            </div>
                            <span class="font-medium">{$label}</span>
                            {$badgeHtml}
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
                            <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">
                                Main Menu
                            </h2>
                            {!! renderSidebarLink(route('admin.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                        </div>
                        
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">
                                Management
                            </h2>
                            {!! renderSidebarLink(route('sekolahs.index'), 'bxs-school', 'Sekolah', ) !!}
                            {!! renderSidebarLink(route('kelas.index'), 'bx-chalkboard', 'Kelas') !!}
                            {!! renderSidebarLink(route('adminguru.index'), 'bxs-user-detail', 'Guru') !!}
                            {!! renderSidebarLink(route('adminsiswa.index'), 'bxs-group', 'Siswa') !!}
                        </div>
                    @elseif (auth()->user()->role == 'guru')
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">
                                Teacher Menu
                            </h2>
                            {!! renderSidebarLink(route('guru.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderSidebarLink('#', 'bx-book', 'Mata Pelajaran', '3') !!}
                            {!! renderSidebarLink('#', 'bx-notepad', 'Nilai') !!}
                        </div>
                    @elseif (auth()->user()->role == 'siswa')
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">
                                Student Menu
                            </h2>
                            {!! renderSidebarLink(route('siswa.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderSidebarLink('#', 'bx-book', 'Jadwal') !!}
                            {!! renderSidebarLink('#', 'bx-notepad', 'Nilai', '2') !!}
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="mt-8">
                        <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">
                            Quick Actions
                        </h2>
                        <div class="grid grid-cols-2 gap-2 p-2">
                        <x-task-modal />
                            <button class="p-3 rounded-xl bg-blue-700/50 hover:bg-blue-600/50 
                                         transition-all duration-300 text-white text-sm">
                                <i class='bx bx-calendar mb-1'></i>
                                <span class="block">Schedule</span>
                            </button>
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
        <header class="h-16 glass-morphism border-b border-blue-100 flex items-center 
                       justify-between px-6 shadow-sm sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-semibold text-blue-900">@yield('title')</span>
            </div>
            
            @if (auth()->check())
            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="relative hidden md:block">
                    <input type="text" 
                           placeholder="Search..." 
                           class="w-64 px-4 py-2 rounded-lg bg-white/50 border border-blue-100 
                                  focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white">
                    <i class="bx bx-search absolute right-3 top-2.5 text-gray-400"></i>
                </div>

                <!-- Quick Actions Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="p-2 rounded-lg hover:bg-blue-50 transition">
                        <i class="bx bx-grid-alt text-xl text-blue-600"></i>
                    </button>
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg glass-morphism">
                        <div class="p-2">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 rounded-lg hover:bg-blue-50">
                                <i class="bx bx-user mr-2"></i> Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 rounded-lg hover:bg-blue-50">
                                <i class="bx bx-cog mr-2"></i> Settings
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 rounded-lg hover:bg-blue-50">
                                <i class="bx bx-help-circle mr-2"></i> Help Center
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg 
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
        <main class="p-6 glass-morphism min-h-[calc(100vh-4rem)]">
            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="#" class="text-blue-600 hover:text-blue-800">Home</a>
                    </li>
                    <li class="text-gray-500">
                        <i class='bx bx-chevron-right'></i>
                    </li>
                    <li class="text-gray-600">@yield('title')</li>
                </ol>
            </nav>

            <!-- Content Area -->
            <div class="space-y-6">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="glass-morphism border-t border-blue-100 py-4 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-600">
                    © 2024 School Management System. All rights reserved.
                </p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="bx bxl-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="bx bxl-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition">
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
                     'bg-blue-500'
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
</body>
</html>