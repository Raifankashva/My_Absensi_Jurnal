@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Tambah Siswa Baru</h1>

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('adminsiswa.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            
            <!-- User Account Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Informasi Akun</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input type="email" name="email" id="email" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('email') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input type="password" name="password" id="password" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <!-- School and Class Selection -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Informasi Akademik</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="sekolah_id">
                            Sekolah
                        </label>
                        <select name="sekolah_id" id="sekolah_id" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Sekolah</option>
                            @foreach($sekola as $school)
                                <option value="{{ $school->id }}">{{ $school->nama_sekolah }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="kelas_id">
                            Kelas
                        </label>
                        <select name="kelas_id" id="kelas_id" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Kelas</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Student Personal Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Informasi Pribadi</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nisn">NISN</label>
                        <input type="text" name="nisn" id="nisn" required maxlength="10"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('nisn') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nis">NIS</label>
                        <input type="text" name="nis" id="nis" required maxlength="10"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('nis') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nik">NIK</label>
                        <input type="text" name="nik" id="nik" required maxlength="16"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('nik') }}">
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Alamat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="province_id">
                            Provinsi
                        </label>
                        <select name="province_id" id="province_id" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="city_id">
                            Kabupaten/Kota
                        </label>
                        <select name="city_id" id="city_id" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="district_id">
                            Kecamatan
                        </label>
                        <select name="district_id" id="district_id" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="village_id">
                            Desa/Kelurahan
                        </label>
                        <select name="village_id" id="village_id" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic Class Loading based on School
    const schoolSelect = document.getElementById('sekolah_id');
    const classSelect = document.getElementById('kelas_id');

    schoolSelect.addEventListener('change', function() {
        const schoolId = this.value;
        classSelect.innerHTML = '<option value="">Pilih Kelas</option>';
        
        if(schoolId) {
            fetch(`/api/schools/${schoolId}/classes`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(kelas => {
                        const option = document.createElement('option');
                        option.value = kelas.id;
                        option.textContent = kelas.nama_kelas;
                        classSelect.appendChild(option);
                    });
                });
        }
    });

    // Dynamic Address Loading
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const villageSelect = document.getElementById('village_id');

    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        resetSelect(citySelect, 'Pilih Kabupaten/Kota');
        resetSelect(districtSelect, 'Pilih Kecamatan');
        resetSelect(villageSelect, 'Pilih Desa/Kelurahan');
        
        if(provinceId) {
            fetchData(`/api/provinces/${provinceId}/cities`, citySelect);
        }
    });

    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        resetSelect(districtSelect, 'Pilih Kecamatan');
        resetSelect(villageSelect, 'Pilih Desa/Kelurahan');
        
        if(cityId) {
            fetchData(`/api/cities/${cityId}/districts`, districtSelect);
        }
    });

    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        resetSelect(villageSelect, 'Pilih Desa/Kelurahan');
        
        if(districtId) {
            fetchData(`/api/districts/${districtId}/villages`, villageSelect);
        }
    });

    function resetSelect(selectElement, defaultText) {
        selectElement.innerHTML = `<option value="">${defaultText}</option>`;
    }

    function fetchData(url, selectElement) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
            });
    }
});
</script>
@endsection