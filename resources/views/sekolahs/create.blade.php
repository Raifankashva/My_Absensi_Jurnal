@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('sekolahs.store') }}" class="space-y-6">
                        @csrf

                        <!-- NPSN dan Nama Sekolah -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="npsn" class="block text-sm font-medium text-gray-700">NPSN</label>
                                <input type="text" name="npsn" id="npsn" value="{{ old('npsn') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required maxlength="8">
                                @error('npsn')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama_sekolah" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" id="nama_sekolah" value="{{ old('nama_sekolah') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('nama_sekolah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenjang dan Status -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="jenjang" class="block text-sm font-medium text-gray-700">Jenjang</label>
                                <select name="jenjang" id="jenjang" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="">Pilih Jenjang</option>
                                    @foreach(['SD', 'SMP', 'SMA', 'SMK'] as $jenjang)
                                        <option value="{{ $jenjang }}" {{ old('jenjang') == $jenjang ? 'selected' : '' }}>{{ $jenjang }}</option>
                                    @endforeach
                                </select>
                                @error('jenjang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="">Pilih Status</option>
                                    @foreach(['Negeri', 'Swasta'] as $status)
                                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                                <select name="province_id" id="province_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city_id" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                <select name="city_id" id="city_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                                @error('city_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="district_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                <select name="district_id" id="district_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('district_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="village_id" class="block text-sm font-medium text-gray-700">Kelurahan/Desa</label>
                                <select name="village_id" id="village_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required disabled>
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>
                                @error('village_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kode Pos dan No Telp -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                                <input type="text" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required maxlength="5">
                                @error('kode_pos')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="no_telp" class="block text-sm font-medium text-gray-700">No Telepon</label>
                                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('no_telp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email dan Website -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" name="website" id="website" value="{{ old('website') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('website')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Akreditasi dan Kepala Sekolah -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="akreditasi" class="block text-sm font-medium text-gray-700">Akreditasi</label>
                                <select name="akreditasi" id="akreditasi" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Pilih Akreditasi</option>
                                    @foreach(['A', 'B', 'C'] as $akreditasi)
                                        <option value="{{ $akreditasi }}" {{ old('akreditasi') == $akreditasi ? 'selected' : '' }}>{{ $akreditasi }}</option>
                                    @endforeach
                                </select>
                                @error('akreditasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kepala_sekolah" class="block text-sm font-medium text-gray-700">Nama Kepala Sekolah</label>
                                <input type="text" name="kepala_sekolah" id="kepala_sekolah" value="{{ old('kepala_sekolah') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('kepala_sekolah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- NIP Kepala Sekolah -->
                        <div>
                            <label for="nip_kepala_sekolah" class="block text-sm font-medium text-gray-700">NIP Kepala Sekolah</label>
                            <input type="text" name="nip_kepala_sekolah" id="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" maxlength="18">
                            @error('nip_kepala_sekolah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('sekolahs.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
// resources/js/sekolah-form.js

document.addEventListener('DOMContentLoaded', function() {
    // Select Elements
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const villageSelect = document.getElementById('village_id');
    
    // Form Elements
    const npsnInput = document.getElementById('npsn');
    const kodeposInput = document.getElementById('kode_pos');
    const nipInput = document.getElementById('nip_kepala_sekolah');
    const form = document.querySelector('form');

    // Input Masking
    npsnInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
    });

    kodeposInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);
    });

    nipInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18);
    });

    // Location Change Handlers
    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        if (provinceId) {
            fetchCities(provinceId);
            citySelect.disabled = false;
        } else {
            resetSelect(citySelect);
            resetSelect(districtSelect);
            resetSelect(villageSelect);
        }
    });

    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        if (cityId) {
            fetchDistricts(cityId);
            districtSelect.disabled = false;
        } else {
            resetSelect(districtSelect);
            resetSelect(villageSelect);
        }
    });

    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        if (districtId) {
            fetchVillages(districtId);
            villageSelect.disabled = false;
        } else {
            resetSelect(villageSelect);
        }
    });

    // Fetch Functions
    async function fetchCities(provinceId) {
        try {
            showLoader(citySelect);
            const response = await fetch(`/getcities/${provinceId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const cities = await response.json();
            
            populateSelect(citySelect, cities, 'Pilih Kota/Kabupaten');
        } catch (error) {
            console.error('Error fetching cities:', error);
            showError(citySelect, 'Gagal memuat data kota');
        } finally {
            hideLoader(citySelect);
        }
    }

    async function fetchDistricts(cityId) {
        try {
            showLoader(districtSelect);
            const response = await fetch(`/getdistricts/${cityId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const districts = await response.json();
            
            populateSelect(districtSelect, districts, 'Pilih Kecamatan');
        } catch (error) {
            console.error('Error fetching districts:', error);
            showError(districtSelect, 'Gagal memuat data kecamatan');
        } finally {
            hideLoader(districtSelect);
        }
    }

    async function fetchVillages(districtId) {
        try {
            showLoader(villageSelect);
            const response = await fetch(`/getvillages/${districtId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const villages = await response.json();
            
            populateSelect(villageSelect, villages, 'Pilih Kelurahan/Desa');
        } catch (error) {
            console.error('Error fetching villages:', error);
            showError(villageSelect, 'Gagal memuat data kelurahan/desa');
        } finally {
            hideLoader(villageSelect);
        }
    }

    // Utility Functions
    function resetSelect(selectElement) {
        selectElement.innerHTML = `<option value="">Pilih ${selectElement.getAttribute('data-placeholder') || 'Pilih'}</option>`;
        selectElement.disabled = true;
    }

    function populateSelect(selectElement, data, placeholder) {
        selectElement.innerHTML = `<option value="">${placeholder}</option>`;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;
            selectElement.appendChild(option);
        });
        selectElement.disabled = false;
    }

    function showLoader(element) {
        const parent = element.parentElement;
        if (!parent.querySelector('.loader')) {
            const loader = document.createElement('div');
            loader.className = 'loader absolute right-8 top-10';
            loader.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
            parent.style.position = 'relative';
            parent.appendChild(loader);
        }
    }

    function hideLoader(element) {
        const loader = element.parentElement.querySelector('.loader');
        if (loader) {
            loader.remove();
        }
    }

    function showError(element, message) {
        const errorDiv = document.createElement('p');
        errorDiv.className = 'mt-1 text-sm text-red-600 error-message';
        errorDiv.textContent = message;
        
        // Remove any existing error message
        const existingError = element.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        element.parentElement.appendChild(errorDiv);
    }

    // Form Submission Handler
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Remove all existing error messages
        document.querySelectorAll('.error-message').forEach(error => error.remove());
        
        // Basic client-side validation
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                showError(field, 'Bidang ini wajib diisi');
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
            }
        });

        if (isValid) {
            try {
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                `;
                
                form.submit();
            } catch (error) {
                console.error('Error submitting form:', error);
                showError(form.querySelector('button[type="submit"]'), 'Gagal menyimpan data. Silakan coba lagi.');
            }
        }
    });

    // Initialize form if there's old data (after validation error)
    if (provinceSelect.value) {
        fetchCities(provinceSelect.value).then(() => {
            if (citySelect.dataset.oldValue) {
                citySelect.value = citySelect.dataset.oldValue;
                fetchDistricts(citySelect.value).then(() => {
                    if (districtSelect.dataset.oldValue) {
                        districtSelect.value = districtSelect.dataset.oldValue;
                        fetchVillages(districtSelect.value).then(() => {
                            if (villageSelect.dataset.oldValue) {
                                villageSelect.value = villageSelect.dataset.oldValue;
                            }
                        });
                    }
                });
            }
        });
    }
});
</script>

@endsection