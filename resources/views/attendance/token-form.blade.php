@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white text-center py-4">
            <h2 class="text-2xl font-bold">Absensi Siswa</h2>
        </div>

        <form id="tokenForm" action="{{ route('attendance.scan') }}" method="GET" class="p-6">
            <div class="mb-4">
                <label for="attendance_token" class="block text-sm font-medium text-gray-700 mb-2">
                    Masukkan Token Absensi
                </label>
                <input 
                    type="text" 
                    name="attendance_token" 
                    id="attendance_token" 
                    required 
                    autofocus
                    placeholder="Ketik token absensi"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="mb-4">
                <label for="sekolah_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Sekolah
                </label>
                <select 
                    name="sekolah_id" 
                    id="sekolah_id" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">Pilih Sekolah</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                    @endforeach
                </select>
            </div>

            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300"
            >
                Lanjutkan ke Scan Absensi
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('tokenForm').addEventListener('submit', function(e) {
    const token = document.getElementById('attendance_token').value.trim();
    const sekolahId = document.getElementById('sekolah_id').value;

    if (!token || !sekolahId) {
        e.preventDefault();
        alert('Harap isi token absensi dan pilih sekolah');
    }
});
</script>
@endsection