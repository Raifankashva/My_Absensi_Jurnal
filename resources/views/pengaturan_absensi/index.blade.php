<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Absensi Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Daftar Pengaturan Absensi Sekolah</h1>

        <!-- Menampilkan pesan sukses jika ada -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol untuk menambah pengaturan absensi -->
        <div class="mb-4">
            <a href="{{ route('pengaturan-absensi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                Tambah Pengaturan Absensi
            </a>
        </div>

        <!-- Tabel Pengaturan Absensi -->
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 text-left">Sekolah</th>
                    <th class="py-2 px-4 text-left">Jam Masuk</th>
                    <th class="py-2 px-4 text-left">Jam Pulang</th>
                    <th class="py-2 px-4 text-left">Batas Terlambat</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaturan as $item)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $item->sekolah->nama_sekolah }}</td>
                        <td class="py-2 px-4">{{ $item->jam_masuk }}</td>
                        <td class="py-2 px-4">{{ $item->jam_pulang }}</td>
                        <td class="py-2 px-4">{{ $item->batas_terlambat }}</td>
                        <td class="py-2 px-4">{{ $item->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('pengaturan-absensi.edit', $item->sekolah_id) }}" class="text-blue-500 hover:text-blue-700">Edit</a> | 
                            <form action="{{ route('pengaturan-absensi.destroy', $item->sekolah_id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
