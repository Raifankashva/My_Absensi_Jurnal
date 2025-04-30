@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">{{ $pengumuman->judul }}</h1>

    <div class="mb-4">
        <strong>Kategori:</strong> {{ $pengumuman->kategori }}
    </div>

    <div class="mb-4">
        <strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($pengumuman->tanggal_mulai)->format('d-m-Y') }}
    </div>

    <div class="mb-4">
        <strong>Status:</strong>
        <span class="px-3 py-1 rounded-full {{ $pengumuman->status == 'aktif' ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
            {{ ucfirst($pengumuman->status) }}
        </span>
    </div>

    <div class="mb-4">
        <strong>Isi Pengumuman:</strong>
        <p>{{ $pengumuman->isi }}</p>
    </div>

    @if ($pengumuman->lampiran)
        <div class="mb-4">
            <strong>Lampiran:</strong>
            <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" class="text-blue-500 hover:text-blue-700" target="_blank">Unduh Lampiran</a>
        </div>
    @endif

    <a href="{{ route('pengumuman.index') }}" class="text-blue-500 hover:text-blue-700">Kembali ke Daftar Pengumuman</a>
</div>
@endsection
