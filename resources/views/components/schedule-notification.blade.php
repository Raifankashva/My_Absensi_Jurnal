{{-- resources/views/components/schedule-notification.blade.php --}}
<div class="relative">
    <button 
        x-data="{ open: false }"
        @click="open = !open"
        class="p-3 rounded-xl bg-blue-700/50 hover:bg-blue-600/50 transition-all duration-300 text-white text-sm relative">
        <i class='bx bx-calendar mb-1'></i>
        <span class="block">Schedule</span>
        
        @if($schedules->count() > 0)
            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-xs flex items-center justify-center">
                {{ $schedules->count() }}
            </span>
        @endif

        <!-- Dropdown Panel -->
        <div 
            x-show="open" 
            @click.away="open = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg z-50"
            style="display: none;">
            
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Today's Schedule</h3>
                
                @if($schedules->count() > 0)
                    <div class="space-y-3">
                        @foreach($schedules as $schedule)
                            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                                <div class="w-12 h-12 flex-shrink-0 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-time text-2xl text-blue-600'></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">{{ $schedule->title }}</h4>
                                    <p class="text-xs text-gray-600">{{ Carbon\Carbon::parse($schedule->time)->format('H:i') }}</p>
                                </div>
                                @if(Carbon\Carbon::parse($schedule->time)->format('H:i') == $currentTime)
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full ml-auto">
                                        Now
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        <i class='bx bx-calendar-x text-3xl mb-2'></i>
                        <p>No schedules for today</p>
                    </div>
                @endif
            </div>
        </div>
    </button>
</div>