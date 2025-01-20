@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Filter Section -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" name="search" id="search" placeholder="Cari nama sekolah..." 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <select name="jenjang" id="jenjang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Semua Jenjang</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                        </select>
                    </div>
                    <div>
                        <select name="province" id="province" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Pilih Kota/Kabupaten</option>
                        </select>
                    </div>
                    <div>
                        <select name="district" id="district" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div>
                        <select name="village" id="village" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                </div>

                <!-- Add School Button -->
                <div class="mb-6">
                    <a href="{{ route('sekolahs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Tambah Sekolah
                    </a>
                </div>

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($sekolahs as $sekolah)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $sekolah->nama_sekolah }}             <img src="data:image/png;base64,{{ base64_encode($sekolah->qr_code_url) }}" alt="QR Code">
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sekolah->status === 'Negeri' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $sekolah->status }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">NPSN: {{ $sekolah->npsn }}</p>
                                <p class="text-sm text-gray-600 mb-4">Jenjang: {{ $sekolah->jenjang }}</p>
                                <div class="text-sm text-gray-600 mb-4">
                                    <p>{{ $sekolah->alamat }},</p>
                                    <p>{{ $sekolah->village->name }}, {{ $sekolah->district->name }},</p>
                                    <p>{{ $sekolah->city->name }}, {{ $sekolah->province->name }}</p>
                                </div>
                                <div class="flex justify-end space-x-2 mt-4">
                                    <a href="{{ route('sekolahs.show', $sekolah) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    <a href="{{ route('sekolahs.edit', $sekolah) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                    <form action="{{ route('sekolahs.destroy', $sekolah) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-4 text-gray-500">
                            Tidak ada data sekolah
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $sekolahs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter handling
    const searchInput = document.getElementById('search');
    const jenjangSelect = document.getElementById('jenjang');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    const villageSelect = document.getElementById('village');

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Function to update the URL with filter parameters
    function updateFilters() {
        const params = new URLSearchParams(window.location.search);
        
        if (searchInput.value) params.set('search', searchInput.value);
        else params.delete('search');
        
        if (jenjangSelect.value) params.set('jenjang', jenjangSelect.value);
        else params.delete('jenjang');
        
        if (provinceSelect.value) params.set('province', provinceSelect.value);
        else params.delete('province');
        
        if (citySelect.value) params.set('city', citySelect.value);
        else params.delete('city');
        
        if (districtSelect.value) params.set('district', districtSelect.value);
        else params.delete('district');
        
        if (villageSelect.value) params.set('village', villageSelect.value);
        else params.delete('village');

        window.location.search = params.toString();
    }

    // Add event listeners with debounce
    const debouncedUpdate = debounce(updateFilters, 500);
    
    searchInput.addEventListener('input', debouncedUpdate);
    jenjangSelect.addEventListener('change', updateFilters);
    provinceSelect.addEventListener('change', updateFilters);
    citySelect.addEventListener('change', updateFilters);
    districtSelect.addEventListener('change', updateFilters);
    villageSelect.addEventListener('change', updateFilters);

    // Cascade dropdowns
    provinceSelect.addEventListener('change', async function() {
        const provinceId = this.value;
        const response = await fetch(`/api/cities/${provinceId}`);
        const cities = await response.json();
        
        citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        cities.forEach(city => {
            citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
        });
    });

    citySelect.addEventListener('change', async function() {
        const cityId = this.value;
        const response = await fetch(`/api/districts/${cityId}`);
        const districts = await response.json();
        
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        districts.forEach(district => {
            districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
        });
    });

    districtSelect.addEventListener('change', async function() {
        const districtId = this.value;
        const response = await fetch(`/api/villages/${districtId}`);
        const villages = await response.json();
        
        villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
        villages.forEach(village => {
            villageSelect.innerHTML += `<option value="${village.id}">${village.name}</option>`;
        });
    });
});
</script>
@endsection