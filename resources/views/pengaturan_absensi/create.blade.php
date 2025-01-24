<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Absensi Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Pengaturan Absensi Sekolah</h1>

        <!-- Menampilkan pesan sukses jika ada -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form untuk menambah pengaturan absensi -->
        <form action="{{ route('pengaturan-absensi.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sekolah</label>
                    <select name="sekolah_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        @foreach($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                        @endforeach
                    </select>
                    @error('sekolah_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
    <label class="block text-sm font-medium text-gray-700">Jam Masuk</label>
    <input type="time" name="jam_masuk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" value="{{ old('jam_masuk') }}" required>
    @error('jam_masuk')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Jam Pulang</label>
    <input type="time" name="jam_pulang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" value="{{ old('jam_pulang') }}" required>
    @error('jam_pulang')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Batas Waktu Terlambat</label>
    <input type="time" name="batas_terlambat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" value="{{ old('batas_terlambat') }}">
    @error('batas_terlambat')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>


            <div class="flex items-center">
                <input type="checkbox" name="status" value="aktif" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ old('status') == 'aktif' ? 'checked' : '' }}>
                <label class="ml-2 block text-sm text-gray-900">Aktifkan Absensi</label>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</body>
</html>
