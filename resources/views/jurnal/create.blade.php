@extends('layouts.app')

@section('title', 'Jurnal Guru')

@section('content')

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ isset($jurnal) ? route('jurnal.update', $jurnal) : route('jurnal.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($jurnal))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                                <select id="kelas_id" 
                                        name="kelas_id" 
                                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" 
                                                {{ (isset($jurnal) && $jurnal->kelas_id == $k->id) || old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
    <input type="date" 
           id="tanggal" 
           name="tanggal" 
           value="{{ isset($jurnal) ? $jurnal->tanggal->format('Y-m-d') : old('tanggal') }}"
           min="{{ now()->format('Y-m-d') }}"
           class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    @error('tanggal')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>


                            <div>
                                <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                                <input type="time" 
                                       id="waktu_mulai" 
                                       name="waktu_mulai" 
                                       value="{{ isset($jurnal) ? \Carbon\Carbon::parse($jurnal->waktu_mulai)->format('H:i') : old('waktu_mulai') }}"
                                       class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('waktu_mulai')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                                <input type="time" 
                                       id="waktu_selesai" 
                                       name="waktu_selesai" 
                                       value="{{ isset($jurnal) ? \Carbon\Carbon::parse($jurnal->waktu_selesai)->format('H:i') : old('waktu_selesai') }}"
                                       class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('waktu_selesai')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="mata_pelajaran" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                <input type="text" 
                                       id="mata_pelajaran" 
                                       name="mata_pelajaran" 
                                       value="{{ isset($jurnal) ? $jurnal->mata_pelajaran : old('mata_pelajaran') }}"
                                       class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('mata_pelajaran')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="materi_pembelajaran" class="block text-sm font-medium text-gray-700">Materi Pembelajaran</label>
                                <textarea id="materi_pembelajaran" 
                                          name="materi_pembelajaran" 
                                          rows="3"
                                          class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ isset($jurnal) ? $jurnal->materi_pembelajaran : old('materi_pembelajaran') }}</textarea>
                                @error('materi_pembelajaran')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="catatan_kegiatan" class="block text-sm font-medium text-gray-700">Catatan Kegiatan</label>
                                <textarea id="catatan_kegiatan" 
                                          name="catatan_kegiatan" 
                                          rows="4"
                                          class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ isset($jurnal) ? $jurnal->catatan_kegiatan : old('catatan_kegiatan') }}</textarea>
                                @error('catatan_kegiatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="capaian_pembelajaran" class="block text-sm font-medium text-gray-700">Capaian Pembelajaran</label>
                                <textarea id="capaian_pembelajaran" 
                                          name="capaian_pembelajaran" 
                                          rows="3"
                                          class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ isset($jurnal) ? $jurnal->capaian_pembelajaran : old('capaian_pembelajaran') }}</textarea>
                                @error('capaian_pembelajaran')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jumlah_siswa_hadir" class="block text-sm font-medium text-gray-700">Jumlah Siswa Hadir</label>
                                <input type="number" 
                                       id="jumlah_siswa_hadir" 
                                       name="jumlah_siswa_hadir" 
                                       value="{{ isset($jurnal) ? $jurnal->jumlah_siswa_hadir : old('jumlah_siswa_hadir') }}"
                                       min="0"
                                       class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('jumlah_siswa_hadir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jumlah_siswa_tidak_hadir" class="block text-sm font-medium text-gray-700">Jumlah Siswa Tidak Hadir</label>
                                <input type="number" 
                                       id="jumlah_siswa_tidak_hadir" 
                                       name="jumlah_siswa_tidak_hadir" 
                                       value="{{ isset($jurnal) ? $jurnal->jumlah_siswa_tidak_hadir : old('jumlah_siswa_tidak_hadir') }}"
                                       min="0"
                                       class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('jumlah_siswa_tidak_hadir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="keterangan_ketidakhadiran" class="block text-sm font-medium text-gray-700">Keterangan Ketidakhadiran</label>
                                <textarea id="keterangan_ketidakhadiran" 
                                          name="keterangan_ketidakhadiran" 
                                          rows="2"
                                          class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ isset($jurnal) ? $jurnal->keterangan_ketidakhadiran : old('keterangan_ketidakhadiran') }}</textarea>
                                @error('keterangan_ketidakhadiran')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="rencana_pembelajaran_selanjutnya" class="block text-sm font-medium text-gray-700">Rencana Pembelajaran Selanjutnya</label>
                                <textarea id="rencana_pembelajaran_selanjutnya" 
                                          name="rencana_pembelajaran_selanjutnya" 
                                          rows="3"
                                          class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ isset($jurnal) ? $jurnal->rencana_pembelajaran_selanjutnya : old('rencana_pembelajaran_selanjutnya') }}</textarea>
                                @error('rencana_pembelajaran_selanjutnya')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="tanda_tangan" class="block text-sm font-medium text-gray-700">
                                    Tanda Tangan Digital
                                    @if(isset($jurnal) && $jurnal->tanda_tangan)
                                        <span class="text-sm text-gray-500">(Upload baru untuk mengganti)</span>
                                    @endif
                                </label>
                                <input type="file" 
                                       id="tanda_tangan" 
                                       name="tanda_tangan" 
                                       accept="image/*"
                                       class="block w-full mt-1 text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-indigo-50 file:text-indigo-700
                                              hover:file:bg-indigo-100">
                                @error('tanda_tangan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if(isset($jurnal) && $jurnal->tanda_tangan)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($jurnal->tanda_tangan) }}" 
                                             alt="Tanda tangan saat ini" 
                                             class="h-20 object-contain">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ isset($jurnal) ? 'Update Jurnal' : 'Simpan Jurnal' }}
                            </button>
                            <a href="{{ route('jurnal.index') }}" 
                               class="ml-3 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection