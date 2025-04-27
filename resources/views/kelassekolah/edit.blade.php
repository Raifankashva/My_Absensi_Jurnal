@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Kelas</h2>
                    <p class="text-gray-600">Sekolah: {{ $userSchool->nama_sekolah }}</p>
                </div>

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kelassekolah.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                   required>
                        </div>

                        <div>
                            <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                            <select name="tingkat" id="tingkat" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                   required>
                                <option value="">Pilih Tingkat</option>
                                <option value="I" {{ old('tingkat', $kelas->tingkat) == 'I' ? 'selected' : '' }}>Kelas 1</option>
                                <option value="II" {{ old('tingkat', $kelas->tingkat) == 'II' ? 'selected' : '' }}>Kelas 2</option>
                                <option value="III" {{ old('tingkat', $kelas->tingkat) == 'III' ? 'selected' : '' }}>Kelas 3</option>
                                <option value="IV" {{ old('tingkat', $kelas->tingkat) == 'IV' ? 'selected' : '' }}>Kelas 4</option>
                                <option value="V" {{ old('tingkat', $kelas->tingkat) == 'V' ? 'selected' : '' }}>Kelas 5</option>
                                <option value="VI" {{ old('tingkat', $kelas->tingkat) == 'VI' ? 'selected' : '' }}>Kelas 6</option>
                                <option value="VII" {{ old('tingkat', $kelas->tingkat) == 'VII' ? 'selected' : '' }}>Kelas 7</option>
                                <option value="VIII" {{ old('tingkat', $kelas->tingkat) == 'VIII' ? 'selected' : '' }}>Kelas 8</option>
                                <option value="IX" {{ old('tingkat', $kelas->tingkat) == 'IX' ? 'selected' : '' }}>Kelas 9</option>
                                <option value="X" {{ old('tingkat', $kelas->tingkat) == 'X' ? 'selected' : '' }}>Kelas 10</option>
                                <option value="XI" {{ old('tingkat', $kelas->tingkat) == 'XI' ? 'selected' : '' }}>Kelas 11</option>
                                <option value="XII" {{ old('tingkat', $kelas->tingkat) == 'XII' ? 'selected' : '' }}>Kelas 12</option>
                            </select>
                        </div>

                        <div>
                            <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1">Jurusan (opsional)</label>
                            <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan', $kelas->jurusan) }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                            <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas', $kelas->kapasitas) }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                   required>
                        </div>

                        <div>
                            <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}" 
                                   placeholder="contoh: 2024/2025"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                   required>
                        </div>

                        <div>
                            <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                            <select name="semester" id="semester" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                   required>
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil" {{ old('semester', $kelas->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester', $kelas->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>

                        <div>
                            <label for="wali_kelas" class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
                            <select name="wali_kelas" id="wali_kelas" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Pilih Wali Kelas</option>
                                @forelse($guru as $g)
                                    <option value="{{ $g->nama }}" {{ old('wali_kelas', $kelas->wali_kelas) == $g->nama ? 'selected' : '' }}>
                                        {{ $g->nama }} ({{ $g->nip ?? 'No NIP' }})
                                    </option>
                                @empty
                                    <option value="" disabled>Tidak ada guru dari sekolah ini</option>
                                @endforelse
                            </select>
                            <p class="mt-1 text-sm text-gray-500">* Hanya menampilkan guru dari sekolah {{ $userSchool->nama_sekolah }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('kelassekolah.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection