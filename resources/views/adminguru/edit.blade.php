@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Data Guru</h1>

    @if ($errors->any())
    <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('adminguru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Sekolah -->
        <div>
            <label for="sekolah_id" class="block font-medium">Sekolah</label>
            <select name="sekolah_id" id="sekolah_id"
                class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
                <option value="">Pilih Sekolah</option>
                @foreach($sekolahs as $sekolah)
                <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                    {{ $sekolah->nama_sekolah }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- NIP, NUPTK, Nama Lengkap -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="nip" class="block font-medium">NIP</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <div>
                <label for="nuptk" class="block font-medium">NUPTK</label>
                <input type="text" name="nuptk" id="nuptk" value="{{ old('nuptk') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <div>
                <label for="nama_lengkap" class="block font-medium">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>
        </div>

        <!-- Email dan Password -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="email" class="block font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <div>
                <label for="password" class="block font-medium">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>
        </div>

        <!-- Jenis Kelamin, Tempat Lahir, Tanggal Lahir -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="jenis_kelamin" class="block font-medium">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label for="tempat_lahir" class="block font-medium">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <div>
                <label for="tanggal_lahir" class="block font-medium">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>
        </div>

        <!-- NIK, Status Kepegawaian -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="nik" class="block font-medium">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <div>
                <label for="status_kepegawaian" class="block font-medium">Status Kepegawaian</label>
                <select name="status_kepegawaian" id="status_kepegawaian"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
                    <option value="PNS" {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                    <option value="PPPK" {{ old('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                    <option value="Honorer" {{ old('status_kepegawaian') == 'Honorer' ? 'selected' : '' }}>Honorer
                    </option>
                    <option value="GTY" {{ old('status_kepegawaian') == 'GTY' ? 'selected' : '' }}>GTY</option>
                    <option value="GTT" {{ old('status_kepegawaian') == 'GTT' ? 'selected' : '' }}>GTT</option>
                </select>
            </div>
        </div>

        <!-- Pendidikan Terakhir, Jurusan Pendidikan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="pendidikan_terakhir" class="block font-medium">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <div>
                <label for="jurusan_pendidikan" class="block font-medium">Jurusan Pendidikan</label>
                <input type="text" name="jurusan_pendidikan" id="jurusan_pendidikan" value="{{ old('jurusan_pendidikan') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>
        </div>

        <!-- Alamat dan No HP -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="alamat" class="block font-medium">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label for="no_hp" class="block font-medium">No HP</label>
                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>
        </div>

        <!-- TMT Kerja dan Mata Pelajaran -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="tmt_kerja" class="block font-medium">TMT Kerja</label>
                <input type="date" name="tmt_kerja" id="tmt_kerja" value="{{ old('tmt_kerja') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <div>
                <label for="mata_pelajaran" class="block font-medium">Mata Pelajaran</label>
                <select name="mata_pelajaran[]" id="mata_pelajaran" multiple
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
                    <option value="Matematika" {{ in_array('Matematika', old('mata_pelajaran', [])) ? 'selected' : '' }}>Matematika</option>
                    <option value="IPA" {{ in_array('IPA', old('mata_pelajaran', [])) ? 'selected' : '' }}>IPA</option>
                    <option value="Bahasa Indonesia" {{ in_array('Bahasa Indonesia', old('mata_pelajaran', [])) ? 'selected' : '' }}>Bahasa Indonesia</option>
                    <!-- Tambahkan mata pelajaran lainnya -->
                </select>
            </div>
        </div>

        <!-- Foto -->
        <div>
            <label for="foto" class="block font-medium">Foto</label>
            <input type="file" name="foto" id="foto"
                class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <!-- Tombol Simpan -->
        <div class="text-right">
            <button type="submit"
                class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-500">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
