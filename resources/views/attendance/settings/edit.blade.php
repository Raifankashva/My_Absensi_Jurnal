@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Edit Pengaturan Absensi</h2>
    @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('attendance.settings.update', $setting->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold">Sekolah</label>
                <select name="sekolah_id" class="w-full border p-2 rounded-md">
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ $setting->sekolah_id == $school->id ? 'selected' : '' }}>{{ $school->nama_sekolah }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="block font-semibold">Jam Masuk</label>
                    <input type="time" name="jam_masuk" value="{{ $setting->jam_masuk }}" class="w-full border p-2 rounded-md">
                </div>
                <div>
                    <label class="block font-semibold">Batas Telat</label>
                    <input type="time" name="batas_telat" value="{{ $setting->batas_telat }}" class="w-full border p-2 rounded-md">
                </div>
                <div>
                    <label class="block font-semibold">Jam Pulang</label>
                    <input type="time" name="jam_pulang" value="{{ $setting->jam_pulang }}" class="w-full border p-2 rounded-md">
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Hari Aktif</label>
                <div class="grid grid-cols-7 gap-2">
                    @foreach(['Ming', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $index => $day)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="hari_aktif[]" value="{{ $index + 1 }}" 
                                {{ in_array($index + 1, $setting->hari_aktif) ? 'checked' : '' }}>
                            <span>{{ $day }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Status</label>
                <input type="checkbox" name="is_active" value="1" {{ $setting->is_active ? 'checked' : '' }}>
                <span>Aktif</span>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Update
            </button>
        </form>
    </div>
</div>
@endsection
