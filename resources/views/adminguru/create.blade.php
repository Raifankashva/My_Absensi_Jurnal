@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Tambah Data Guru</h1>
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('adminguru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Sekolah -->
        <div>
            <label for="sekolah_id" class="block font-medium text-gray-700">Sekolah</label>
            <select id="sekolah_id" name="sekolah_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled selected>Pilih Sekolah</option>
                @foreach ($sekolahs as $sekolah)
                    <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                @endforeach
            </select>
        </div>

        <!-- NIP -->
        <div>
            <label for="nip" class="block font-medium text-gray-700">NIP</label>
            <input type="text" id="nip" name="nip" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan NIP (18 digit)" maxlength="18">
        </div>

        <!-- NUPTK -->
        <div>
            <label for="nuptk" class="block font-medium text-gray-700">NUPTK</label>
            <input type="text" id="nuptk" name="nuptk" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan NUPTK (16 digit)" maxlength="16">
        </div>

        <!-- Nama Lengkap -->
        <div>
            <label for="nama_lengkap" class="block font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <label class="block font-medium text-gray-700">Jenis Kelamin</label>
            <div class="mt-2 flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="jenis_kelamin" value="L" class="form-radio text-blue-600" required>
                    <span class="ml-2">Laki-Laki</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="jenis_kelamin" value="P" class="form-radio text-blue-600" required>
                    <span class="ml-2">Perempuan</span>
                </label>
            </div>
        </div>

        <!-- Tempat Lahir -->
        <div>
            <label for="tempat_lahir" class="block font-medium text-gray-700">Tempat Lahir</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <label for="tanggal_lahir" class="block font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- NIK -->
        <div>
            <label for="nik" class="block font-medium text-gray-700">NIK</label>
            <input type="text" id="nik" name="nik" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan NIK (16 digit)" required maxlength="16">
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block font-medium text-gray-700">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- no_hp -->
        <div>
            <label for="no_hp" class="block font-medium text-gray-700">No HP</label>
            <input type="text" id="no_hp" name="no_hp" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <!-- Status Kepegawaian -->
        <div>
            <label for="status_kepegawaian" class="block font-medium text-gray-700">Status Kepegawaian</label>
            <select id="status_kepegawaian" name="status_kepegawaian" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled selected>Pilih Status</option>
                <option value="PNS">PNS</option>
                <option value="PPPK">PPPK</option>
                <option value="Honorer">Honorer</option>
                <option value="GTY">GTY</option>
                <option value="GTT">GTT</option>
            </select>
        </div>

        <!-- Pendidikan Terakhir -->
        <div>
            <label for="pendidikan_terakhir" class="block font-medium text-gray-700">Pendidikan Terakhir</label>
            <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Jurusan Pendidikan -->
        <div>
            <label for="jurusan_pendidikan" class="block font-medium text-gray-700">Jurusan Pendidikan</label>
            <input type="text" id="jurusan_pendidikan" name="jurusan_pendidikan" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- TMT Kerja -->
        <div>
            <label for="tmt_kerja" class="block font-medium text-gray-700">TMT Kerja</label>
            <input type="date" id="tmt_kerja" name="tmt_kerja" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Mata Pelajaran -->
        <div>
            <label for="mata_pelajaran" class="block font-medium text-gray-700">Mata Pelajaran</label>
            <input type="text" id="mata_pelajaran" name="mata_pelajaran[]" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan Mata Pelajaran (Pisahkan dengan koma)" required>
        </div>

        <!-- Foto -->
        <div>
            <label for="foto" class="block font-medium text-gray-700">Foto</label>
            <input type="file" id="foto" name="foto" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
