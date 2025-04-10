@extends('layouts.app3')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        Laporan Absensi Mata Pelajaran
                    </h2>
                    <a  class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <form action="{{ route('absensi.pelajaran.report') }}" method="GET" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                            <select id="kelas_id" name="kelas_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Semua Kelas</option>
                                @foreach(\App\Models\Kelas::all() as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="jadwal_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                            <select id="jadwal_id" name="jadwal_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Semua Mata Pelajaran</option>
                                @foreach(\App\Models\JadwalPelajaran::with(['kelas'])->get() as $jadwal)
                                    <option value="{{ $jadwal->id }}" {{ $jadwalId == $jadwal->id ? 'selected' : '' }}>
                                        {{ $jadwal->mata_pelajaran }} - {{ $jadwal->kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ $tanggalMulai }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ $tanggalSelesai }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                            Filter
                        </button>
                    </div>
                </form>

                <!-- Statistik -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Statistik Absensi</h3>
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="text-2xl font-bold">{{ $statistik['total'] }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg shadow">
                            <p class="text-sm text-gray-500">Hadir</p>
                            <p class="text-2xl font-bold text-green-600">{{ $statistik['hadir'] }}</p>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg shadow">
                            <p class="text-sm text-gray-500">Terlambat</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $statistik['terlambat'] }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg shadow">
                            <p class="text-sm text-gray-500">Izin</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $statistik['izin'] }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg shadow">
                            <p class="text-sm text-gray-500">Sakit</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $statistik['sakit'] }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg shadow">
                            <p class="text-sm text-gray-500">Alpa</p>
                            <p class="text-2xl font-bold text-red-600">{{ $statistik['alpa'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mata Pelajaran
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Siswa
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($absensiList as $absensi)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ date('d M Y', strtotime($absensi->tanggal)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $absensi->jadwalPelajaran->mata_pelajaran }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $absensi->jadwalPelajaran->kelas->nama_kelas }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $absensi->siswa->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($absensi->status == 'Hadir')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Hadir
                                            </span>
                                        @elseif($absensi->status == 'Izin')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Izin
                                            </span>
                                        @elseif($absensi->status == 'Sakit')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Sakit
                                            </span>
                                        @elseif($absensi->status == 'Alpa')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Alpa
                                            </span>
                                        @elseif($absensi->status == 'Terlambat')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                Terlambat
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $absensi->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada data absensi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-between">
                    <a  class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                        Kembali ke Dashboard
                    </a>
                    <button onclick="window.print()" class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded">
                        Cetak Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Script untuk filter kelas dan mata pelajaran
    document.getElementById('kelas_id').addEventListener('change', function() {
        const kelasId = this.value;
        const jadwalDropdown = document.getElementById('jadwal_id');
        
        // Reset jadwal dropdown
        jadwalDropdown.innerHTML = '<option value="">Semua Mata Pelajaran</option>';
        
        if (kelasId) {
            // Fetch mata pelajaran based on kelas
            fetch(`/api/jadwal-by-kelas/${kelasId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(jadwal => {
                        const option = document.createElement('option');
                        option.value = jadwal.id;
                        option.textContent = `${jadwal.mata_pelajaran} - ${jadwal.hari}, ${jadwal.waktu_mulai}-${jadwal.waktu_selesai}`;
                        jadwalDropdown.appendChild(option);
                    });
                });
        }
    });
</script>

@endsection