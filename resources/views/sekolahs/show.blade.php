@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-blue-600 text-white px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $sekolah->nama_sekolah }}</h2>
                        <p class="text-blue-100 text-sm mt-1">Detail Informasi Sekolah</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="bg-blue-500 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $sekolah->jenjang }}
                        </span>
                        <span class="bg-blue-500 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $sekolah->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-blue-800 font-semibold mb-2">Identitas Sekolah</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">NPSN</span>
                                    <span class="text-gray-800">{{ $sekolah->npsn }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Akreditasi</span>
                                    <span class="text-gray-800">{{ $sekolah->akreditasi ?? 'Tidak ada' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-blue-800 font-semibold mb-2">Kontak</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Telepon</span>
                                    <span class="text-gray-800">{{ $sekolah->no_telp }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Email</span>
                                    <span class="text-gray-800">{{ $sekolah->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Website</span>
                                    <span class="text-gray-800">{{ $sekolah->website ?? 'Tidak ada' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-blue-800 font-semibold mb-2">Lokasi</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Alamat</span>
                                    <span class="text-gray-800 text-right">{{ $sekolah->alamat }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Kelurahan</span>
                                    <span class="text-gray-800">{{ $sekolah->village->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Kecamatan</span>
                                    <span class="text-gray-800">{{ $sekolah->district->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Kota</span>
                                    <span class="text-gray-800">{{ $sekolah->city->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Provinsi</span>
                                    <span class="text-gray-800">{{ $sekolah->province->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Kode Pos</span>
                                    <span class="text-gray-800">{{ $sekolah->kode_pos }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-blue-800 font-semibold mb-2">Kepala Sekolah</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">Nama</span>
                                    <span class="text-gray-800">{{ $sekolah->kepala_sekolah }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600 font-medium">NIP</span>
                                    <span class="text-gray-800">{{ $sekolah->nip_kepala_sekolah ?? 'Tidak ada' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-blue-50 px-6 py-4 flex justify-end space-x-3">
                <a href="{{ route('sekolahs.edit', $sekolah) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300">
                    Edit Informasi
                </a>
                <a href="{{ route('sekolahs.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection