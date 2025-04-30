@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-6 py-10 bg-white rounded-2xl shadow-md mt-10">
        <h1 class="text-2xl font-bold text-blue-700 mb-6 border-b pb-2">Tambah Pemeliharaan Fasilitas</h1>

        <form action="{{ route('pemeliharaan_fasilitas.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Fasilitas Sekolah -->
            <div>
                <label for="fasilitas_sekolah_id" class="block text-sm font-medium text-gray-700">Fasilitas Sekolah</label>
                <select name="fasilitas_sekolah_id" id="fasilitas_sekolah_id" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="" disabled selected>Pilih fasilitas</option>
                    @foreach ($fasilitasSekolah as $fasilitas)
                        <option value="{{ $fasilitas->id }}">{{ $fasilitas->nama_fasilitas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label for="tanggal_pemeliharaan" class="block text-sm font-medium text-gray-700">Tanggal Pemeliharaan</label>
                <input type="date" name="tanggal_pemeliharaan" id="tanggal_pemeliharaan" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Jenis Pemeliharaan -->
            <div>
                <label for="jenis_pemeliharaan" class="block text-sm font-medium text-gray-700">Jenis Pemeliharaan</label>
                <select name="jenis_pemeliharaan" id="jenis_pemeliharaan" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="Rutin">Rutin</option>
                    <option value="Darurat">Darurat</option>
                    <option value="Perbaikan Besar">Perbaikan Besar</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="Proses">Proses</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Tertunda">Tertunda</option>
                </select>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Masukkan deskripsi pemeliharaan..."></textarea>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
