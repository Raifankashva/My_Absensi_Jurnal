@extends('layouts.app3')

@section('content')
<div class="px-4 py-4">
    <!-- Header Section -->
    <div class="mb-4 flex items-center">
        <a href="{{ route('jurnal-guru.index') }}" class="mr-3 p-1.5 rounded-full bg-gray-100">
            <i class='bx bx-arrow-back text-lg text-gray-600'></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Tambah Jurnal</h1>
            <p class="text-sm text-gray-500">Isi formulir untuk menambahkan jurnal baru</p>
        </div>
    </div>
    
    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('jurnal-guru.store') }}" method="POST" class="p-4 space-y-5">
            @csrf
            
            <!-- Tanggal & Jadwal -->
            <div class="space-y-5">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class='bx bx-calendar text-blue-600 mr-1.5'></i>
                        Tanggal
                    </label>
                    <input type="date" id="tanggal" name="tanggal" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('tanggal')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="jadwal_pelajaran_id" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class='bx bx-time text-blue-600 mr-1.5'></i>
                        Jadwal Hari Ini
                    </label>
                    <select id="jadwal_pelajaran_id" name="jadwal_pelajaran_id" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Jadwal</option>
                        @foreach($jadwalHariIni as $jadwal)
                            <option value="{{ $jadwal->id }}">
                                {{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->jam_mulai }} s/d {{ $jadwal->jam_selesai }}
                            </option>
                        @endforeach
                    </select>
                    @error('jadwal_pelajaran_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Materi -->
            <div>
                <label for="materi_yang_disampaikan" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <i class='bx bx-book-open text-blue-600 mr-1.5'></i>
                    Materi yang Disampaikan
                </label>
                <textarea id="materi_yang_disampaikan" name="materi_yang_disampaikan" rows="3" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required></textarea>
                @error('materi_yang_disampaikan')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Kehadiran Siswa -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="jumlah_siswa_hadir" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class='bx bx-user-check text-blue-600 mr-1.5'></i>
                        Siswa Hadir
                    </label>
                    <input type="number" id="jumlah_siswa_hadir" name="jumlah_siswa_hadir" min="0" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('jumlah_siswa_hadir')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="jumlah_siswa_tidak_hadir" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class='bx bx-user-x text-blue-600 mr-1.5'></i>
                        Siswa Tidak Hadir
                    </label>
                    <input type="number" id="jumlah_siswa_tidak_hadir" name="jumlah_siswa_tidak_hadir" min="0" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('jumlah_siswa_tidak_hadir')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Nama Siswa Tidak Hadir -->
            <div>
                <label for="data_siswa_tidak_hadir" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <i class='bx bx-list-ul text-blue-600 mr-1.5'></i>
                    Nama Siswa Tidak Hadir (opsional)
                </label>
                <textarea id="data_siswa_tidak_hadir" name="data_siswa_tidak_hadir[]" rows="2" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan nama siswa yang tidak hadir, pisahkan dengan koma"></textarea>
                <p class="mt-1 text-xs text-gray-500">Pisahkan nama siswa dengan koma (,)</p>
            </div>
            
            <!-- Status Pertemuan -->
            <div>
                <label for="status_pertemuan" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <i class='bx bx-check-circle text-blue-600 mr-1.5'></i>
                    Status Pertemuan
                </label>
                <select id="status_pertemuan" name="status_pertemuan" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Pilih Status</option>
                    <option value="Terlaksana">Terlaksana</option>
                    <option value="Diganti">Diganti</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
                @error('status_pertemuan')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Catatan Pembelajaran -->
            <div>
                <label for="catatan_pembelajaran" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <i class='bx bx-notepad text-blue-600 mr-1.5'></i>
                    Catatan Pembelajaran
                </label>
                <textarea id="catatan_pembelajaran" name="catatan_pembelajaran" rows="3" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan catatan tambahan jika ada"></textarea>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-2">
                <a href="{{ route('jurnal-guru.index') }}" class="flex-1 py-2.5 border border-gray-300 rounded-lg text-center text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg text-center text-sm font-medium transition-colors">
                    Simpan Jurnal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
