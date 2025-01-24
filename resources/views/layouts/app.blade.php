<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <!-- Mobile Menu Toggle -->
    <button id="mobile-menu-toggle" class="md:hidden fixed top-4 right-4 z-50 bg-blue-600 text-white p-2 rounded-lg shadow-lg transition transform hover:scale-105">
        <i class='bx bx-menu text-2xl'></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-blue-900 to-blue-800 shadow-2xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="flex items-center justify-between h-16 border-b border-blue-700 px-4">
            <h1 class="text-xl font-bold text-white">Absensi Jurnal</h1>
            <button id="mobile-menu-close" class="md:hidden text-white">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>
        
        <nav class="p-4 overflow-y-auto h-[calc(100vh-4rem)]">
            <div class="space-y-2">
                @if (auth()->check())
                    <div class="px-4 py-3 bg-blue-800 rounded-lg mb-4 shadow-md">
                        <p class="text-sm font-medium text-blue-100">Welcome,</p>
                        <p class="text-sm text-blue-200">{{ auth()->user()->name }}</p>
                    </div>

                    @php
                    function renderSidebarLink($route, $icon, $label) {
                        $activeClass = request()->routeIs($route) ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700';
                        return <<< HTML
                        <a href="{$route}" class="flex items-center px-4 py-2 rounded-lg transition duration-300 {$activeClass} 
                            hover:text-white active:bg-blue-600 active:scale-95 
                            focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class='bx {$icon} mr-3 text-xl'></i>
                            {$label}
                        </a>
                        HTML;
                    }
                    @endphp

                    @if (auth()->user()->role == 'admin')
                        {!! renderSidebarLink(route('admin.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                        {!! renderSidebarLink(route('sekolahs.index'), 'bxs-school', 'Sekolah') !!}
                        {!! renderSidebarLink(route('kelas.index'), 'bx-chalkboard', 'Kelas') !!}
                        {!! renderSidebarLink(route('adminguru.index'), 'bxs-user-detail', 'Guru') !!}
                        {!! renderSidebarLink(route('adminsiswa.index'), 'bxs-group', 'Siswa') !!}
                    @elseif (auth()->user()->role == 'guru')
                        {!! renderSidebarLink(route('guru.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                        {!! renderSidebarLink('#', 'bx-book', 'Mata Pelajaran') !!}
                        {!! renderSidebarLink('#', 'bx-notepad', 'Nilai') !!}
                    @elseif (auth()->user()->role == 'siswa')
                        {!! renderSidebarLink(route('siswa.dashboard'), 'bxs-dashboard', 'Dashboard') !!}
                        {!! renderSidebarLink('#', 'bx-book', 'Jadwal') !!}
                        {!! renderSidebarLink('#', 'bx-notepad', 'Nilai') !!}
                    @endif
                @endif
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="md:ml-64 transition-all duration-300 ease-in-out">
        <!-- Top Navigation -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-blue-100 flex items-center justify-between px-6 shadow-sm">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-semibold text-blue-900">@yield('title')</span>
            </div>
            
            @if (auth()->check())
            <div class="flex items-center space-x-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-100 rounded-lg focus:outline-none transition transform hover:scale-105">
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

        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });

        mobileMenuClose.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });
    </script>
</body>
</html>