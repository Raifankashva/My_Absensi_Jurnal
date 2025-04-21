@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Export Data Sekolah</h2>
                    <a href="{{ route('adminsekolah.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Kembali</a>
                </div>

                @if ($errors->any())
                <div class="mb-4 bg-red-50 p-4 rounded-md">
                    <div class="text-red-600 font-medium">Terdapat kesalahan:</div>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-blue-50 p-4 rounded-md mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Silakan pilih filter lokasi untuk mengekspor data sekolah. Kosongkan filter untuk mengekspor semua data.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="export-form" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Provinsi -->
                        <div>
                            <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <select name="province_id" id="province_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">- Semua Provinsi -</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kota/Kabupaten -->
                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                            <select name="city_id" id="city_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" disabled>
                                <option value="">- Semua Kota/Kabupaten -</option>
                            </select>
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <label for="district_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                            <select name="district_id" id="district_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" disabled>
                                <option value="">- Semua Kecamatan -</option>
                            </select>
                        </div>

                        <!-- Kelurahan/Desa -->
                        <div>
                            <label for="village_id" class="block text-sm font-medium text-gray-700">Kelurahan/Desa</label>
                            <select name="village_id" id="village_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" disabled>
                                <option value="">- Semua Kelurahan/Desa -</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                        <button type="button" id="export-excel" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export Excel
                        </button>
                        <button type="button" id="export-pdf" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            Export PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exportForm = document.getElementById('export-form');
        const exportExcelBtn = document.getElementById('export-excel');
        const exportPdfBtn = document.getElementById('export-pdf');
        


        // Export Excel
        exportExcelBtn.addEventListener('click', function() {
            submitExportForm('excel');
        });

        // Export PDF
        exportPdfBtn.addEventListener('click', function() {
            submitExportForm('pdf');
        });

        function submitExportForm(type) {
            // Create a temporary form
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = type === 'excel' 
                ? '{{ route("school.export.excel") }}' 
                : '{{ route("school.export.pdf") }}';
            tempForm.style.display = 'none';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('input[name="_token"]').value;
            tempForm.appendChild(csrfToken);
            
            // Add location filters
            const provinceInput = document.createElement('input');
            provinceInput.type = 'hidden';
            provinceInput.name = 'province_id';
            provinceInput.value = document.getElementById('province_id').value;
            tempForm.appendChild(provinceInput);
            
            const cityInput = document.createElement('input');
            cityInput.type = 'hidden';
            cityInput.name = 'city_id';
            cityInput.value = document.getElementById('city_id').value;
            tempForm.appendChild(cityInput);
            
            const districtInput = document.createElement('input');
            districtInput.type = 'hidden';
            districtInput.name = 'district_id';
            districtInput.value = document.getElementById('district_id').value;
            tempForm.appendChild(districtInput);
            
            const villageInput = document.createElement('input');
            villageInput.type = 'hidden';
            villageInput.name = 'village_id';
            villageInput.value = document.getElementById('village_id').value;
            tempForm.appendChild(villageInput);
            
            // Append to body, submit, and remove
            document.body.appendChild(tempForm);
            tempForm.submit();
            document.body.removeChild(tempForm);
        }

        function fetchCities(provinceId) {
            fetch(`/api/export/cities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    const cityDropdown = document.getElementById('city_id');
                    cityDropdown.innerHTML = '<option value="">- Semua Kota/Kabupaten -</option>';
                    
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
            fetch(`/api/export/districts/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    const districtDropdown = document.getElementById('district_id');
                    districtDropdown.innerHTML = '<option value="">- Semua Kecamatan -</option>';
                    
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
            fetch(`/api/export/villages/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    const villageDropdown = document.getElementById('village_id');
                    villageDropdown.innerHTML = '<option value="">- Semua Kelurahan/Desa -</option>';
                    
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

            // Location dropdowns
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