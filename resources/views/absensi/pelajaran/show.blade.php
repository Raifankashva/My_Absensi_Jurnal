@extends('layouts.app3')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        Data Absensi Mata Pelajaran
                    </h2>
                    <a href="{{ route('absensi.pelajaran.jadwal-hari-ini') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Mata Pelajaran</p>
                            <p class="font-semibold">{{ $jadwal->mata_pelajaran }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kelas</p>
                            <p class="font-semibold">{{ $jadwal->kelas->nama_kelas }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Guru</p>
                            <p class="font-semibold">{{ $jadwal->guru->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal</p>
                            <p class="font-semibold">{{ date('d F Y', strtotime($tanggal)) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Siswa Hadir -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Siswa Hadir ({{ $siswaHadir->count() }})</h3>
                    
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @forelse($siswaHadir as $absensi)
                                <li class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-green-100 rounded-full">
                                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $absensi->siswa->nama_lengkap }}</div>
                                            <div class="text-sm text-gray-500">NIS: {{ $absensi->siswa->nis }}</div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="px-6 py-4 text-sm text-gray-500">
                                    Tidak ada siswa yang hadir
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Siswa Tidak Hadir / Status Lainnya -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Siswa Dengan Status Lainnya ({{ $siswaLainnya->count() }})</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NIS
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Siswa
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
                                @forelse($siswaLainnya as $index => $absensi)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $absensi->siswa->nis }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $absensi->siswa->nama_lengkap }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($absensi->status == 'Izin')
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
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Tidak ada siswa dengan status lainnya
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('absensi.pelajaran.index', ['jadwal_id' => $jadwal->id, 'tanggal' => $tanggal]) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                        Edit Absensi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection