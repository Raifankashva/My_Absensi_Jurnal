<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('attendance.public.view') }}" class="mb-6">
                        <div class="flex gap-4">
                            <input type="text" name="token" placeholder="Enter School Token" 
                                class="flex-1 rounded-md border-gray-300 shadow-sm"
                                value="{{ request('token') }}">
                            <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                View Attendance
                            </button>
                        </div>
                    </form>

                    @if($attendances ?? false)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <!-- Similar table structure as index.blade.php but without edit options -->
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>