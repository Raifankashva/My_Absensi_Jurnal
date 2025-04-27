@extends('layouts.app3')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-4 flex items-center">
        <a href="{{ route('jurnal-guru.index') }}" class="mr-3 p-1.5 rounded-full bg-gray-100">
            <i class='bx bx-arrow-back text-lg text-gray-600'></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Detail Jurnal</h1>
            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d F Y') }}</p>
        </div>
    </div>
    
    <!-- Status Badge -->
    <div class="mb-4 flex justify-center">
        @if($jurnal->status_pertemuan == 'Terlaksana')
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <i class='bx bx-check text-lg mr-1.5'></i>
                Terlaksana
            </span>
        @elseif($jurnal->status_pertemuan == 'Diganti')
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                <i class='bx bx-time text-lg mr-1.5'></i>
                Diganti
            </span>
        @else
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                <i class='bx bx-x text-lg mr-1.5'></i>
                Dibatalkan
            </span>
        @endif
    </div>
    
    <!-- Info Cards -->
    <div class="space-y-4">
        <!-- Basic Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4">
                <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <i class='bx bx-info-circle text-blue-600 mr-1.5'></i>
                    Informasi Dasar
                </h2>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class='bx bx-calendar text-blue-600 mr-2'></i>
                            <span class="text-sm text-gray-500">Tanggal</span>
                        </div>
                        <span class="text-sm font-medium">{{ $jurnal->tanggal->format('d F Y') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class='bx bx-user text-blue-600 mr-2'></i>
                            <span class="text-sm text-gray-500">Guru</span>
                        </div>
                        <span class="text-sm font-medium">{{ $jurnal->guru->nama_lengkap }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class='bx bx-building-house text-blue-600 mr-2'></i>
                            <span class="text-sm text-gray-500">Kelas</span>
                        </div>
                        <span class="text-sm font-medium">{{ $jurnal->kelas->nama_kelas }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class='bx bx-book text-blue-600 mr-2'></i>
                            <span class="text-sm text-gray-500">Mata Pelajaran</span>
                        </div>
                        <span class="text-sm font-medium">{{ $jurnal->jadwalPelajaran->mata_pelajaran }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class='bx bx-time text-blue-600 mr-2'></i>
                            <span class="text-sm text-gray-500">Jam Pelajaran</span>
                        </div>
                        <span class="text-sm font-medium">{{ substr($jurnal->jadwalPelajaran->jam_mulai, 0, 5) }} - {{ substr($jurnal->jadwalPelajaran->jam_selesai, 0, 5) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class='bx bx-group text-blue-600 mr-2'></i>
                            <span class="text-sm text-gray-500">Kehadiran</span>
                        </div>
                        <span class="text-sm font-medium">{{ $jurnal->jumlah_siswa_hadir }} hadir, {{ $jurnal->jumlah_siswa_tidak_hadir }} tidak hadir</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Materi Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4">
                <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <i class='bx bx-book-open text-blue-600 mr-1.5'></i>
                    Materi yang Disampaikan
                </h2>
                
                <div class="bg-blue-50 rounded-lg p-3 text-sm">
                    {!! nl2br(e($jurnal->materi_yang_disampaikan)) !!}
                </div>
            </div>
        </div>
        
        <!-- Catatan Card (if exists) -->
        @if($jurnal->catatan_pembelajaran)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4">
                <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <i class='bx bx-notepad text-blue-600 mr-1.5'></i>
                    Catatan Pembelajaran
                </h2>
                
                <div class="bg-blue-50 rounded-lg p-3 text-sm">
                    {!! nl2br(e($jurnal->catatan_pembelajaran)) !!}
                </div>
            </div>
        </div>
        @endif
        
        <!-- Siswa Tidak Hadir Card (if exists) -->
        @if($jurnal->data_siswa_tidak_hadir && count($jurnal->data_siswa_tidak_hadir) > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4">
                <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <i class='bx bx-user-x text-blue-600 mr-1.5'></i>
                    Siswa Tidak Hadir
                </h2>
                
                <div class="space-y-2">
                    @foreach($jurnal->data_siswa_tidak_hadir as $siswa)
                    <div class="bg-red-50 text-red-800 rounded-md px-3 py-2 text-sm flex items-center">
                        <i class='bx bx-x-circle text-red-500 mr-2'></i>
                        {{ $siswa }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Action Buttons -->
    <div class="mt-6 grid grid-cols-2 gap-3">
        <a href="{{ route('jurnal-guru.edit', $jurnal->id) }}" class="py-2.5 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white rounded-lg text-center text-sm font-medium transition-colors flex items-center justify-center">
            <i class='bx bx-edit text-lg mr-1.5'></i>
            Edit
        </a>
        
        <form action="{{ route('jurnal-guru.destroy', $jurnal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus jurnal ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg text-center text-sm font-medium transition-colors flex items-center justify-center">
                <i class='bx bx-trash text-lg mr-1.5'></i>
                Hapus
            </button>
        </form>
    </div>
</div>
@endsection
