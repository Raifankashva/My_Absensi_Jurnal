@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">Buat Jurnal Pembelajaran</h1>
        </div>
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('jurnal-guru.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Jadwal Pelajaran --}}
                <div class="form-group">
                    <label for="jadwal_pelajaran_id" class="block text-sm font-medium text-gray-700">
                        Jadwal Pelajaran
                    </label>
                    <select 
                        name="jadwal_pelajaran_id" 
                        id="jadwal_pelajaran_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        required
                    >
                        <option value="">Pilih Jadwal Pelajaran</option>
                        @foreach($jadwalHariIni as $jadwal)
                            <option value="{{ $jadwal->id }}">
                                {{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->mata_pelajaran }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div class="form-group">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">
                        Tanggal
                    </label>
                    <input 
                        type="date" 
                        name="tanggal" 
                        id="tanggal" 
                        value="{{ date('Y-m-d') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        required
                    >
                </div>
            </div>

            {{-- Materi yang Disampaikan --}}
            <div class="mt-6">
                <label for="materi_yang_disampaikan" class="block text-sm font-medium text-gray-700">
                    Materi yang Disampaikan
                </label>
                <textarea 
                    name="materi_yang_disampaikan" 
                    id="materi_yang_disampaikan" 
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required
                ></textarea>
            </div>

            {{-- Status Pertemuan --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">
                    Status Pertemuan
                </label>
                <div class="mt-2 space-y-2">
                    <div class="flex items-center">
                        <input 
                            type="radio" 
                            name="status_pertemuan" 
                            value="Terlaksana" 
                            id="status_terlaksana"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                            checked
                        >
                        <label for="status_terlaksana" class="ml-2 block text-sm text-gray-900">
                            Terlaksana
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input 
                            type="radio" 
                            name="status_pertemuan" 
                            value="Diganti" 
                            id="status_diganti"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                        >
                        <label for="status_diganti" class="ml-2 block text-sm text-gray-900">
                            Diganti
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input 
                            type="radio" 
                            name="status_pertemuan" 
                            value="Dibatalkan" 
                            id="status_dibatalkan"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                        >
                        <label for="status_dibatalkan" class="ml-2 block text-sm text-gray-900">
                            Dibatalkan
                        </label>
                    </div>
                </div>
            </div>

            {{-- Daftar Siswa Absensi --}}
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Siswa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($jadwalHariIni->first()->kelas->siswa as $siswa)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ $siswa->nama_lengkap }}
                                </span>
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            name="siswa_hadir[]" 
                                            value="{{ $siswa->id }}"
                                            class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                            checked
                                        >
                                        <span class="ml-2 text-sm text-gray-700">Hadir</span>
                                    </label>
                                    <div class="relative">
                                        <select 
                                            name="keterangan_tidak_hadir[{{ $siswa->id }}]"
                                            class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md"
                                            onchange="handleAbsensiChange(this)"
                                        >
                                            <option value="">Pilih Keterangan</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Alpa">Alpa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Catatan Tambahan --}}
            <div class="mt-6">
                <label for="catatan_pembelajaran" class="block text-sm font-medium text-gray-700">
                    Catatan Tambahan
                </label>
                <textarea 
                    name="catatan_pembelajaran" 
                    id="catatan_pembelajaran" 
                    rows="2"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                ></textarea>
            </div>

            {{-- Submit Button --}}
            <div class="mt-8 flex justify-end">
                <button 
                    type="submit" 
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Simpan Jurnal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleAbsensiChange(selectElement) {
        const checkboxId = selectElement.closest('.flex').querySelector('input[type="checkbox"]');
        
        if (selectElement.value) {
            checkboxId.checked = false;
        } else {
            checkboxId.checked = true;
        }
    }
</script>

@endsection