@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200 px-4 py-4 sm:px-6">
                <h5 class="text-lg font-medium text-gray-900">Isi Jurnal Pembelajaran</h5>
            </div>

            <div class="px-4 py-5 sm:p-6">
                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                        <div class="text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                
                @if(count($jadwalHariIni) > 0)
                <form action="{{ route('jurnal-guru.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="jadwal_pelajaran_id" class="block text-sm font-medium text-gray-700">
                                    Jadwal Pelajaran
                                </label>
                            </div>
                            <div class="sm:col-span-4">
                                <select name="jadwal_pelajaran_id" id="jadwal_pelajaran_id" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md @error('jadwal_pelajaran_id') border-red-300 text-red-900 placeholder-red-300 @enderror">
                                    <option value="">Pilih Jadwal</option>
                                    @foreach($jadwalHariIni as $jadwal)
                                        <option value="{{ $jadwal->id }}" {{ old('jadwal_pelajaran_id') == $jadwal->id ? 'selected' : '' }}>
                                            {{ $jadwal->mata_pelajaran }} - {{ $jadwal->kelas->nama_kelas }} 
                                            ({{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('jadwal_pelajaran_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">
                                    Tanggal
                                </label>
                            </div>
                            <div class="sm:col-span-4">
                                <input type="date" name="tanggal" id="tanggal"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('tanggal') border-red-300 text-red-900 placeholder-red-300 @enderror"
                                    value="{{ old('tanggal', date('Y-m-d')) }}">
                                @error('tanggal')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="materi_yang_disampaikan" class="block text-sm font-medium text-gray-700">
                                    Materi yang Disampaikan
                                </label>
                            </div>
                            <div class="sm:col-span-4">
                                <textarea name="materi_yang_disampaikan" id="materi_yang_disampaikan" rows="4"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('materi_yang_disampaikan') border-red-300 text-red-900 placeholder-red-300 @enderror">{{ old('materi_yang_disampaikan') }}</textarea>
                                @error('materi_yang_disampaikan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="status_pertemuan" class="block text-sm font-medium text-gray-700">
                                    Status Pertemuan
                                </label>
                            </div>
                            <div class="sm:col-span-4">
                                <select name="status_pertemuan" id="status_pertemuan"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md @error('status_pertemuan') border-red-300 text-red-900 placeholder-red-300 @enderror">
                                    <option value="Terlaksana" {{ old('status_pertemuan') == 'Terlaksana' ? 'selected' : '' }}>Terlaksana</option>
                                    <option value="Diganti" {{ old('status_pertemuan') == 'Diganti' ? 'selected' : '' }}>Diganti</option>
                                    <option value="Dibatalkan" {{ old('status_pertemuan') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status_pertemuan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="jumlah_siswa_hadir" class="block text-sm font-medium text-gray-700">
                                    Jumlah Siswa Hadir
                                </label>
                            </div>
                            <div class="sm:col-span-4">
                                <input type="number" name="jumlah_siswa_hadir" id="jumlah_siswa_hadir" min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('jumlah_siswa_hadir') border-red-300 text-red-900 placeholder-red-300 @enderror"
                                    value="{{ old('jumlah_siswa_hadir') }}">
                                @error('jumlah_siswa_hadir')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="jumlah_siswa_tidak_hadir" class="block text-sm font-medium text-gray-700">
                                    Jumlah Siswa Tidak Hadir
                                </label>
                            </div>
                            <div class="sm:col-span-4">
                                <input type="number" name="jumlah_siswa_tidak_hadir" id="jumlah_siswa_tidak_hadir" min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('jumlah_siswa_tidak_hadir') border-red-300 text-red-900 placeholder-red-300 @enderror"
                                    value="{{ old('jumlah_siswa_tidak_hadir') }}">
                                @error('jumlah_siswa_tidak_hadir')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="data_siswa_tidak_hadir" class="block text-sm font-medium text-gray-700">
                                    Data Siswa Tidak Hadir
                                </label>
                            </div>
                            <div class="sm:col-span-4" id="siswa-tidak-hadir-list">
                                <div class="space-y-2">
                                    <div class="siswa-input">
                                        <input type="text" name="data_siswa_tidak_hadir[]" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            placeholder="Nama siswa dan alasan tidak hadir">
                                    </div>
                                </div>
                                <button type="button" id="tambah-siswa-btn"
                                    class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Tambah Siswa
                                </button>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="catatan_pembelajaran" class="block text-sm font-medium text-gray-700">
                                    Catatan Pembelajaran
                                </label>
                            </div>
                            <div class="sm:col-span-4">
                                <textarea name="catatan_pembelajaran" id="catatan_pembelajaran" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('catatan_pembelajaran') border-red-300 text-red-900 placeholder-red-300 @enderror">{{ old('catatan_pembelajaran') }}</textarea>
                                @error('catatan_pembelajaran')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('jurnal-guru.index') }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan Jurnal
                            </button>
                        </div>
                    </div>
                </form>
                @else
                    <div class="rounded-md bg-blue-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Tidak ada jadwal mengajar untuk hari ini. Silakan pilih hari lain atau hubungi admin jika ada kesalahan jadwal.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <a href="{{ route('jurnal-guru.index') }}"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tambahSiswaBtn = document.getElementById('tambah-siswa-btn');
    const siswaContainer = document.getElementById('siswa-tidak-hadir-list');
    
    if (tambahSiswaBtn) {
        tambahSiswaBtn.addEventListener('click', function() {
            const siswaInput = document.createElement('div');
            siswaInput.className = 'siswa-input mt-2';
            siswaInput.innerHTML = `
                <div class="flex space-x-2">
                    <input type="text" name="data_siswa_tidak_hadir[]" 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Nama siswa dan alasan tidak hadir">
                    <button type="button" class="hapus-siswa-btn inline-flex items-center p-2 border border-gray-300 rounded-md text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;
            
            const firstInput = siswaContainer.querySelector('.siswa-input');
            siswaContainer.insertBefore(siswaInput, firstInput.nextSibling);
            
            // Add event listener to new delete button
            const deleteButton = siswaInput.querySelector('.hapus-siswa-btn');
            deleteButton.addEventListener('click', function() {
                siswaInput.remove();
            });
        });
    }
    
    // Show/hide tidak hadir section based on input
    const jumlahTidakHadir = document.getElementById('jumlah_siswa_tidak_hadir');
    const siswaContainer = document.getElementById('siswa-tidak-hadir-container');
    
    function toggleSiswaTidakHadir() {
        if (parseInt(jumlahTidakHadir.value) > 0) {
            siswaContainer.classList.remove('hidden');
        } else {
            siswaContainer.classList.add('hidden');
        }
    }
    
    if (jumlahTidakHadir) {
        toggleSiswaTidakHadir(); // Initial check
        jumlahTidakHadir.addEventListener('input', toggleSiswaTidakHadir);
    }
});
</script>
@endsection