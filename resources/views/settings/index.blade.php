@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Pengaturan Jam Masuk Sekolah</h2>

    <form action="{{ route('settings.store') }}" method="POST">
        @csrf
        <label class="block">Pilih Sekolah:</label>
        <select name="sekolah_id" class="w-full p-2 border rounded mb-3">
            @foreach ($sekolahs as $sekolah)
                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
            @endforeach
        </select>

        <label class="block">Jam Masuk:</label>
        <input type="time" name="jam_masuk" class="w-full p-2 border rounded mb-3" required>

        <label class="block">Batas Terlambat:</label>
        <input type="time" name="batas_terlambat" class="w-full p-2 border rounded mb-3" required>

        <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Simpan</button>
    </form>
</div>
@endsection
