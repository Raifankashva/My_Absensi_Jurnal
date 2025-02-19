@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6 md:p-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Detail Guru</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profil Foto Guru -->
        <div class="flex flex-col items-center bg-gray-100 p-6 rounded-lg shadow">
            <img src="{{ $guru->foto ? asset('guru-photos/' . $guru->foto) : asset('images/default-profile.png') }}" 
                 class="w-40 h-40 rounded-full border-4 border-blue-500 shadow-lg mb-4" 
                 alt="Foto Guru">
            <h3 class="text-xl font-semibold text-gray-800">{{ $guru->nama_lengkap }}</h3>
            <p class="text-gray-600 text-sm">{{ optional($guru->sekolah)->nama_sekolah ?? 'Sekolah Tidak Diketahui' }}</p>
        </div>

        <!-- Informasi Guru -->
        <div class="md:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Informasi Pribadi</h4>
                    <p class="text-gray-600"><strong>NIP:</strong> {{ $guru->nip ?? '-' }}</p>
                    <p class="text-gray-600"><strong>NUPTK:</strong> {{ $guru->nuptk ?? '-' }}</p>
                    <p class="text-gray-600"><strong>Jenis Kelamin:</strong> {{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    <p class="text-gray-600"><strong>TTL:</strong> {{ $guru->tempat_lahir }}, {{ $guru->tanggal_lahir }}</p>
                    <p class="text-gray-600"><strong>Status Kepegawaian:</strong> {{ $guru->status_kepegawaian }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Pendidikan & Pekerjaan</h4>
                    <p class="text-gray-600"><strong>Pendidikan Terakhir:</strong> {{ $guru->pendidikan_terakhir }}</p>
                    <p class="text-gray-600"><strong>Jurusan:</strong> {{ $guru->jurusan_pendidikan }}</p>
                    <p class="text-gray-600"><strong>TMT Kerja:</strong> {{ $guru->tmt_kerja }}</p>
                    <p class="text-gray-600"><strong>Mata Pelajaran:</strong> {{  $guru->mata_pelajaran }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Kontak & Alamat</h4>
                    <p class="text-gray-600"><strong>Email:</strong> {{ $guru->user->email }}</p>
                    <p class="text-gray-600"><strong>No HP:</strong> {{ $guru->no_hp }}</p>
                    <p class="text-gray-600"><strong>Alamat:</strong> {{ $guru->alamat }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Sekolah</h4>
                    <p class="text-gray-600"><strong>Nama Sekolah:</strong> {{ optional($guru->sekolah)->nama_sekolah ?? 'Tidak Diketahui' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-between mt-6">
        <a href="{{ route('adminguru.index') }}" 
           class="px-6 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-lg shadow-md transition duration-300 ease-in-out">
            Kembali
        </a>
        <a href="{{ route('adminguru.edit', $guru->id) }}" 
           class="px-6 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-lg shadow-md transition duration-300 ease-in-out">
            Edit Guru
        </a>
    </div>
</div>
@endsection
