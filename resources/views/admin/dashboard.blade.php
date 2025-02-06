@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-600 p-3 rounded-lg">
                    <i class="bx bxs-dashboard text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-blue-900">Admin Dashboard</h1>
                    <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 bg-white px-6 py-3 rounded-xl shadow-sm border border-blue-100">
                <div class="flex items-center space-x-2">
                    <i class="bx bx-calendar text-blue-600"></i>
                    <span class="text-sm text-gray-600">{{ now()->format('d M Y') }}</span>
                </div>
                <div class="w-px h-4 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <i class="bx bx-time text-blue-600"></i>
                    <span class="text-sm text-gray-600">{{ now()->format('H:i') }}</span>
                </div>
                <div class="w-px h-4 bg-gray-300"></div>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                    Admin Panel
                </span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @php
            $cards = [
            [
            'color' => 'blue',
            'gradient' => 'from-blue-600 to-blue-400',
            'icon' => 'bxs-school',
            'title' => 'Total Sekolah',
            'count' => $totalSekolah,
            'trend' => '+2.5%',
            'trend_text' => 'dari bulan lalu'
            ],
            [
            'color' => 'emerald',
            'gradient' => 'from-emerald-600 to-emerald-400',
            'icon' => 'bxs-user-detail',
            'title' => 'Total Guru',
            'count' => $totalGuru,
            'trend' => '+3.2%',
            'trend_text' => 'dari bulan lalu'
            ],
            [
            'color' => 'purple',
            'gradient' => 'from-purple-600 to-purple-400',
            'icon' => 'bxs-group',
            'title' => 'Total Siswa',
            'count' => $totalSiswa,
            'trend' => '+5.1%',
            'trend_text' => 'dari bulan lalu'
            ],
            [
            'color' => 'rose',
            'gradient' => 'from-rose-600 to-rose-400',
            'icon' => 'bxs-user-pin',
            'title' => 'Total Pengguna',
            'count' => $latestUsers->count(),
            'trend' => '+1.8%',
            'trend_text' => 'dari bulan lalu'
            ]
            ];
            @endphp

            @foreach($cards as $card)
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r {{ $card['gradient'] }} rounded-xl transform transition-all duration-300 group-hover:scale-105 group-hover:rotate-1"></div>
                <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 group-hover:-translate-y-1 group-hover:-translate-x-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">{{ $card['title'] }}</h3>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($card['count']) }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-emerald-500 text-sm font-medium">{{ $card['trend'] }}</span>
                                    <span class="text-gray-500 text-xs ml-1">{{ $card['trend_text'] }}</span>
                                </div>
                            </div>
                            <div class="bg-{{ $card['color'] }}-100 rounded-lg p-3">
                                <i class="bx {{ $card['icon'] }} text-2xl text-{{ $card['color'] }}-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Attendance Overview -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-200">
                    <h3 class="text-xl font-semibold text-blue-900">Overview Absensi Hari Ini</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                        $attendance = [
                        [
                        'title' => 'Hadir',
                        'count' => 850,
                        'percentage' => 85,
                        'color' => 'emerald'
                        ],
                        [
                        'title' => 'Izin/Sakit',
                        'count' => 100,
                        'percentage' => 10,
                        'color' => 'yellow'
                        ],
                        [
                        'title' => 'Tidak Hadir',
                        'count' => 50,
                        'percentage' => 5,
                        'color' => 'rose'
                        ]
                        ];
                        @endphp

                        @foreach($attendance as $item)
                        <div class="bg-{{ $item['color'] }}-50 rounded-lg p-6 border border-{{ $item['color'] }}-200 transform transition-all duration-300 hover:scale-105">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-{{ $item['color'] }}-700 font-semibold">{{ $item['title'] }}</h4>
                                <span class="bg-{{ $item['color'] }}-100 text-{{ $item['color'] }}-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $item['percentage'] }}%
                                </span>
                            </div>
                            <p class="text-3xl font-bold text-{{ $item['color'] }}-700">{{ number_format($item['count']) }}</p>
                            <div class="mt-4 bg-{{ $item['color'] }}-200 rounded-full h-2.5">
                                <div class="bg-{{ $item['color'] }}-600 h-2.5 rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- resources/views/components/task-modal.blade.php -->

        <div x-data="{ open: false }" @keydown.escape.window="open = false" @task-list-modal.window="open = true">
            <!-- Task List Button Trigger -->
            <button @click="open = true"
                class="p-3 rounded-xl bg-green-700/50 hover:bg-green-600/50 
                   transition-all duration-300 text-white text-sm">
                <i class='bx bx-list-ul mb-1'></i>
                <span class="block">View Tasks</span>
            </button>

            <!-- Modal -->
            <div
    x-show="open"
    class="fixed inset-0 z-50 overflow-y-auto"
    role="dialog"
    aria-modal="true">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
            aria-hidden="true">
        </div>

        <!-- Modal panel -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">

            <div class="sm:flex sm:items-start">
                <div class="w-full">
                    <!-- Header -->
                    <div class="mb-6 border-b border-gray-200 pb-4">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            Task Management
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage and track your daily tasks efficiently
                        </p>
                    </div>

                    <!-- Task List -->
                    <div class="space-y-4">
                        @foreach($tasks as $task)
                            @php
                                $isToday = \Carbon\Carbon::parse($task->due_date)->isToday();
                                $taskExpired = \Carbon\Carbon::parse($task->due_date)->addDays(7)->isPast();
                                $dueDate = \Carbon\Carbon::parse($task->due_date);
                                $daysUntilDue = now()->diffInDays($dueDate, false);
                            @endphp

                            @if(!$taskExpired)
                                <div class="group relative rounded-xl border {{ $isToday ? 'border-blue-200 bg-blue-50' : 'border-gray-200' }} p-4 transition-all hover:border-blue-300 hover:shadow-md">
                                    <!-- Priority Badge -->
                                    <div class="absolute right-4 top-4">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ 
                                            $task->priority == 'high' ? 'bg-red-100 text-red-800' : 
                                            ($task->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') 
                                        }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>

                                    <!-- Task Content -->
                                    <div class="pr-16">
                                        <h4 class="font-semibold text-gray-900">{{ $task->title }}</h4>
                                        <p class="mt-1 text-sm text-gray-600">{{ $task->description }}</p>
                                        
                                        <!-- Due Date -->
                                        <div class="mt-2 flex items-center gap-2">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm {{ $daysUntilDue < 0 ? 'text-red-600' : ($daysUntilDue <= 2 ? 'text-yellow-600' : 'text-gray-500') }}">
                                                Due: {{ $dueDate->format('M d, Y') }}
                                                @if($isToday)
                                                    <span class="ml-2 font-medium text-blue-600">(Today)</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="mt-4 flex items-center gap-2">
                                        <a
                                            href="{{ route('tasks.edit', $task->id) }}"
                                            class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Update
                                        </a>
                                        <button
                                            type="button"
                                            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-colors hover:bg-gray-50">
                                            <svg class="mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Footer -->
                    <div class="mt-6 flex justify-end gap-3">
                        <button
                            @click="open = false"
                            type="button"
                            class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Close
                        </button>
                        <button
                            type="button"
                            class="inline-flex justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Add New Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Latest Users and Schools -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Latest Users -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="bx bxs-user-plus text-2xl text-blue-600"></i>
                        <h3 class="text-xl font-semibold text-blue-900">Pengguna Terbaru</h3>
                    </div>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition flex items-center">
                        Lihat Semua
                        <i class="bx bx-right-arrow-alt ml-1"></i>
                    </a>
                </div>
                <div class="divide-y divide-blue-100">
                    @foreach($latestUsers->take(5) as $user)
                    <div class="px-6 py-4 hover:bg-blue-50 transition-all duration-200 group">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="bx bxs-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 group-hover:text-blue-900 transition">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Schools List -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="bx bxs-graduation text-2xl text-blue-600"></i>
                        <h3 class="text-xl font-semibold text-blue-900">Daftar Sekolah</h3>
                    </div>
                    <a href="{{ route('sekolahs.index') }}" class="text-sm text-blue-600 hover:text-blue-800 transition flex items-center">
                        Lihat Semua
                        <i class="bx bx-right-arrow-alt ml-1"></i>
                    </a>
                </div>
                <div class="divide-y divide-blue-100">
                    @foreach($sekolah->take(5) as $s)
                    <div class="px-6 py-4 hover:bg-blue-50 transition-all duration-200 group">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="bx bxs-school text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 group-hover:text-blue-900 transition">
                                        {{ $s->nama_sekolah }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $s->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
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
</div>
@endsection