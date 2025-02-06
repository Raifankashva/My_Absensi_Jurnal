<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Today's Attendance</h2>
                        <button onclick="document.getElementById('manualModal').classList.remove('hidden')"
                            class="bg-blue-500 text-white px-4 py-2 rounded">
                            Manual Attendance
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Entry Time
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Exit Time
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($attendances as $attendance)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $attendance->siswa->nama_lengkap }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $attendance->status === 'hadir' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $attendance->status === 'telat' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $attendance->status === 'izin' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $attendance->status === 'sakit' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $attendance->status === 'alfa' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $attendance->jam_masuk ?? '-' }}
                                        @if($attendance->foto_masuk)
                                            <a href="{{ Storage::url('attendance_photos/' . $attendance->foto_masuk) }}" 
                                               target="_blank" class="text-blue-600 hover:text-blue-800">
                                                View Photo
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $attendance->jam_pulang ?? '-' }}
                                        @if($attendance->foto_keluar)
                                            <a href="{{ Storage::url('attendance_photos/' . $attendance->foto_keluar) }}" 
                                               target="_blank" class="text-blue-600 hover:text-blue-800">
                                                View Photo
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Manual Attendance Modal -->
                    <div id="manualModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                            <div class="mt-3">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Manual Attendance</h3>
                                <form method="POST" action="{{ route('attendance.manual') }}" class="mt-4">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Student</label>
                                        <select name="siswa_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @foreach($siswa as $student)
                                                <option value="{{ $student->id }}">{{ $student->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="hadir">Hadir</option>
                                            <option value="telat">Telat</option>
                                            <option value="izin">Izin</option>
                                            <option value="sakit">Sakit</option>
                                            <option value="alfa">Alfa</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Note</label>
                                        <textarea name="keterangan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" onclick="document.getElementById('manualModal').classList.add('hidden')"
                                            class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>