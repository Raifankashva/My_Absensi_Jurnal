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

    <!-- Attendance Overview with enhanced visuals -->
    <div class="mb-8 transform transition-all duration-500 hover:scale-[1.01]">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100 relative">
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-blue-100 to-transparent opacity-50 rounded-bl-full"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-indigo-100 to-transparent opacity-50 rounded-tr-full"></div>
            
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-200">
                <h3 class="text-xl font-semibold text-blue-900 flex items-center">
                    <i class="bx bx-bar-chart-alt-2 mr-2 text-blue-600"></i>
                    Overview Absensi Hari Ini
                </h3>
            </div>
            <div class="p-6 relative">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                    $attendance = [
                    [
                    'title' => 'Hadir',
                    'count' => 850,
                    'percentage' => 85,
                    'color' => 'emerald',
                    'icon' => 'bx-user-check'
                    ],
                    [
                    'title' => 'Izin/Sakit',
                    'count' => 100,
                    'percentage' => 10,
                    'color' => 'yellow',
                    'icon' => 'bx-user-minus'
                    ],
                    [
                    'title' => 'Tidak Hadir',
                    'count' => 50,
                    'percentage' => 5,
                    'color' => 'rose',
                    'icon' => 'bx-user-x'
                    ]
                    ];
                    @endphp

                    @foreach($attendance as $item)
                    <div class="bg-{{ $item['color'] }}-50 rounded-xl p-6 border border-{{ $item['color'] }}-200 
                                transform transition-all duration-500 hover:scale-105 hover:shadow-lg 
                                hover:shadow-{{ $item['color'] }}-500/10 group">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center">
                                <div class="p-2 bg-{{ $item['color'] }}-100 rounded-lg mr-3 
                                          group-hover:bg-{{ $item['color'] }}-200 transition-all duration-300">
                                    <i class="bx {{ $item['icon'] }} text-xl text-{{ $item['color'] }}-600"></i>
                                </div>
                                <h4 class="text-{{ $item['color'] }}-700 font-semibold">{{ $item['title'] }}</h4>
                            </div>
                            <span class="bg-{{ $item['color'] }}-100 text-{{ $item['color'] }}-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                {{ $item['percentage'] }}%
                            </span>
                        </div>
                        <p class="text-3xl font-bold text-{{ $item['color'] }}-700 mb-4">{{ number_format($item['count']) }}</p>
                        <div class="relative pt-1">
                            <div class="overflow-hidden h-2.5 text-xs flex rounded-full bg-{{ $item['color'] }}-200">
                                <div style="width: 0%" 
                                     class="animate-[widthGrow_1.5s_ease-out_forwards] rounded-full flex flex-col text-center whitespace-nowrap text-white justify-center bg-{{ $item['color'] }}-600"
                                     data-width="{{ $item['percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Task Management and Schedule Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Task Management Section -->
        <div x-data="{ open: false }" @keydown.escape.window="open = false" @task-list-modal.window="open = true" class="relative">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100 h-full">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-blue-900 flex items-center">
                        <i class="bx bx-task mr-2 text-blue-600"></i>
                        Task Management
                    </h3>
                    <button @click="open = true"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg 
                               transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/20 
                               flex items-center">
                        <i class='bx bx-list-ul mr-1'></i>
                        View Tasks
                    </button>
                </div>
                
                <div class="p-6">
                    <!-- Task Summary -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 
                                  transform transition-all duration-300 hover:scale-105 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-blue-700">Pending Tasks</p>
                                    <p class="text-2xl font-bold text-blue-900">{{ count($tasks->where('status', 'pending')) }}</p>
                                </div>
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <i class="bx bx-time text-xl text-blue-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100 
                                  transform transition-all duration-300 hover:scale-105 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-emerald-700">Completed Tasks</p>
                                    <p class="text-2xl font-bold text-emerald-900">{{ count($tasks->where('status', 'completed')) }}</p>
                                </div>
                                <div class="p-3 bg-emerald-100 rounded-lg">
                                    <i class="bx bx-check-circle text-xl text-emerald-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Tasks -->
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Recent Tasks</h4>
                    <div class="space-y-3">
                        @foreach($tasks->take(3) as $task)
                            @php
                                $isToday = \Carbon\Carbon::parse($task->due_date)->isToday();
                                $dueDate = \Carbon\Carbon::parse($task->due_date);
                                $daysUntilDue = now()->diffInDays($dueDate, false);
                            @endphp
                            <div class="group relative rounded-xl border {{ $isToday ? 'border-blue-200 bg-blue-50' : 'border-gray-200' }} 
                                      p-4 transition-all duration-300 hover:border-blue-300 hover:shadow-md hover:scale-[1.02]">
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
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-1">{{ $task->description }}</p>
                                    
                                    <!-- Due Date -->
                                    <div class="mt-2 flex items-center gap-2">
                                        <i class="bx bx-calendar text-gray-400"></i>
                                        <span class="text-sm {{ $daysUntilDue < 0 ? 'text-red-600' : ($daysUntilDue <= 2 ? 'text-yellow-600' : 'text-gray-500') }}">
                                            Due: {{ $dueDate->format('M d, Y') }}
                                            @if($isToday)
                                                <span class="ml-2 font-medium text-blue-600">(Today)</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Task Modal -->
            <div
                x-show="open"
                class="fixed inset-0 z-50 overflow-y-auto"
                role="dialog"
                aria-modal="true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
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
                        class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity"
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
                        class="relative inline-block transform overflow-hidden rounded-xl bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">

                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <!-- Header -->
                                <div class="mb-6 border-b border-gray-200 pb-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-2xl font-semibold text-gray-900 flex items-center">
                                            <i class="bx bx-task mr-2 text-blue-600"></i>
                                            Task Management
                                        </h3>
                                        <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                                            <i class="bx bx-x text-2xl"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Manage and track your daily tasks efficiently
                                    </p>
                                </div>

                                <!-- Task List -->
                                <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-blue-100">
                                    @foreach($tasks as $task)
                                        @php
                                            $isToday = \Carbon\Carbon::parse($task->due_date)->isToday();
                                            $taskExpired = \Carbon\Carbon::parse($task->due_date)->addDays(7)->isPast();
                                            $dueDate = \Carbon\Carbon::parse($task->due_date);
                                            $daysUntilDue = now()->diffInDays($dueDate, false);
                                        @endphp

                                        @if(!$taskExpired)
                                            <div class="group relative rounded-xl border {{ $isToday ? 'border-blue-200 bg-blue-50' : 'border-gray-200' }} 
                                                      p-4 transition-all duration-300 hover:border-blue-300 hover:shadow-md">
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
                                                        <i class="bx bx-calendar text-gray-400"></i>
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
                                                        class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm 
                                                               transition-all duration-300 hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/20 
                                                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                        <i class="bx bx-edit mr-1.5"></i>
                                                        Update
                                                    </a>
                                                    <button
                                                        type="button"
                                                        class="inline-flex items-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm 
                                                               ring-1 ring-inset ring-gray-300 transition-all duration-300 hover:bg-gray-50">
                                                        <i class="bx bx-copy mr-1.5 text-gray-400"></i>
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
                                        class="inline-flex justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm 
                                               ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all duration-300">
                                        Close
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm 
                                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
                                               transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/20">
                                        <i class="bx bx-plus mr-1.5"></i>
                                        Add New Task
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100 h-full">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-blue-900 flex items-center">
                        <i class="bx bx-calendar-event mr-2 text-blue-600"></i>
                        Today's Schedule
                    </h2>
                    <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                        {{ Carbon\Carbon::now()->format('l, d M Y') }}
                    </span>
                </div>
            </div>
            
            <div class="p-6">
                @if($todaySchedules->count() > 0)
                    <div class="space-y-4">
                        @foreach($todaySchedules as $schedule)
                            @php
                                $isNow = Carbon\Carbon::parse($schedule->time)->format('H:i') == Carbon\Carbon::now()->format('H:i');
                                $isPast = Carbon\Carbon::parse($schedule->time)->isPast();
                                $statusClass = $isNow ? 'ring-2 ring-blue-500 bg-blue-50' : 
                                              ($isPast ? 'bg-gray-50 opacity-75' : 'bg-blue-50');
                            @endphp
                            <div class="flex items-center space-x-4 p-4 rounded-xl {{ $statusClass }} 
                                      transform transition-all duration-300 hover:scale-[1.02] hover:shadow-md 
                                      relative overflow-hidden group">
                                <!-- Time indicator line -->
                                <div class="absolute left-0 top-0 bottom-0 w-1 
                                          {{ $isNow ? 'bg-blue-500' : ($isPast ? 'bg-gray-300' : 'bg-blue-300') }}"></div>
                                
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 
                                          group-hover:bg-blue-200 transition-all duration-300 
                                          {{ $isNow ? 'animate-pulse' : '' }}">
                                    <i class='bx bx-time text-2xl text-blue-600'></i>
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-sm font-semibold text-gray-800 group-hover:text-blue-700 transition-colors duration-300">
                                        {{ $schedule->title }}
                                    </h3>
                                    <p class="text-sm text-gray-600">{{ Carbon\Carbon::parse($schedule->time)->format('H:i') }}</p>
                                    @if($schedule->description)
                                        <p class="text-xs text-gray-500 mt-1">{{ $schedule->description }}</p>
                                    @endif
                                </div>
                                @if($isNow)
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full animate-pulse">
                                        Now
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-calendar text-3xl text-blue-500'></i>
                        </div>
                        <p class="text-gray-500">No schedules for today</p>
                        <button class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/20">
                            <i class='bx bx-plus mr-1'></i> Add Schedule
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upcoming Schedule Section -->
    <div class="mb-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100 transform transition-all duration-500 hover:scale-[1.01]">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-blue-900 flex items-center">
                        <i class="bx bx-calendar-check mr-2 text-blue-600"></i>
                        Upcoming Schedule
                    </h2>
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center transition-all duration-300 hover:scale-105">
                        <i class='bx bx-plus mr-1'></i> Add New
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div class="space-y-6">
                    @forelse($upcomingSchedules as $day => $schedules)
                        <div class="animate-[fadeIn_0.5s_ease-in-out]">
                            <h3 class="text-sm font-medium text-gray-600 mb-3 flex items-center">
                                <i class="bx bx-calendar-alt mr-2 text-blue-500"></i>
                                {{ $day }}
                            </h3>
                            <div class="space-y-3">
                                @foreach($schedules as $schedule)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-blue-50 transition-all duration-300 hover:scale-[1.02] hover:shadow-md group">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition-all duration-300">
                                            <i class='bx bx-time text-xl text-blue-600'></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-800 group-hover:text-blue-700 transition-colors duration-300">{{ $schedule->title }}</h4>
                                            <p class="text-xs text-gray-500">{{ Carbon\Carbon::parse($schedule->time)->format('H:i') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class='bx bx-calendar text-3xl text-gray-400'></i>
                            </div>
                            <p class="text-gray-500">No upcoming schedules</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Users and Schools -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Latest Users -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100 transform transition-all duration-500 hover:scale-[1.01]">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-200 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="bx bxs-user-plus text-xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-900">Pengguna Terbaru</h3>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition-all duration-300 flex items-center hover:translate-x-1">
                    Lihat Semua
                    <i class="bx bx-right-arrow-alt ml-1"></i>
                </a>
            </div>
            <div class="divide-y divide-blue-100">
                @foreach($latestUsers->take(5) as $user)
                <div class="px-6 py-4 hover:bg-blue-50 transition-all duration-300 group">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white group-hover:scale-110 transition-all duration-300">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 group-hover:text-blue-900 transition-colors duration-300">
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

