@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Pemeliharaan Fasilitas</h1>

        <div class="card mt-4">
            <div class="card-header">
                <h4>{{ $pemeliharaanFasilitas->fasilitasSekolah->nama_fasilitas }}</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Tanggal Pemeliharaan:</strong>
                    <p>{{ \Carbon\Carbon::parse($pemeliharaanFasilitas->tanggal_pemeliharaan)->format('d M Y') }}</p>
                </div>

                <div class="mb-3">
                    <strong>Jenis Pemeliharaan:</strong>
                    <p>{{ $pemeliharaanFasilitas->jenis_pemeliharaan }}</p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p>{{ $pemeliharaanFasilitas->status }}</p>
                </div>

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <p>{{ $pemeliharaanFasilitas->deskripsi ? $pemeliharaanFasilitas->deskripsi : 'Tidak ada deskripsi' }}</p>
                </div>

                <a href="{{ route('pemeliharaan_fasilitas.index') }}" class="btn btn-secondary">Kembali ke Daftar Pemeliharaan</a>
            </div>
        </div>
    </div>
@endsection
