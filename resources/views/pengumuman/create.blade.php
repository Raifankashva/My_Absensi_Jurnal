@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Tambah Pengumuman</h1>

    <form action="{{ route('pengumuman.store') }}" method="POST" class="bg-white p-6 rounded shadow-md" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengumuman</label>
            <input type="text" name="judul" id="judul" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" value="{{ old('judul') }}" required>
            @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="isi" class="block text-sm font-medium text-gray-700">Isi Pengumuman</label>
            <textarea name="isi" id="isi" rows="5" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>{{ old('isi') }}</textarea>
            @error('isi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
            <input type="text" name="kategori" id="kategori" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" value="{{ old('kategori') }}" required>
            @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" value="{{ old('tanggal_mulai') }}" required>
            @error('tanggal_mulai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700">Tanggal Berakhir (opsional)</label>
            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" value="{{ old('tanggal_berakhir') }}">
            @error('tanggal_berakhir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="lampiran" class="block text-sm font-medium text-gray-700">Lampiran (opsional)</label>
            <input type="file" name="lampiran" id="lampiran" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md">
            @error('lampiran') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="arsip" {{ old('status') == 'arsip' ? 'selected' : '' }}>Arsip</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Simpan Pengumuman</button>
    </form>
</div>
@endsection
