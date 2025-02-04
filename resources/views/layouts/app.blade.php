<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <!-- Mobile Menu Toggle -->
    <button id="mobile-menu-toggle" class="md:hidden fixed top-4 right-4 z-50 bg-blue-600 text-white p-2 rounded-lg shadow-lg transition transform hover:scale-105 hover:bg-blue-700 active:scale-95">
        <i class='bx bx-menu text-2xl'></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900 shadow-2xl transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out z-40 backdrop-blur-lg">
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
            <button id="mobile-menu-close" class="md:hidden ml-auto text-white hover:text-blue-200 transition">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="p-4 overflow-y-auto h-[calc(100vh-4rem)]">
            <!-- User Profile Section -->
            @if (auth()->check())
            <div class="mb-6">
                <div class="px-4 py-4 bg-gradient-to-r from-blue-800 to-blue-700 rounded-xl mb-4 shadow-lg group hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-300">
                            <i class='bx bxs-user text-2xl text-white'></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-100">Welcome back,</p>
                            <p class="text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                            <span class="inline-block px-2 py-1 bg-blue-600/50 rounded-full text-xs text-blue-100 mt-1">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-1">
                    @php
                    function renderSidebarLink($route, $icon, $label) {
                        $isActive = request()->routeIs($route);
                        $activeClass = $isActive ? 'bg-blue-600/50 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-700/50';
                        return <<< HTML
                        <a href="{$route}" 
                           class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {$activeClass}
                                  hover:text-white group relative overflow-hidden hover:shadow-md">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="bg-blue-800/50 p-2 rounded-lg shadow-inner mr-3 group-hover:scale-110 transition-transform duration-300">
                                <i class='bx {$icon} text-xl'></i>
                            </div>
                            <span class="font-medium">{$label}</span>
                            <div class="ml-auto opacity-0 transform translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                                <i class='bx bx-chevron-right'></i>
                            </div>
                        </a>
                        HTML;
                    }
                    @endphp

                    @if (auth()->user()->role == 'admin')
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">Main Menu</h2>
                            {!! renderSidebarLink(route('admin.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                        </div>
                        
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">Management</h2>
                            {!! renderSidebarLink(route('sekolahs.index'), 'bxs-school', 'Sekolah') !!}
                            {!! renderSidebarLink(route('kelas.index'), 'bx-chalkboard', 'Kelas') !!}
                            {!! renderSidebarLink(route('adminguru.index'), 'bxs-user-detail', 'Guru') !!}
                            {!! renderSidebarLink(route('adminsiswa.index'), 'bxs-group', 'Siswa') !!}
                        </div>
                    @elseif (auth()->user()->role == 'guru')
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">Teacher Menu</h2>
                            {!! renderSidebarLink(route('guru.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderSidebarLink('#', 'bx-book', 'Mata Pelajaran') !!}
                            {!! renderSidebarLink('#', 'bx-notepad', 'Nilai') !!}
                        </div>
                    @elseif (auth()->user()->role == 'siswa')
                        <div class="mb-4">
                            <h2 class="px-4 text-xs font-semibold text-blue-400 uppercase tracking-wider mb-2">Student Menu</h2>
                            {!! renderSidebarLink(route('siswa.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                            {!! renderSidebarLink('#', 'bx-book', 'Jadwal') !!}
                            {!! renderSidebarLink('#', 'bx-notepad', 'Nilai') !!}
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="md:ml-72 transition-all duration-300 ease-in-out">
        <!-- Top Navigation -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-blue-100 flex items-center justify-between px-6 shadow-sm">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-semibold text-blue-900">@yield('title')</span>
            </div>
            
            @if (auth()->check())
            <div class="flex items-center space-x-4">
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
        <main class="p-6 bg-white/70 backdrop-blur-md min-h-[calc(100vh-4rem)]">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Menu JavaScript -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenuClose = document.getElementById('mobile-menu-close');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
        }

        mobileMenuToggle.addEventListener('click', toggleSidebar);
        mobileMenuClose.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768) {
                if (!sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });
    </script>
</body>
</html>