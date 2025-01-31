@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Tambah Pengaturan Absensi</h2>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('attendance.settings.store') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-4">
                <label class="block font-semibold">Sekolah</label>
                <select name="sekolah_id" class="w-full border p-2 rounded-md">
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->nama_sekolah }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="block font-semibold">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="w-full border p-2 rounded-md">
                </div>
                <div>
                    <label class="block font-semibold">Batas Telat</label>
                    <input type="time" name="batas_telat" class="w-full border p-2 rounded-md">
                </div>
                <div>
                    <label class="block font-semibold">Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="w-full border p-2 rounded-md">
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Hari Aktif</label>
                <div class="grid grid-cols-7 gap-2">
                    @foreach(['Ming', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $index => $day)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="hari_aktif[]" value="{{ $index + 1 }}">
                            <span>{{ $day }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection
