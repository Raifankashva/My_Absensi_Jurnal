@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="min-h-screen relative overflow-hidden">
    <!-- Background Design Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Hero Section -->
    <div class="relative z-10 container mx-auto px-4 py-16">
        <div class="text-center mb-16 animate-fade-in">
            <div class="flex justify-center mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4 rounded-2xl shadow-2xl transform hover:scale-110 transition-all duration-300">
                    <i class="bx bxs-school text-5xl text-white"></i>
                </div>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-blue-900 mb-4">
                Welcome to School Management System
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Manage your school activities efficiently with our comprehensive system
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            @php
            $features = [
                [
                    'icon' => 'bxs-user-check',
                    'color' => 'blue',
                    'title' => 'Attendance Management',
                    'description' => 'Track student and teacher attendance efficiently with our advanced system.'
                ],
                [
                    'icon' => 'bxs-book-content',
                    'color' => 'indigo',
                    'title' => 'Course Management',
                    'description' => 'Organize and manage courses, subjects, and class schedules effectively.'
                ],
                [
                    'icon' => 'bxs-report',
                    'color' => 'purple',
                    'title' => 'Performance Tracking',
                    'description' => 'Monitor academic progress and generate detailed performance reports.'
                ]
            ];
            @endphp

            @foreach ($features as $feature)
            <div class="group bg-white/50 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-gradient-to-r from-{{ $feature['color'] }}-500 to-{{ $feature['color'] }}-600 w-14 h-14 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="bx {{ $feature['icon'] }} text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-blue-900 mb-2">{{ $feature['title'] }}</h3>
                <p class="text-gray-600">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Stats Section -->
        <div class="bg-white/50 backdrop-blur-lg rounded-2xl p-8 shadow-lg mb-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @php
                $stats = [
                    ['number' => '1000+', 'label' => 'Students', 'icon' => 'bxs-group', 'color' => 'blue'],
                    ['number' => '50+', 'label' => 'Teachers', 'icon' => 'bxs-user-detail', 'color' => 'indigo'],
                    ['number' => '30+', 'label' => 'Courses', 'icon' => 'bxs-book', 'color' => 'purple'],
                    ['number' => '95%', 'label' => 'Success Rate', 'icon' => 'bxs-badge-check', 'color' => 'green']
                ];
                @endphp

                @foreach ($stats as $stat)
                <div class="text-center group">
                    <div class="inline-block bg-{{ $stat['color'] }}-100 p-4 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="bx {{ $stat['icon'] }} text-3xl text-{{ $stat['color'] }}-600"></i>
                    </div>
                    <h4 class="text-3xl font-bold text-{{ $stat['color'] }}-600 mb-2">{{ $stat['number'] }}</h4>
                    <p class="text-gray-600">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 shadow-lg transform hover:scale-105 transition-all duration-300">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
                <p class="text-blue-100 mb-6">Join our platform and experience the future of education management</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        Login
                    </a>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="relative z-10 bg-white/50 backdrop-blur-lg border-t border-gray-200 py-8 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-600">© {{ date('Y') }} School Management System. All rights reserved.</p>
        </div>
    </footer>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
</style>
@endsection