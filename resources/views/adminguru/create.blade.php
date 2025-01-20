<!-- resources/views/sekolahs/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Sekolah</h2>

        <form action="{{ route('sekolahs.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="npsn">NPSN</label>
                <input type="text" name="npsn" class="form-control" id="npsn" required>
            </div>

            <div class="form-group">
                <label for="nama_sekolah">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" class="form-control" id="nama_sekolah" required>
            </div>

            <div class="form-group">
                <label for="jenjang">Jenjang</label>
                <select name="jenjang" id="jenjang" class="form-control" required>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="SMK">SMK</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="Negeri">Negeri</option>
                    <option value="Swasta">Swasta</option>
                </select>
            </div>

            <!-- Data Provinsi, Kota, Kecamatan, Kelurahan -->
            <div class="form-group">
                <label for="province_id">Provinsi</label>
                <select name="province_id" id="province_id" class="form-control" required>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="city_id">Kota</label>
                <select name="city_id" id="city_id" class="form-control" required>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="district_id">Kecamatan</label>
                <select name="district_id" id="district_id" class="form-control" required>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="village_id">Kelurahan</label>
                <select name="village_id" id="village_id" class="form-control" required>
                    @foreach($villages as $village)
                        <option value="{{ $village->id }}">{{ $village->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Other Fields -->
            <div class="form-group">
                <label for="kode_pos">Kode Pos</label>
                <input type="text" name="kode_pos" class="form-control" id="kode_pos" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No Telepon</label>
                <input type="text" name="no_telp" class="form-control" id="no_telp" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input type="url" name="website" class="form-control" id="website">
            </div>

            <div class="form-group">
                <label for="akreditasi">Akreditasi</label>
                <input type="text" name="akreditasi" class="form-control" id="akreditasi">
            </div>

            <div class="form-group">
                <label for="kepala_sekolah">Kepala Sekolah</label>
                <input type="text" name="kepala_sekolah" class="form-control" id="kepala_sekolah" required>
            </div>

            <div class="form-group">
                <label for="nip_kepala_sekolah">NIP Kepala Sekolah</label>
                <input type="text" name="nip_kepala_sekolah" class="form-control" id="nip_kepala_sekolah">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
