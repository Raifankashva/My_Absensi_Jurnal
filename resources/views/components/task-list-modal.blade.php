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
    <div x-show="open" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Task List
                        </h3>
                        
                        <ul class="mt-4 space-y-3">
                            @foreach($tasks as $task)
                                <li class="p-4 border rounded-lg shadow-sm">
                                    <h4 class="font-bold text-gray-900">{{ $task->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                                    <p class="text-xs text-gray-500">Due: {{ $task->due_date }}</p>
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $task->priority == 'high' ? 'bg-red-500 text-white' : ($task->priority == 'medium' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        <button @click="open = false" class="w-full mt-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
