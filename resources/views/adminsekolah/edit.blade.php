@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Edit Sekolah</h2>
                    <a href="{{ route('adminsekolah.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Kembali</a>
                </div>

                @if ($errors->any())
                <div class="mb-4 bg-red-50 p-4 rounded-md">
                    <div class="text-red-600 font-medium">Terdapat kesalahan pada inputan:</div>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('adminsekolah.update', $school->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NPSN -->
                        <div>
                            <label for="npsn" class="block text-sm font-medium text-gray-700">NPSN <span class="text-red-500">*</span></label>
                            <input type="text" name="npsn" id="npsn" value="{{ old('npsn', $school->npsn) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" maxlength="8" required>
                            <p class="mt-1 text-xs text-gray-500">Nomor Pokok Sekolah Nasional (8 digit)</p>
                        </div>

                        <!-- Nama Sekolah -->
                        <div>
                            <label for="nama_sekolah" class="block text-sm font-medium text-gray-700">Nama Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_sekolah" id="nama_sekolah" value="{{ old('nama_sekolah', $school->nama_sekolah) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        </div>

                        <!-- Jenjang -->
                        <div>
                            <label for="jenjang" class="block text-sm font-medium text-gray-700">Jenjang <span class="text-red-500">*</span></label>
                            <select name="jenjang" id="jenjang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                <option value="SD" {{ old('jenjang', $school->jenjang) == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('jenjang', $school->jenjang) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('jenjang', $school->jenjang) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ old('jenjang', $school->jenjang) == 'SMK' ? 'selected' : '' }}>SMK</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                <option value="Negeri" {{ old('status', $school->status) == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                <option value="Swasta" {{ old('status', $school->status) == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                            </select>
                        </div>

                        <!-- Akreditasi -->
                        <div>
                            <label for="akreditasi" class="block text-sm font-medium text-gray-700">Akreditasi</label>
                            <select name="akreditasi" id="akreditasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="" {{ old('akreditasi', $school->akreditasi) == '' ? 'selected' : '' }}>- Pilih Akreditasi -</option>
                                <option value="A" {{ old('akreditasi', $school->akreditasi) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('akreditasi', $school->akreditasi) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('akreditasi', $school->akreditasi) == 'C' ? 'selected' : '' }}>C</option>
                            </select>
                        </div>

                        <!-- Kepala Sekolah -->
                        <div>
                            <label for="kepala_sekolah" class="block text-sm font-medium text-gray-700">Kepala Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="kepala_sekolah" id="kepala_sekolah" value="{{ old('kepala_sekolah', $school->kepala_sekolah) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        </div>

                        <!-- NIP Kepala Sekolah -->
                        <div>
                            <label for="nip_kepala_sekolah" class="block text-sm font-medium text-gray-700">NIP Kepala Sekolah</label>
                            <input type="text" name="nip_kepala_sekolah" id="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $school->nip_kepala_sekolah) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" maxlength="18">
                            <p class="mt-1 text-xs text-gray-500">18 digit</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Alamat Sekolah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>{{ old('alamat', $school->alamat) }}</textarea>
                            </div>

                            <!-- Provinsi -->
                            <div>
                                <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi <span class="text-red-500">*</span></label>
                                <select name="province_id" id="province_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                    <option value="">- Pilih Provinsi -</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id', $school->province_id) == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kota/Kabupaten -->
                            <div>
                                <label for="city_id" class="block text-sm font-medium text-gray-700">Kota/Kabupaten <span class="text-red-500">*</span></label>
                                <select name="city_id" id="city_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                    <option value="">- Pilih Kota/Kabupaten -</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $school->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kecamatan -->
                            <div>
                                <label for="district_id" class="block text-sm font-medium text-gray-700">Kecamatan <span class="text-red-500">*</span></label>
                                <select name="district_id" id="district_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                    <option value="">- Pilih Kecamatan -</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ old('district_id', $school->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kelurahan/Desa -->
                            <div>
                                <label for="village_id" class="block text-sm font-medium text-gray-700">Kelurahan/Desa <span class="text-red-500">*</span></label>
                                <select name="village_id" id="village_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                    <option value="">- Pilih Kelurahan/Desa -</option>
                                    @foreach($villages as $village)
                                        <option value="{{ $village->id }}" {{ old('village_id', $school->village_id) == $village->id ? 'selected' : '' }}>{{ $village->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kode Pos -->
                            <div>
                                <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kode Pos <span class="text-red-500">*</span></label>
                                <input type="text" name="kode_pos" id="kode_pos" value="{{ old('kode_pos', $school->kode_pos) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" maxlength="5" required>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Kontak & Media</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- No Telepon -->
                            <div>
                                <label for="no_telp" class="block text-sm font-medium text-gray-700">Nomor Telepon <span class="text-red-500">*</span></label>
                                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $school->no_telp) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $school->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            </div>

                            <!-- Website -->
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" name="website" id="website" value="{{ old('website', $school->website) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>

                            <!-- Foto -->
                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Sekolah</label>
                                <input type="file" name="foto" id="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                                
                                @if($school->foto)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600 mb-1">Foto saat ini:</p>
                                    <img src="{{ Storage::url($school->foto) }}" alt="Foto Sekolah" class="w-32 h-32 object-cover rounded-md border border-gray-200">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Province-City-District-Village dependent dropdown
    document.addEventListener('DOMContentLoaded', function() {
        // Province change
        document.getElementById('province_id').addEventListener('change', function() {
            const provinceId = this.value;
            fetchCities(provinceId);
            // Reset other dropdowns
            resetDropdown('district_id', '- Pilih Kecamatan -');
            resetDropdown('village_id', '- Pilih Kelurahan/Desa -');
        });

        // City change
        document.getElementById('city_id').addEventListener('change', function() {
            const cityId = this.value;
            fetchDistricts(cityId);
            // Reset village dropdown
            resetDropdown('village_id', '- Pilih Kelurahan/Desa -');
        });

        // District change
        document.getElementById('district_id').addEventListener('change', function() {
            const districtId = this.value;
            fetchVillages(districtId);
        });

        function fetchCities(provinceId) {
            if (!provinceId) {
                resetDropdown('city_id', '- Pilih Kota/Kabupaten -');
                return;
            }

            fetch(`/api/cities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    const cityDropdown = document.getElementById('city_id');
                    cityDropdown.innerHTML = '<option value="">- Pilih Kota/Kabupaten -</option>';
                    
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        cityDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));
        }

        function fetchDistricts(cityId) {
            if (!cityId) {
                resetDropdown('district_id', '- Pilih Kecamatan -');
                return;
            }

            fetch(`/api/districts/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    const districtDropdown = document.getElementById('district_id');
                    districtDropdown.innerHTML = '<option value="">- Pilih Kecamatan -</option>';
                    
                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        districtDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching districts:', error));
        }

        function fetchVillages(districtId) {
            if (!districtId) {
                resetDropdown('village_id', '- Pilih Kelurahan/Desa -');
                return;
            }

            fetch(`/api/villages/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    const villageDropdown = document.getElementById('village_id');
                    villageDropdown.innerHTML = '<option value="">- Pilih Kelurahan/Desa -</option>';
                    
                    data.forEach(village => {
                        const option = document.createElement('option');
                        option.value = village.id;
                        option.textContent = village.name;
                        villageDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching villages:', error));
        }

        function resetDropdown(id, placeholderText) {
            const dropdown = document.getElementById(id);
            dropdown.innerHTML = `<option value="">${placeholderText}</option>`;
        }
    });
</script>

@endsection