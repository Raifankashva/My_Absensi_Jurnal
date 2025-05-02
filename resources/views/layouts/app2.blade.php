<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Informasi Sekolah') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        .schedule-tabs::-webkit-scrollbar {
            height: 4px;
        }
        
        .schedule-tabs::-webkit-scrollbar-track {
            background: #f1f9ff;
        }
        
        .schedule-tabs::-webkit-scrollbar-thumb {
            background: #93c5fd;
            border-radius: 10px;
        }
        
        .transition-all {
            transition: all 0.3s ease-in-out;
        }
        
        .wave-bg {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23dbeafe' fill-opacity='1' d='M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,208C1248,171,1344,117,1392,90.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-position: bottom;
        }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        },
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <!-- Header with Glass Effect -->
    <header class="sticky top-0 z-20 backdrop-blur-md bg-white/80 shadow-sm">
        <div class="px-4 py-3 flex items-center justify-between max-w-6xl mx-auto">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="h-10 w-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-primary-200/50">
                    <i class='bx bxs-book-reader text-xl'></i>
                </div>
                <div class="ml-3">
                    <span class="text-base font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">My Absensi Jurnal</span>
                    <p class="text-xs text-slate-500 -mt-1">Sistem Informasi Sekolah</p>
                </div>
            </div>
            
            <!-- Current Date with Icon -->
            <div class="hidden sm:flex items-center text-slate-600 bg-primary-50 px-3 py-1.5 rounded-full">
                <i class='bx bx-calendar text-primary-500 mr-2'></i>
                <span class="text-sm font-medium">{{ now()->isoFormat('dddd, D MMM Y') }}</span>
            </div>
            
            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-3 py-1.5 text-sm text-slate-700 bg-slate-100 hover:bg-red-50 hover:text-red-600 rounded-full
                    transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500/30 active:scale-95">
                    <i class='bx bx-log-out mr-1.5 text-lg'></i>
                    <span class="hidden sm:inline font-medium">Logout</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="min-h-screen pb-20 max-w-6xl mx-auto px-4">
        @yield('content')
    </main>

    <!-- Fixed Bottom Navbar with Pill Style -->
    <nav class="fixed bottom-3 left-1/2 transform -translate-x-1/2 bg-white border border-slate-200 rounded-full shadow-lg z-20 px-2 py-1.5">
        <div class="flex items-center justify-around space-x-1 sm:space-x-3 h-14">
            <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center justify-center px-3 py-1.5 rounded-full {{ request()->routeIs('siswa.dashboard') ? 'bg-primary-100 text-primary-600' : 'text-slate-500 hover:bg-slate-100' }}">
                <i class='bx bxs-home text-xl'></i>
                <span class="text-[10px] mt-0.5">Beranda</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center px-3 py-1.5 rounded-full text-slate-500 hover:bg-slate-100 transition-colors">
                <i class='bx bxs-medal text-xl'></i>
                <span class="text-[10px] mt-0.5">Nilai</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center px-3 py-1.5 rounded-full text-slate-500 hover:bg-slate-100 transition-colors">
                <i class='bx bxs-calendar-check text-xl'></i>
                <span class="text-[10px] mt-0.5">Absensi</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center px-3 py-1.5 rounded-full text-slate-500 hover:bg-slate-100 transition-colors">
                <i class='bx bxs-book-content text-xl'></i>
                <span class="text-[10px] mt-0.5">Tugas</span>
            </a> 
            <a href="{{ route('siswa.profile') }}" class="flex flex-col items-center justify-center px-3 py-1.5 rounded-full text-slate-500 hover:bg-slate-100 transition-colors">
                <i class='bx bxs-user text-xl'></i>
                <span class="text-[10px] mt-0.5">Profil</span>
            </a>
        </div>
    </nav>

    <!-- Flash Messages with Animation -->
    @if (session('success'))
    <div id="flash-message" class="fixed top-16 inset-x-0 flex items-center justify-center px-4 py-3 z-50"
         x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-xl flex items-center w-full max-w-md">
            <div class="mr-3 bg-emerald-100 rounded-full p-1">
                <i class='bx bx-check-circle text-xl text-emerald-500'></i>
            </div>
            <p class="text-sm font-medium">{{ session('success') }}</p>
            <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div id="flash-error" class="fixed top-16 inset-x-0 flex items-center justify-center px-4 py-3 z-50"
         x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2">
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-xl flex items-center w-full max-w-md">
            <div class="mr-3 bg-red-100 rounded-full p-1">
                <i class='bx bx-error-circle text-xl text-red-500'></i>
            </div>
            <p class="text-sm font-medium">{{ session('error') }}</p>
            <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>
    </div>
    @endif

   

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>