@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Pengaturan Absensi</h2>

    <a href="{{ route('attendance.settings.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tambah Pengaturan</a>

    <table class="w-full mt-4 border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Sekolah</th>
                <th class="border p-2">Jam Masuk</th>
                <th class="border p-2">Batas Telat</th>
                <th class="border p-2">Jam Pulang</th>
                <th class="border p-2">Hari Aktif</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Token</th>
                
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($settings as $setting)
            <tr class="border">
                <td class="border p-2">{{ $setting->sekolah->nama_sekolah }}</td>
                <td>{{ \Carbon\Carbon::parse($setting->jam_masuk)->format('H:i') }}</td>
<td>{{ \Carbon\Carbon::parse($setting->batas_telat)->format('H:i') }}</td>
<td>{{ \Carbon\Carbon::parse($setting->jam_pulang)->format('H:i') }}</td>

                <td class="border p-2">
                    {{ implode(', ', $setting->hari_aktif) }}
                </td>
                <td class="p-2 border">
                            <span class="px-2 py-1 rounded-md {{ $setting->is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ $setting->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                <td class="border p-2 font-mono text-sm">{{ $setting->token }}</td>
                <td class="border p-2">
                    <a href="{{ route('attendance.settings.edit', $setting->id) }}" class="text-blue-500 hover:underline">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
