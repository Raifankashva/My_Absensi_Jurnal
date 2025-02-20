@extends('layouts.app')

@section('content')
<div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Siswa
            </h2>

            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Profile Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $user->dataSiswa->foto) }}" alt="Foto {{ $user->dataSiswa->nama_lengkap }}" class="w-12 h-12 rounded-full">
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $user->dataSiswa->nama_lengkap }}</h3>
                                <p class="text-sm text-gray-500">NISN: {{ $user->dataSiswa->nisn }}</p>
                                <p class="text-sm text-gray-500">Kelas: {{ $user->dataSiswa->kelas->nama_kelas }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- School Info Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Sekolah</h3>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Sekolah:</span> 
                                {{ $user->dataSiswa->sekolah->nama_sekolah }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Alamat:</span>
                                {{ $user->dataSiswa->sekolah->alamat }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Personal Info Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pribadi</h3>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">TTL:</span>
                                {{ $user->dataSiswa->tmp_lahir }}, {{ $user->dataSiswa->tgl_lahir }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Jenis Kelamin:</span>
                                {{ $user->dataSiswa->jenis_kelamin }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Agama:</span>
                                {{ $user->dataSiswa->agama }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information Section -->
            <div class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-2">
                <!-- Parent Information -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Orang Tua</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700">Ayah</h4>
                                <p class="text-sm text-gray-600">Nama: {{ $user->dataSiswa->ayah }}</p>
                                <p class="text-sm text-gray-600">Pekerjaan: {{ $user->dataSiswa->kerja_ayah ?? '-' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700">Ibu</h4>
                                <p class="text-sm text-gray-600">Nama: {{ $user->dataSiswa->ibu }}</p>
                                <p class="text-sm text-gray-600">Pekerjaan: {{ $user->dataSiswa->kerja_ibu ?? '-' }}</p>
                            </div>
                            @if($user->dataSiswa->wali)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700">Wali</h4>
                                <p class="text-sm text-gray-600">Nama: {{ $user->dataSiswa->wali }}</p>
                                <p class="text-sm text-gray-600">Pekerjaan: {{ $user->dataSiswa->kerja_wali ?? '-' }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700">Data Fisik</h4>
                                <p class="text-sm text-gray-600">Tinggi: {{ $user->dataSiswa->tb ?? '-' }} cm</p>
                                <p class="text-sm text-gray-600">Berat: {{ $user->dataSiswa->bb ?? '-' }} kg</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700">Program Bantuan</h4>
                                <p class="text-sm text-gray-600">KKS: {{ $user->dataSiswa->kks ?? '-' }}</p>
                                <p class="text-sm text-gray-600">KPH: {{ $user->dataSiswa->kph ?? '-' }}</p>
                                <p class="text-sm text-gray-600">KIP: {{ $user->dataSiswa->kip ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection