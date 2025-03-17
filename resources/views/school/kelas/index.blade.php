<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Daftar Kelas</h1>

        <form method="GET" action="{{ route('school.kelas.index') }}" class="mb-6">
            <label for="tingkat" class="block text-sm font-medium text-gray-700">Filter Tingkat</label>
            <select name="tingkat" id="tingkat" class="mt-1 p-2 border rounded-md w-full">
                <option value="">Pilih Tingkat</option>
                <option value="1" {{ request('tingkat') == '1' ? 'selected' : '' }}>Tingkat 1</option>
                <option value="2" {{ request('tingkat') == '2' ? 'selected' : '' }}>Tingkat 2</option>
                <option value="3" {{ request('tingkat') == '3' ? 'selected' : '' }}>Tingkat 3</option>
            </select>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
        </form>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Nama Kelas</th>
                    <th class="px-4 py-2 border">Tingkat</th>
                    <th class="px-4 py-2 border">Jumlah Siswa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $item)
                    <tr class="text-center">
                        <td class="px-4 py-2 border">{{ $item->nama_kelas }}</td>
                        <td class="px-4 py-2 border">{{ $item->tingkat }}</td>
                        <td class="px-4 py-2 border">{{ $item->siswa->count() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-center">Data kelas tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $kelas->links() }}
        </div>
    </div>
</body>
</html>
