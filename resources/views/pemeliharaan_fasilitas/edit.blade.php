@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Pemeliharaan Fasilitas</h1>
        <form action="{{ route('pemeliharaan_fasilitas.update', $pemeliharaanFasilitas->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="fasilitas_sekolah_id" class="form-label">Fasilitas Sekolah</label>
                <select name="fasilitas_sekolah_id" class="form-control" required>
                    @foreach ($fasilitasSekolah as $fasilitas)
                        <option value="{{ $fasilitas->id }}" {{ $pemeliharaanFasilitas->fasilitas_sekolah_id == $fasilitas->id ? 'selected' : '' }}>{{ $fasilitas->nama_fasilitas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_pemeliharaan" class="form-label">Tanggal Pemeliharaan</label>
                <input type="date" class="form-control" name="tanggal_pemeliharaan" value="{{ $pemeliharaanFasilitas->tanggal_pemeliharaan }}" required>
            </div>
            <div class="mb-3">
                <label for="jenis_pemeliharaan" class="form-label">Jenis Pemeliharaan</label>
                <select name="jenis_pemeliharaan" class="form-control" required>
                    <option value="Rutin" {{ $pemeliharaanFasilitas->jenis_pemeliharaan == 'Rutin' ? 'selected' : '' }}>Rutin</option>
                    <option value="Darurat" {{ $pemeliharaanFasilitas->jenis_pemeliharaan == 'Darurat' ? 'selected' : '' }}>Darurat</option>
                    <option value="Perbaikan Besar" {{ $pemeliharaanFasilitas->jenis_pemeliharaan == 'Perbaikan Besar' ? 'selected' : '' }}>Perbaikan Besar</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="Proses" {{ $pemeliharaanFasilitas->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Selesai" {{ $pemeliharaanFasilitas->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Tertunda" {{ $pemeliharaanFasilitas->status == 'Tertunda' ? 'selected' : '' }}>Tertunda</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ $pemeliharaanFasilitas->deskripsi }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
@endsection
