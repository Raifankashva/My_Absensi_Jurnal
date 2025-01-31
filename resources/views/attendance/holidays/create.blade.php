@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Tambah Hari Libur</h1>

    <form action="{{ route('attendance.holidays.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="sekolah_id" class="block text-sm font-medium text-gray-700">Sekolah</label>
            <select id="sekolah_id" name="sekolah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Pilih Sekolah</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}" {{ old('sekolah_id') == $school->id ? 'selected' : '' }}>{{ $school->nama_sekolah }}</option>
                @endforeach
            </select>
            @error('sekolah_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('tanggal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
