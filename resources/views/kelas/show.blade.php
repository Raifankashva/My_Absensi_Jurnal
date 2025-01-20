@extends('layouts.app')

@section('content')
<div class="p-6 bg-white border-b border-gray-200">
    <h1 class="text-2xl font-bold mb-6">Detail Kelas</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Nama Kelas: {{ $kelas->nama_kelas }}</h2>
        <p class="mb-2">Sekolah: {{ $kelas->sekolah ? $kelas->sekolah->nama_sekolah : 'Sekolah tidak tersedia' }}</p>
<p class="mb-2">Jenjang: {{ $kelas->sekolah ? $kelas->sekolah->jenjang : 'Jenjang tidak tersedia' }}</p>

        <p class="mb-2">Kapasitas: {{ $kelas->kapasitas }}</p>
        <p class="mb-2">Jurusan: {{ $kelas->jurusan }}</p>
        <p class="mb-2">Tahun Ajaran: {{ $kelas->tahun_ajaran }}</p>
        <p class="mb-2">Semester: {{ $kelas->semester }}</p>
        <p class="mb-2">Wali Kelas: {{ $kelas->wali_kelas }}</p>
    </div>
</div>
@endsection