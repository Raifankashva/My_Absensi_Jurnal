@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Edit Data Guru</h1>
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('adminguru.update', $guru->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Sekolah -->
        <div>
            <label for="sekolah_id" class="block font-medium text-gray-700">Sekolah</label>
            <select id="sekolah_id" name="sekolah_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @foreach ($sekolahs as $sekolah)
                    <option value="{{ $sekolah->id }}" {{ $guru->sekolah_id == $sekolah->id ? 'selected' : '' }}>
                        {{ $sekolah->nama_sekolah }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- NIP -->
        <div>
            <label for="nip" class="block font-medium text-gray-700">NIP</label>
            <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan NIP (18 digit)" maxlength="18">
        </div>

        <!-- NUPTK -->
        <div>
            <label for="nuptk" class="block font-medium text-gray-700">NUPTK</label>
            <input type="text" id="nuptk" name="nuptk" value="{{ old('nuptk', $guru->nuptk) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan NUPTK (16 digit)" maxlength="16">
        </div>

        <!-- Nama Lengkap -->
        <div>
            <label for="nama_lengkap" class="block font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <label class="block font-medium text-gray-700">Jenis Kelamin</label>
            <div class="mt-2 flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="jenis_kelamin" value="L" {{ $guru->jenis_kelamin == 'L' ? 'checked' : '' }} class="form-radio text-blue-600" required>
                    <span class="ml-2">Laki-Laki</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="jenis_kelamin" value="P" {{ $guru->jenis_kelamin == 'P' ? 'checked' : '' }} class="form-radio text-blue-600" required>
                    <span class="ml-2">Perempuan</span>
                </label>
            </div>
        </div>

        <!-- Tempat Lahir -->
        <div>
            <label for="tempat_lahir" class="block font-medium text-gray-700">Tempat Lahir</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $guru->tempat_lahir) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <label for="tanggal_lahir" class="block font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- NIK -->
        <div>
            <label for="nik" class="block font-medium text-gray-700">NIK</label>
            <input type="text" id="nik" name="nik" value="{{ old('nik', $guru->nik) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan NIK (16 digit)" required maxlength="16">
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block font-medium text-gray-700">Alamat</label>
            <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $guru->alamat) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- no_hp -->
        <div>
            <label for="no_hp" class="block font-medium text-gray-700">No HP</label>
            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Status Kepegawaian -->
        <div>
            <label for="status_kepegawaian" class="block font-medium text-gray-700">Status Kepegawaian</label>
            <select id="status_kepegawaian" name="status_kepegawaian" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @foreach(['PNS', 'PPPK', 'Honorer', 'GTY', 'GTT'] as $status)
                    <option value="{{ $status }}" {{ $guru->status_kepegawaian == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Pendidikan Terakhir -->
        <div>
            <label for="pendidikan_terakhir" class="block font-medium text-gray-700">Pendidikan Terakhir</label>
            <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Jurusan Pendidikan -->
        <div>
            <label for="jurusan_pendidikan" class="block font-medium text-gray-700">Jurusan Pendidikan</label>
            <input type="text" id="jurusan_pendidikan" name="jurusan_pendidikan" value="{{ old('jurusan_pendidikan', $guru->jurusan_pendidikan) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- TMT Kerja -->
        <div>
            <label for="tmt_kerja" class="block font-medium text-gray-700">TMT Kerja</label>
            <input type="date" id="tmt_kerja" name="tmt_kerja" value="{{ old('tmt_kerja', $guru->tmt_kerja) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Mata Pelajaran -->
        <div>
            <label for="mata_pelajaran" class="block font-medium text-gray-700">Mata Pelajaran</label>
            <input type="text" id="mata_pelajaran" name="mata_pelajaran[]" value="{{ implode(', ', json_decode($guru->mata_pelajaran, true) ?? []) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan Mata Pelajaran (Pisahkan dengan koma)" required>
        </div>

        <!-- Foto -->
        <div>
            <label for="foto" class="block font-medium text-gray-700">Foto</label>
            @if($guru->foto)
                <div class="mb-2">
                    <img src="{{ Storage::url('guru-photos/' . $guru->foto) }}" alt="Foto Guru" class="h-32 w-32 object-cover rounded">
                </div>
            @endif
            <input type="file" id="foto" name="foto" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Submit Button -->
        <div class="flex justify-between">
            <a href="{{ route('adminguru.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow hover:bg-gray-600">
                Kembali
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection