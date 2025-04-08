@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Absensi Kelas</h1>
        </div>

        {{-- Filter Form --}}
        <form action="{{ route('absensi-kelas.laporan') }}" method="GET" class="p-6 bg-gray-50 border-b">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ $tanggalSelesai }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select name="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        {{-- Statistik Keseluruhan --}}
        <div class="p-6 bg-gray-100 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-medium text-gray-500">Total Kelas</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $statistik['total_kelas'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-medium text-gray-500">Total Siswa</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $statistik['total_siswa'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-medium text-gray-500">Total Hadir</h3>
                <p class="text-2xl font-bold text-green-600">{{ $statistik['total_hadir'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-medium text-gray-500">Persentase Kehadiran</h3>
                <p class="text-2xl font-bold text-blue-600">
                    {{ number_format($statistik['persentase_kehadiran'], 2) }}%
                </p>
            </div>
        </div>

        {{-- Tabel Absensi Kelas --}}
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tidak Hadir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($absensiKelas as $absensi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->tanggal->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->kelas->nama_kelas }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->jadwalPelajaran->mata_pelajaran }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->total_siswa }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-green-600">
                            {{ $absensi->siswa_hadir }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-red-600">
                            {{ $absensi->siswa_tidak_hadir }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="
                                px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($absensi->status_kelas == 'Terlaksana') bg-green-100 text-green-800 
                                @elseif($absensi->status_kelas == 'Diganti') bg-yellow-100 text-yellow-800 
                                @else bg-red-100 text-red-800 
                                @endif
                            ">
                                {{ $absensi->status_kelas }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-6">
            {{ $absensiKelas->links() }}
        </div>
    </div>
</div>
@endsection