@extends('layouts.app3')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        Jadwal Pelajaran Hari {{ $hari }} ({{ date('d F Y', strtotime($tanggal)) }})
                    </h2>
                    <div>
                        <a  class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam Pelajaran
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mata Pelajaran
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Guru
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status Absensi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($jadwalList as $jadwal)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $jadwal->kelas->nama_kelas }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $jadwal->mata_pelajaran }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $jadwal->guru->nama_lengkap }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $absensiCount = \App\Models\AbsensiPelajaran::where('jadwal_pelajaran_id', $jadwal->id)
                                                ->where('tanggal', $tanggal)
                                                ->count();
                                                
                                            $siswaCount = \App\Models\DataSiswa::where('kelas_id', $jadwal->kelas_id)
                                                ->where('nama_lengkap', true)
                                                ->count();
                                        @endphp
                                        
                                        @if($absensiCount > 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Sudah diisi ({{ $absensiCount }}/{{ $siswaCount }})
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Belum diisi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('absensi.pelajaran.index', ['jadwal_id' => $jadwal->id, 'tanggal' => $tanggal]) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-sm">
                                                Isi Absensi
                                            </a>
                                            <a href="{{ route('absensi.pelajaran.show', ['jadwal_id' => $jadwal->id, 'tanggal' => $tanggal]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1 px-3 rounded text-sm">
                                                Lihat Absensi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada jadwal pelajaran hari ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection