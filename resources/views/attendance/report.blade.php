@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Laporan Absensi</h2>

                <form action="{{ route('attendance.report') }}" method="GET" class="mb-8 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="sekolah_id" class="block text-sm font-medium text-gray-700">Sekolah</label>
                            <select name="sekolah_id" id="sekolah_id" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Sekolah</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}" @selected(request('sekolah_id') == $school->id)>
                                        {{ $school->nama_sekolah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                                   value="{{ request('tanggal_mulai') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" 
                                   value="{{ request('tanggal_akhir') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Status</option>
                                <option value="tepat_waktu" @selected(request('status') == 'tepat_waktu')>Tepat Waktu</option>
                                <option value="terlambat" @selected(request('status') == 'terlambat')>Terlambat</option>
                                <option value="alpha" @selected(request('status') == 'alpha')>Alpha</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" 
                                class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tampilkan
                        </button>

                        @if($selectedSchool)
                        <a href="{{ route('attendance.report.export', request()->all()) }}" 
                           class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Export
                        </a>
                        @endif
                    </div>
                </form>

                @if($selectedSchool)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Hasil Laporan: {{ $selectedSchool->nama_sekolah }}</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masuk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Masuk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pulang</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pulang</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($attendances as $attendance)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $attendance->tanggal->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $attendance->siswa->nama_lengkap }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $attendance->jam_masuk ? $attendance->jam_masuk->format('H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $attendance->status_masuk === 'tepat_waktu' ? 'bg-green-100 text-green-800' : 
                                                       ($attendance->status_masuk === 'terlambat' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($attendance->status_masuk) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $attendance->jam_pulang ? $attendance->jam_pulang->format('H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $attendance->status_pulang === 'normal' ? 'bg-green-100 text-green-800' : 
                                                       ($attendance->status_pulang === 'pulang_cepat' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                       {{ ucfirst($attendance->status_pulang ?? 'belum_pulang') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <a href="#" onclick="showAttendancePhotos('{{ Storage::url($attendance->foto_masuk) }}', '{{ Storage::url($attendance->foto_pulang) }}')"
                                                   class="text-indigo-600 hover:text-indigo-900">Lihat Foto</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada data absensi untuk periode yang dipilih
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $attendances->withQueryString()->links() }}
                        </div>

                        <!-- Summary Cards -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">
                                                    Tepat Waktu
                                                </dt>
                                                <dd class="text-2xl font-semibold text-gray-900">
                                                    {{ $attendances->where('status_masuk', 'tepat_waktu')->count() }}
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">
                                                    Terlambat
                                                </dt>
                                                <dd class="text-2xl font-semibold text-gray-900">
                                                    {{ $attendances->where('status_masuk', 'terlambat')->count() }}
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">
                                                    Alpha
                                                </dt>
                                                <dd class="text-2xl font-semibold text-gray-900">
                                                    {{ $attendances->where('status_masuk', 'alpha')->count() }}
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for displaying attendance photos -->
<div id="photoModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden transition-opacity" aria-hidden="true">
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="absolute right-0 top-0 pr-4 pt-4">
                    <button type="button" onclick="closePhotoModal()" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Foto Absensi</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Foto Masuk</p>
                                <img id="fotoMasuk" src="" alt="Foto Masuk" class="w-full rounded-lg">
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Foto Pulang</p>
                                <img id="fotoPulang" src="" alt="Foto Pulang" class="w-full rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showAttendancePhotos(fotoMasuk, fotoPulang) {
        document.getElementById('fotoMasuk').src = fotoMasuk || '/placeholder-image.jpg';
        document.getElementById('fotoPulang').src = fotoPulang || '/placeholder-image.jpg';
        document.getElementById('photoModal').classList.remove('hidden');
    }

    function closePhotoModal() {
        document.getElementById('photoModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('photoModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePhotoModal();
        }
    });
</script>

@endsection