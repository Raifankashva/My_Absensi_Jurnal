<!-- resources/views/components/task-modal.blade.php -->
<div x-data="{ open: false, title: '', description: '', dueDate: '', priority: 'medium' }" 
     @keydown.escape.window="open = false"
     @task-modal.window="open = true">
    
    <!-- Task Button Trigger -->
    <button @click="open = true" 
            class="p-3 rounded-xl bg-blue-700/50 hover:bg-blue-600/50 
                   transition-all duration-300 text-white text-sm">
        <i class='bx bx-plus mb-1'></i>
        <span class="block">New Task</span>
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
                            Create New Task
                        </h3>
                        
                        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Due Date</label>
            <input type="date" name="due_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Priority</label>
            <select name="priority" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <button type="button" @click="open = false"
                                class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300" >
                                    Cancel
                                </button>
                
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Create Task
        </button>
    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function submitTask() {
    fetch('/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            title: this.title,
            description: this.description,
            due_date: this.dueDate,
            priority: this.priority
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            // Show success notification
            showNotification(data.message, 'success');
            
            // Close modal
            this.open = false;
            
            // Reset form
            this.title = '';
            this.description = '';
            this.dueDate = '';
            this.priority = 'medium';
            
            // Refresh task list dynamically
            window.dispatchEvent(new CustomEvent('refresh-tasks', { detail: data.task }));
        }
    })
    .catch(error => {
        showNotification('Error creating task', 'error');
    });
}
</script>
