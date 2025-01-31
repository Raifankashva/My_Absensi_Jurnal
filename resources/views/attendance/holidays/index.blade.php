@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Daftar Hari Libur</h1>
        <a href="{{ route('attendance.holidays.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Tambah Hari Libur</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full table-auto">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Sekolah</th>
                <th class="px-4 py-2 text-left">Tanggal</th>
                <th class="px-4 py-2 text-left">Keterangan</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($holidays as $holiday)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $holiday->sekolah->nama_sekolah }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($holiday->tanggal)->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $holiday->keterangan }}</td>
                    <td class="px-4 py-2">
                        <!-- Add your action buttons here -->
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                        <a href="#" class="text-red-500 hover:underline ml-2">Hapus</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
