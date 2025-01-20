@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white py-8">
    <div class="container mx-auto max-w-4xl px-4">
        <!-- Card Container -->
        <div class="rounded-xl bg-white p-8 shadow-lg">
            <!-- Header -->
            <h2 class="mb-8 text-2xl font-bold text-blue-900">
                {{ isset($sekolah) ? 'Edit Sekolah' : 'Tambah Sekolah' }}
            </h2>

            <form action="{{ isset($sekolah) ? route('sekolah.update', $sekolah->id) : route('sekolah.store') }}" 
                  method="POST" 
                  class="space-y-6">
                @csrf
                @if(isset($sekolah))
                    @method('PUT')
                @endif

                <!-- Grid Layout for Form -->
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- NPSN -->
                    <div class="form-group">
                        <label for="npsn" class="mb-2 block text-sm font-medium text-gray-700">NPSN</label>
                        <input type="text" 
                               name="npsn" 
                               id="npsn" 
                               value="{{ old('npsn', $sekolah->npsn ?? '') }}" 
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                               required>
                    </div>

                    <!-- Nama Sekolah -->
                    <div class="form-group">
                        <label for="nama_sekolah" class="mb-2 block text-sm font-medium text-gray-700">Nama Sekolah</label>
                        <input type="text" 
                               name="nama_sekolah" 
                               id="nama_sekolah" 
                               value="{{ old('nama_sekolah', $sekolah->nama_sekolah ?? '') }}" 
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                               required>
                    </div>

                    <!-- Jenjang -->
                    <div class="form-group">
                        <label for="jenjang" class="mb-2 block text-sm font-medium text-gray-700">Jenjang</label>
                        <select name="jenjang" 
                                id="jenjang" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                required>
                            <option value="SD" {{ old('jenjang', $sekolah->jenjang ?? '') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('jenjang', $sekolah->jenjang ?? '') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('jenjang', $sekolah->jenjang ?? '') == 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="SMK" {{ old('jenjang', $sekolah->jenjang ?? '') == 'SMK' ? 'selected' : '' }}>SMK</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" 
                                id="status" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                required>
                            <option value="Negeri" {{ old('status', $sekolah->status ?? '') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                            <option value="Swasta" {{ old('status', $sekolah->status ?? '') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                        </select>
                    </div>  

                    <!-- Alamat -->
                    <div class="form-group">
                        <label for="alamat" class="mb-2 block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" 
                               name="alamat" 
                               id="alamat" 
                               value="{{ old('alamat', $sekolah->alamat ?? '') }}" 
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                               required>
                    </div>
                    

                    <!-- Location Section -->
                    <div class="col-span-2">
                        <h3 class="mb-4 text-lg font-semibold text-blue-900">Lokasi</h3>
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Provinsi -->
                            <div class="form-group">
                                <label for="province_id" class="mb-2 block text-sm font-medium text-gray-700">Provinsi</label>
                                <select name="province_id" 
                                        id="province_id" 
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" 
                                                {{ old('province_id', $sekolah->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kota -->
                            <div class="form-group">
                                <label for="city_id" class="mb-2 block text-sm font-medium text-gray-700">Kota</label>
                                <select name="city_id" 
                                        id="city_id" 
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        required>
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>

                            <!-- Kecamatan -->
                            <div class="form-group">
                                <label for="district_id" class="mb-2 block text-sm font-medium text-gray-700">Kecamatan</label>
                                <select name="district_id" 
                                        id="district_id" 
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <!-- Kelurahan -->
                            <div class="form-group">
                                <label for="village_id" class="mb-2 block text-sm font-medium text-gray-700">Kelurahan</label>
                                <select name="village_id" 
                                        id="village_id" 
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        required>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-span-2">
                        <h3 class="mb-4 text-lg font-semibold text-blue-900">Informasi Kontak</h3>
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Kode Pos -->
                            <div class="form-group">
                                <label for="kode_pos" class="mb-2 block text-sm font-medium text-gray-700">Kode Pos</label>
                                <input type="text" 
                                       name="kode_pos" 
                                       id="kode_pos" 
                                       value="{{ old('kode_pos', $sekolah->kode_pos ?? '') }}" 
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                       required>
                            </div>

                            <!-- No Telepon -->
                            <div class="form-group">
                                <label for="no_telp" class="mb-2 block text-sm font-medium text-gray-700">No Telepon</label>
                                <input type="text" 
                                       name="no_telp" 
                                       id="no_telp" 
                                       value="{{ old('no_telp', $sekolah->no_telp ?? '') }}" 
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                       required>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $sekolah->email ?? '') }}" 
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                       required>
                            </div>

                            <!-- Website -->
                            <div class="form-group">
                                <label for="website" class="mb-2 block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" 
                                       name="website" 
                                       id="website" 
                                       value="{{ old('website', $sekolah->website ?? '') }}" 
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                        </div>
                    </div>

                    <!-- School Information -->
                    <div class="col-span-2">
                        <h3 class="mb-4 text-lg font-semibold text-blue-900">Informasi Sekolah</h3>
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Akreditasi -->
                            <div class="form-group">
                                <label for="akreditasi" class="mb-2 block text-sm font-medium text-gray-700">Akreditasi</label>
                                <input type="text" 
                                       name="akreditasi" 
                                       id="akreditasi" 
                                       value="{{ old('akreditasi', $sekolah->akreditasi ?? '') }}" 
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>

                            <!-- Kepala Sekolah -->
                            <div class="form-group">
                                <label for="kepala_sekolah" class="mb-2 block text-sm font-medium text-gray-700">Kepala Sekolah</label>
                                <input type="text" 
                                       name="kepala_sekolah" 
                                       id="kepala_sekolah" 
                                       value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah ?? '') }}" 
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                       required>
                            </div>

                            <!-- NIP Kepala Sekolah -->
                            <div class="form-group">
                                <label for="nip_kepala_sekolah" class="mb-2 block text-sm font-medium text-gray-700">NIP Kepala Sekolah</label>
                                <input type="text" 
                                       name="nip_kepala_sekolah" 
                                       id="nip_kepala_sekolah" 
                                       value="{{ old('nip_kepala_sekolah', $sekolah->nip_kepala_sekolah ?? '') }}" 
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" 
                            onclick="window.history.back()" 
                            class="rounded-lg bg-gray-100 px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                    <button type="submit" 
                            class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to selects
    function setLoading(selectElement) {
        selectElement.innerHTML = '<option value="">Loading...</option>';
        selectElement.disabled = true;
    }

    // Remove loading state from selects
    function removeLoading(selectElement) {
        selectElement.disabled = false;
    }

    // Add error handling
    function handleError(error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
    }

    // Fetch data with loading state
    async function fetchLocationData(url, selectElement) {
        try {
            setLoading(selectElement);
            const response = await fetch(url);
            const data = await response.json();
            
            selectElement.innerHTML = '<option value="">Pilih...</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name;
                selectElement.appendChild(option);
            });
        } catch (error) {
            handleError(error);
        } finally {
            removeLoading(selectElement);
        }
    }

    // Province change handler
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    provinceSelect.addEventListener('change', function() {
        if (this.value) {
            fetchLocationData(`/api/cities/${this.value}`, citySelect);
        }
    });

    // City change handler
    const districtSelect = document.getElementById('district_id');
    citySelect.addEventListener('change', function() {
        if (this.value) {
            fetchLocationData(`/api/districts/${this.value}`, districtSelect);
        }
    });

    // District change handler
    const villageSelect = document.getElementById('village_id');
    districtSelect.addEventListener('change', function() {
        if (this.value) {
            fetchLocationData(`/api/villages/${this.value}`, villageSelect);
        }
    });
});

</script>

@endsection


