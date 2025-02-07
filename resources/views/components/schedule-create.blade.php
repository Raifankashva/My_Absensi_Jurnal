{{-- resources/views/components/schedule-create.blade.php --}}
<div x-data="{ isOpen: false }">
    <!-- Schedule Button with Counter -->
    <button 
        @click="isOpen = true"
        class="p-3 rounded-xl bg-blue-700/50 hover:bg-blue-600/50 transition-all duration-300 text-white text-sm relative">
        <i class='bx bx-calendar mb-1'></i>
        <span class="block">Schedule</span>
    </button>

    <!-- Modal Backdrop -->
    <div 
        x-show="isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 z-40"
        style="display: none;">
    </div>

    <!-- Modal Content -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        @click.away="isOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">
        
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Create New Schedule</h3>
                    <button @click="isOpen = false" class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('schedules.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Day -->
                    <div>
                        <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Day</label>
                        <select name="day" id="day" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>

                    <!-- Time -->
                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <input type="time" name="time" id="time" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="isOpen = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Create Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>