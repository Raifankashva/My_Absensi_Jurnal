@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen">
    <!-- Header Section with animated gradient background -->
    <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 p-6 shadow-lg">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB4PSIwIiB5PSIwIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSgzMCkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSI+PC9yZWN0PjwvcGF0dGVybj48L2RlZnM+PHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSI+PC9yZWN0Pjwvc3ZnPg==')]"></div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl shadow-lg border border-white/20 transform transition-all duration-300 hover:scale-105">
                    <i class="bx bxs-dashboard text-3xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
                    <p class="text-blue-100">Selamat datang kembali, {{ Auth::user()->name }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 bg-white/10 backdrop-blur-md px-6 py-3 rounded-xl shadow-md border border-white/20 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center space-x-2">
                    <i class="bx bx-calendar text-white"></i>
                    <span class="text-sm text-white">{{ now()->format('d M Y') }}</span>
                </div>
                <div class="w-px h-4 bg-white/30"></div>
                <div class="flex items-center space-x-2">
                    <i class="bx bx-time text-white"></i>
                    <span class="text-sm text-white">{{ now()->format('H:i') }}</span>
                </div>
                <div class="w-px h-4 bg-white/30"></div>
                <span class="bg-white/20 backdrop-blur-md text-white text-xs font-medium px-3 py-1 rounded-full border border-white/10">
                    Admin Panel
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards with enhanced animations and gradients -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($cards as $card)
        <div class="relative group transform transition-all duration-500 hover:z-10" 
             x-data="{ hover: false }" 
             @mouseenter="hover = true" 
             @mouseleave="hover = false">
            <!-- Animated gradient background -->
            <div class="absolute inset-0 bg-gradient-to-r {{ $card['gradient'] }} rounded-xl opacity-80 
                        shadow-lg transform transition-all duration-500 
                        group-hover:scale-105 group-hover:opacity-100 
                        group-hover:shadow-xl group-hover:shadow-{{ explode('-', $card['gradient'])[1] }}-500/30"
                 :class="{ 'animate-pulse': hover }"></div>
            
            <!-- Card content with glass morphism -->
            <div class="relative bg-white/90 backdrop-blur-md rounded-xl overflow-hidden 
                        border border-blue-100 transform transition-all duration-500 
                        group-hover:-translate-y-1 group-hover:-translate-x-1">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-2">{{ $card['title'] }}</h3>
                            <p class="text-3xl font-bold text-gray-900 
                                     transition-all duration-500 group-hover:text-blue-700">
                                {{ number_format($card['count']) }}
                            </p>
                            <div class="flex items-center mt-2">
                                <span class="text-{{ $card['trend'][0] === '+' ? 'emerald' : 'red' }}-500 text-sm font-medium">
                                    {{ $card['trend'] }}
                                </span>
                                <span class="text-gray-500 text-xs ml-1">{{ $card['trend_text'] }}</span>
                            </div>
                        </div>
                        <div class="bg-{{ $card['color'] }}-100 rounded-lg p-3 transform transition-all duration-500 
                                    group-hover:bg-{{ $card['color'] }}-200 group-hover:scale-110 group-hover:rotate-3">
                            <i class="bx {{ $card['icon'] }} text-2xl text-{{ $card['color'] }}-600"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Animated progress bar -->
                <div class="h-1 w-full bg-gray-100">
                    <div class="h-1 bg-gradient-to-r from-{{ $card['color'] }}-400 to-{{ $card['color'] }}-600 
                                transition-all duration-1000 ease-out"
                         :class="hover ? 'w-full' : 'w-0'"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

        <!-- Schools List -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100 transform transition-all duration-500 hover:scale-[1.01]">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-200 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="bx bxs-graduation text-xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-900">Daftar Sekolah</h3>
                </div>
                <a href="{{ route('sekolahs.index') }}" class="text-sm text-blue-600 hover:text-blue-800 transition-all duration-300 flex items-center hover:translate-x-1">
                    Lihat Semua
                    <i class="bx bx-right-arrow-alt ml-1"></i>
                </a>
            </div>
            <div class="divide-y divide-blue-100">
                @foreach($sekolah->take(5) as $s)
                <div class="px-6 py-4 hover:bg-blue-50 transition-all duration-300 group">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white group-hover:scale-110 transition-all duration-300">
                                {{ strtoupper(substr($s->nama_sekolah, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 group-hover:text-blue-900 transition-colors duration-300">
                                    {{ $s->nama_sekolah }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $s->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ ucfirst($s->jenjang) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $s->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom animations */
    @keyframes widthGrow {
        0% { width: 0; }
        100% { width: v-bind('data-width'); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    /* Custom scrollbar */
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #EFF6FF;
        border-radius: 10px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #3B82F6;
        border-radius: 10px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #2563EB;
    }
    
    /* Line clamp */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // Initialize animations when elements come into view
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars
        const progressBars = document.querySelectorAll('[data-width]');
        progressBars.forEach(bar => {
            bar.style.width = bar.getAttribute('data-width');
        });
        
        // Add staggered animation to cards
        const cards = document.querySelectorAll('.grid > div');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-[fadeIn_0.5s_ease-in-out]');
        });
    });
</script>
@endsection

