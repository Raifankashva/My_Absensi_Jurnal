@extends('layouts.app3')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        Absensi Mata Pelajaran
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
                            <p class="text-sm text-gray-600">Jadwal</p>
                            <p class="font-semibold">{{ $jadwal->hari }}, {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('absensi.pelajaran.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-700">Tanggal:</span>
                            <span class="font-medium">{{ date('d F Y', strtotime($tanggal)) }}</span>
                        </div>
                        <div>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                                Simpan Absensi
                            </button>
                        </div>
                    </div>

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
                                @forelse($siswaList as $index => $siswa)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->nis }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $siswa->nama_lengkap }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <select name="status[{{ $siswa->id }}]" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="Hadir" {{ isset($existingAbsensi[$siswa->id]) && $existingAbsensi[$siswa->id] == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                                <option value="Izin" {{ isset($existingAbsensi[$siswa->id]) && $existingAbsensi[$siswa->id] == 'Izin' ? 'selected' : '' }}>Izin</option>
                                                <option value="Sakit" {{ isset($existingAbsensi[$siswa->id]) && $existingAbsensi[$siswa->id] == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                                <option value="Alpa" {{ isset($existingAbsensi[$siswa->id]) && $existingAbsensi[$siswa->id] == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                                                <option value="Terlambat" {{ isset($existingAbsensi[$siswa->id]) && $existingAbsensi[$siswa->id] == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <input type="text" name="keterangan[{{ $siswa->id }}]" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Keterangan (opsional)">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Tidak ada data siswa
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                            Simpan Absensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection