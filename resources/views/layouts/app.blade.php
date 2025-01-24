<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .sidebar-item:hover {
            background-color: rgb(30 58 138 / 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 z-30">
        <div class="flex items-center justify-center h-16 border-b border-gray-200 bg-blue-900">
            <h1 class="text-xl font-bold text-white">Absensi Jurnal</h1>
        </div>
        
        <nav class="p-4">
            <div class="space-y-4">
                @if (auth()->check())
                    <div class="px-4 py-3 bg-blue-50 rounded-lg">
                        <p class="text-sm font-medium text-blue-900">Welcome,</p>
                        <p class="text-sm text-blue-700">{{ auth()->user()->name }}</p>
                    </div>

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bxs-dashboard mr-3 text-xl'></i>
                            Dashboard
                        </a>
                        <a href="{{ route('sekolahs.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bxs-school mr-3 text-xl'></i>
                            Sekolah
                        </a>
                        <a href="{{route ('kelas.index')}}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bx-chalkboard mr-3 text-xl'></i>
                            Kelas
                        </a>
                        <a href="{{ route('adminguru.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bxs-user-detail mr-3 text-xl'></i>
                            Guru
                        </a>
                        <a href="{{ route('adminsiswa.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bxs-group mr-3 text-xl'></i>
                            Siswa
                        </a>
                    @elseif (auth()->user()->role == 'guru')
                        <a href="{{ route('guru.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bxs-dashboard mr-3 text-xl'></i>
                            Dashboard
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bx-book mr-3 text-xl'></i>
                            Mata Pelajaran
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bx-notepad mr-3 text-xl'></i>
                            Nilai
                        </a>
                    @elseif (auth()->user()->role == 'siswa')
                        <a href="{{ route('siswa.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bxs-dashboard mr-3 text-xl'></i>
                            Dashboard
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bx-book mr-3 text-xl'></i>
                            Jadwal
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg sidebar-item">
                            <i class='bx bx-notepad mr-3 text-xl'></i>
                            Nilai
                        </a>
                    @endif
                @endif
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="ml-64">
        <!-- Top Navigation -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-semibold text-blue-900">@yield('title')</span>
            </div>
            
            @if (auth()->check())
            <div class="flex items-center space-x-4">
               
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg focus:outline-none">
                        <i class='bx bx-log-out mr-2'></i>
                        Logout
                    </button>
                </form>
            </div>
            @endif
        </header>

        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>