{{-- resources/views/datasiswa/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Tambah Data Siswa</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('adminsiswa.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            
            {{-- Data Sekolah --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Data Sekolah</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sekolah</label>
                        <select name="sekolah_id" id="sekolah_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Pilih Sekolah</option>
                            @foreach($sekolahs as $sekolah)
                                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Pilih Kelas</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Data Pribadi --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Data Pribadi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NISN</label>
                        <input type="text" name="nisn" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required maxlength="10">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIS</label>
                        <input type="text" name="nis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required maxlength="10">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIK</label>
                        <input type="text" name="nik" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required maxlength="16">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Agama</label>
                        <select name="agama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach($religions as $religion)
                                <option value="{{ $religion }}">{{ $religion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tmp_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
    <input type="date" name="tgl_lahir" id="tgl_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">kode Pos</label>
                        <input type="text" name="kode_pos" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                </div>
            </div>

            {{-- Data Alamat --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Data Alamat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div >
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" name="alamat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <select name="province_id" id="province_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                        <select name="city_id" id="city_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <select name="district_id" id="district_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                        <select name="village_id" id="village_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Data Orang Tua --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Data Orang Tua</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                        <input type="text" name="ayah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                        <input type="text" name="kerja_ayah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="email_ayah" class="block text-sm font-medium text-gray-700">Email Ayah</label>
                        <Input type="email" name="email_ayah" id="email_ayah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                        <input type="text" name="ibu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                        <input type="text" name="kerja_ibu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="email_ibu" class="block text-sm font-medium text-gray-700">Email Ibu</label>
                        <Input type="email" name="email_ibu" id="email_ibu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            {{-- Data Tambahan (continued) --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Data Tambahan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                        <input type="number" name="tb" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                        <input type="number" name="bb" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">HP</label>
                        <input type="text" name="no_hp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tinggal Dengan</label>
                        <select name="tinggal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach($livingOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Transportasi</label>
                        <input type="text" name="transport" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                </div>
            </div>

            {{-- Program Bantuan --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Program Bantuan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. KKS</label>
                        <input type="text" name="kks" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. KPH</label>
                        <input type="text" name="kph" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. KIP</label>
                        <input type="text" name="kip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            {{-- Upload Foto --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Foto Siswa</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Upload Foto</label>
                    <input type="file" name="foto" class="mt-1 block w-full" accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, maksimal 2MB</p>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">User</h2>
                
                <div >
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>

            </div>
            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // School-Class Dynamic Dropdown
    const sekolahSelect = document.getElementById('sekolah_id');
    const kelasSelect = document.getElementById('kelas_id');
    
    sekolahSelect.addEventListener('change', function() {
        const sekolahId = this.value;
        kelasSelect.innerHTML = '<option value="">Loading...</option>';
        
        if (sekolahId) {
            fetch(`/get-kelas/${sekolahId}`)
                .then(response => response.json())
                .then(data => {
                    kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
                    data.forEach(kelas => {
                        kelasSelect.innerHTML += `<option value="${kelas.id}">${kelas.nama_kelas}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    kelasSelect.innerHTML = '<option value="">Error loading kelas</option>';
                });
        } else {
            kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
        }
    });

    // Location Cascade Dropdowns
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const villageSelect = document.getElementById('village_id');

    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        resetDropdowns(['city', 'district', 'village']);
        
        if (provinceId) {
            fetchLocations('cities', provinceId, citySelect);
        }
    });

    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        resetDropdowns(['district', 'village']);
        
        if (cityId) {
            fetchLocations('districts', cityId, districtSelect);
        }
    });

    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        resetDropdowns(['village']);
        
        if (districtId) {
            fetchLocations('villages', districtId, villageSelect);
        }
    });

    function resetDropdowns(types) {
        types.forEach(type => {
            const select = document.getElementById(`${type}_id`);
            select.innerHTML = `<option value="">Pilih ${type.charAt(0).toUpperCase() + type.slice(1)}</option>`;
        });
    }

    function fetchLocations(type, parentId, selectElement) {
        selectElement.innerHTML = '<option value="">Loading...</option>';
        
        fetch(`/get-${type}/${parentId}`)
            .then(response => response.json())
            .then(data => {
                selectElement.innerHTML = `<option value="">Pilih ${type.charAt(0).toUpperCase() + type.slice(1)}</option>`;
                data.forEach(item => {
                    selectElement.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                selectElement.innerHTML = `<option value="">Error loading ${type}</option>`;
            });
    }
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputDate = document.getElementById("tgl_lahir");
        const today = new Date();
        today.setFullYear(today.getFullYear() - 6); // Kurangi 6 tahun dari hari ini
        const maxDate = today.toISOString().split("T")[0]; // Format YYYY-MM-DD
        inputDate.setAttribute("max", maxDate);
    });
</script>


@endsection