@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-green-500 p-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <h2 class="text-2xl font-bold text-white mb-4 md:mb-0">Detail Data Siswa</h2>
                    <div class="space-x-2">
                        <a href="{{ route('adminsiswa.index') }}" 
                           class="bg-white text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-md transition duration-300 ease-in-out">
                            Kembali
                        </a>
                        <a href="{{ route('adminsiswa.edit', $dataSiswa->id) }}" 
                           class="bg-yellow-400 text-white hover:bg-yellow-500 px-4 py-2 rounded-md transition duration-300 ease-in-out">
                            Edit
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid md:grid-cols-12 gap-6">
                    <!-- Foto Profil -->
                    <div class="md:col-span-3 flex justify-center">
    <div class="w-full max-w-xs">
        <div class="bg-gray-100 rounded-lg shadow-md overflow-hidden">
            @if($dataSiswa->foto)
                <img src="{{ asset('storage/' . $dataSiswa->foto) }}" 
                     alt="Foto {{ $dataSiswa->nama_lengkap }}" 
                     class="w-full h-auto object-cover">
            @else
                <img src="{{ asset('images/default-avatar.png') }}" 
                     alt="Default Avatar" 
                     class="w-full h-auto object-cover">
            @endif
            
            <!-- QR Code Section -->
            <div class="card">
    <div class="card-header">

    </div>
    <div class="card-body text-center">
        @if(isset($qrCodeUrl))
            <img src="{{ $qrCodeUrl }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 300px;">
            <div>
                <a href="{{ route('adminsiswa.download-qr', $dataSiswa->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download QR Code
                </a>
            </div>
        @else
            <p>QR Code tidak tersedia</p>
        @endif
    </div>
</div>
        </div>
    </div>
</div>

                    <!-- Informasi Siswa -->
                    <div class="md:col-span-9">
                        <!-- Data Pribadi -->
                        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                            <h3 class="text-xl font-semibold text-blue-600 border-b pb-3 mb-4">Data Pribadi</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">NISN</span>
                                        <span class="font-medium">{{ $dataSiswa->nisn }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Nama Lengkap</span>
                                        <span class="font-medium">{{ $dataSiswa->nama_lengkap }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Jenis Kelamin</span>
                                        <span class="font-medium">{{ ucfirst($dataSiswa->jenis_kelamin) }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Email</span>
                                        <span class="font-medium">{{ $dataSiswa->user->email }}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Tempat Lahir</span>
                                        <span class="font-medium">{{ $dataSiswa->tmp_lahir }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Tanggal Lahir</span>
                                        <span class="font-medium">{{ $dataSiswa->tgl_lahir->format('d F Y') }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Agama</span>
                                        <span class="font-medium">{{ $dataSiswa->agama }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Alamat</span>
                                        <span class="font-medium">{{ $dataSiswa->user->alamat }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">No Telepon</span>
                                        <span class="font-medium">{{ $dataSiswa->user->no_hp }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Akademik -->
                        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                            <h3 class="text-xl font-semibold text-blue-600 border-b pb-3 mb-4">Data Akademik</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Sekolah</span>
                                    <span class="font-medium">{{ $dataSiswa->sekolah->nama_sekolah }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Kelas</span>
                                    <span class="font-medium">
                                        {{ $dataSiswa->kelas->nama_kelas }} (Tingkat {{ $dataSiswa->kelas->tingkat }})
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Data Orang Tua -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-blue-600 border-b pb-3 mb-4">Data Orang Tua/Wali</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Nama Ayah</span>
                                        <span class="font-medium">{{ $dataSiswa->ayah }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Pekerjaan Ayah</span>
                                        <span class="font-medium">{{ $dataSiswa->kerja_ayah ?? '-' }}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Nama Ibu</span>
                                        <span class="font-medium">{{ $dataSiswa->ibu }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Pekerjaan Ibu</span>
                                        <span class="font-medium">{{ $dataSiswa->kerja_ibu ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

