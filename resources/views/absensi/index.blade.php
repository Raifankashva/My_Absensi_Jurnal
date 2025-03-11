@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            '50': '#f0f9ff',
                            '100': '#e0f2fe',
                            '200': '#bae6fd',
                            '300': '#7dd3fc',
                            '400': '#38bdf8',
                            '500': '#0ea5e9',
                            '600': '#0284c7',
                            '700': '#0369a1',
                            '800': '#075985',
                            '900': '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="p-6 bg-gradient-to-r from-primary-700 to-primary-900 text-white border-b border-primary-800">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-2xl font-bold mb-1">Data Absensi</h1>
                        <p class="text-primary-100 text-sm">Monitoring kehadiran siswa secara real-time</p>
                    </div>
                    <a href="{{ route('absensi.scan') }}" class="mt-4 md:mt-0 bg-white text-primary-800 hover:bg-primary-50 font-medium py-2 px-4 rounded-lg flex items-center transition duration-200 shadow-md">
                        <i class="fas fa-qrcode mr-2"></i>
                        Scan QR Code
                    </a>
                </div>
            </div>

            <div class="p-6">
                <!-- Alerts -->
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md mb-6 flex items-center" role="alert">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md mb-6 flex items-center" role="alert">
                        <i class="fas fa-exclamation-circle mr-2 text-red-500"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg shadow p-4 border border-blue-100">
                        <div class="flex items-center">
                            <div class="bg-blue-500 rounded-full p-3 mr-4">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-blue-600 font-medium">Total Hadir</p>
                                <p class="text-2xl font-bold text-blue-800">{{ $absensi->where('status', 'Hadir')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg shadow p-4 border border-yellow-100">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 rounded-full p-3 mr-4">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-yellow-600 font-medium">Terlambat</p>
                                <p class="text-2xl font-bold text-yellow-800">{{ $absensi->where('status', 'Terlambat')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-red-50 rounded-lg shadow p-4 border border-red-100">
                        <div class="flex items-center">
                            <div class="bg-red-500 rounded-full p-3 mr-4">
                                <i class="fas fa-user-slash text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-red-600 font-medium">Tidak Hadir</p>
                                <p class="text-2xl font-bold text-red-800">{{ $absensi->where('status', 'Tidak Hadir')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Form -->
                <div class="bg-gray-50 rounded-lg shadow-md p-5 mb-6 border border-gray-200">
                    <form action="{{ route('absensi.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="sekolah_id" class="block text-sm font-medium text-gray-700 mb-1">Sekolah</label>
                                <select id="sekolah_id" name="sekolah_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 shadow-sm">
                                    <option value="">Semua Sekolah</option>
                                    @foreach($sekolah as $s)
                                        <option value="{{ $s->id }}" {{ $sekolah_id == $s->id ? 'selected' : '' }}>{{ $s->nama_sekolah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                <select id="kelas_id" name="kelas_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 shadow-sm" {{ empty($sekolah_id) ? 'disabled' : '' }}>
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ $kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 shadow-sm">
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 shadow-md flex items-center">
                                    <i class="fas fa-filter mr-2"></i> Filter
                                </button>
                                <a href="{{ route('absensi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 shadow-md flex items-center">
                                    <i class="fas fa-redo-alt mr-2"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Export Buttons -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <a href="" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 shadow-md flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Export PDF
                    </a>
                    <a href="" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 shadow-md flex items-center">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export Excel
                    </a>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Scan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($absensi as $key => $item)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $absensi->firstItem() + $key }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->siswa->nisn }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->siswa->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->siswa->sekolah->nama_sekolah ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->waktu_scan)->format('d-m-Y H:i:s') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->status == 'Hadir')
                                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i> Hadir
                                                </span>
                                            @elseif($item->status == 'Terlambat')
                                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i> Terlambat
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i> Tidak Hadir
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                                                <p class="text-lg font-medium">Tidak ada data absensi</p>
                                                <p class="text-sm text-gray-400">Silakan sesuaikan filter atau coba lagi nanti</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile List View -->
                <div class="md:hidden space-y-4">
                    @forelse($absensi as $key => $item)
                        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden transition duration-200 hover:shadow-lg">
                            <div class="p-4 cursor-pointer flex justify-between items-center" onclick="toggleDetails('details-{{ $item->id }}')">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->siswa->nama }}</p>
                                    <p class="text-sm text-gray-500">NISN: {{ $item->siswa->nisn }}</p>
                                </div>
                                <div class="flex items-center">
                                    @if($item->status == 'Hadir')
                                        <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mr-2">
                                            <i class="fas fa-check-circle mr-1"></i> Hadir
                                        </span>
                                    @elseif($item->status == 'Terlambat')
                                        <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 mr-2">
                                            <i class="fas fa-clock mr-1"></i> Terlambat
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 mr-2">
                                            <i class="fas fa-times-circle mr-1"></i> Tidak
                                        </span>
                                    @endif
                                    <i id="icon-{{ $item->id }}" class="fas fa-chevron-down text-gray-400 transition-transform duration-200"></i>
                                </div>
                            </div>
                            <div id="details-{{ $item->id }}" class="hidden px-4 py-3 bg-gray-50 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Sekolah</p>
                                        <p class="text-sm font-medium">{{ $item->siswa->sekolah->nama_sekolah ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Kelas</p>
                                        <p class="text-sm font-medium">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-xs text-gray-500">Waktu Scan</p>
                                        <p class="text-sm font-medium">
                                            <i class="far fa-calendar-alt mr-1 text-primary-600"></i>
                                            {{ \Carbon\Carbon::parse($item->waktu_scan)->format('d-m-Y') }}
                                            <i class="far fa-clock ml-2 mr-1 text-primary-600"></i>
                                            {{ \Carbon\Carbon::parse($item->waktu_scan)->format('H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                                <p class="text-lg font-medium text-gray-700">Tidak ada data absensi</p>
                                <p class="text-sm text-gray-400 mt-1">Silakan sesuaikan filter atau coba lagi nanti</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $absensi->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        
    </div>

    <script>
        function toggleDetails(id) {
            const element = document.getElementById(id);
            const iconId = id.replace('details', 'icon');
            const icon = document.getElementById(iconId);
            
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                element.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Function to handle school selection change
        document.addEventListener('DOMContentLoaded', function() {
            const sekolahSelect = document.getElementById('sekolah_id');
            const kelasSelect = document.getElementById('kelas_id');
            
            sekolahSelect.addEventListener('change', function() {
                if (this.value === '') {
                    kelasSelect.disabled = true;
                    kelasSelect.value = '';
                } else {
                    kelasSelect.disabled = false;
                }
                this.form.submit();
            });
            
            document.getElementById('tanggal').addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
</body>
</html>
@endsection