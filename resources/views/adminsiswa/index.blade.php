@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Data Siswa {{ $sekolah->nama_sekolah }}</h1>
            <a href="{{ route('adminsiswa.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Tambah Siswa
            </a>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Filter Form -->
        <div class="bg-white shadow rounded-lg mb-6 p-4">
            <form action="{{ route('adminsiswa.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="w-full md:w-auto">
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Filter Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Semua Kelas</option>
                        @foreach($allKelas as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- QR Code Bulk Download Form -->
        <form action="{{ route('adminsiswa.download-qrcodes') }}" method="POST" id="qrCodeForm">
            @csrf
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <div class="flex items-center">
                        <input id="select-all" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="select-all" class="ml-2 text-sm text-gray-700">Pilih Semua</label>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50" id="download-selected" disabled>
                        Download QR Code Terpilih
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pilih
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Foto
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    NISN
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Lengkap
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    QR Code
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($dataSiswa as $siswa)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_students[]" value="{{ $siswa->id }}" class="student-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($siswa->foto)
                                            <img src="{{ Storage::url($siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}" class="h-12 w-12 rounded-full object-cover">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $siswa->nisn }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $siswa->nama_lengkap }}</div>
                                        <div class="text-sm text-gray-500">{{ $siswa->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $siswa->kelas->nama_kelas ?? 'Belum ada kelas' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(isset($qrCodeUrls[$siswa->id]))
                                            <img src="{{ $qrCodeUrls[$siswa->id] }}" alt="QR Code {{ $siswa->nama_lengkap }}" class="h-16 w-16">
                                            <a href="{{ route('adminsiswa.download-qrcode', $siswa->id) }}" class="text-xs text-blue-600 hover:text-blue-800">Download</a>
                                        @else
                                            <span class="text-xs text-gray-500">QR Code tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('adminsiswa.edit', $siswa->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <a href="{{ route('adminsiswa.show', $siswa->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                            <form action="{{ route('adminsiswa.destroy', $siswa->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data siswa
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                    {{ $dataSiswa->links() }}
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        const downloadButton = document.getElementById('download-selected');
        
        // Function to update download button state
        function updateDownloadButtonState() {
            const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
            downloadButton.disabled = checkedCount === 0;
        }
        
        // Select/Deselect all functionality
        selectAllCheckbox.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateDownloadButtonState();
        });
        
        // Individual checkbox change listener
        studentCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Update "select all" checkbox state
                const allChecked = document.querySelectorAll('.student-checkbox:checked').length === studentCheckboxes.length;
                selectAllCheckbox.checked = allChecked;
                
                updateDownloadButtonState();
            });
        });
        
        // Initial button state
        updateDownloadButtonState();
    });
</script>

@endsection

