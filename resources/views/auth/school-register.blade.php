{{-- resources/views/auth/school-register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pendaftaran Sekolah Baru') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('school.register') }}" enctype="multipart/form-data">
                        @csrf

                        <h4 class="mb-3">Informasi Akun</h4>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Admin') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Konfirmasi Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat Admin') }}</label>

                            <div class="col-md-6">
                                <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" required>

                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_hp" class="col-md-4 col-form-label text-md-end">{{ __('No. HP Admin') }}</label>

                            <div class="col-md-6">
                                <input id="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" required>

                                @error('no_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h4 class="mb-3">Informasi Sekolah</h4>

                        <div class="row mb-3">
                            <label for="npsn" class="col-md-4 col-form-label text-md-end">{{ __('NPSN') }}</label>

                            <div class="col-md-6">
                                <input id="npsn" type="text" class="form-control @error('npsn') is-invalid @enderror" name="npsn" value="{{ old('npsn') }}" required maxlength="8">

                                @error('npsn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama_sekolah" class="col-md-4 col-form-label text-md-end">{{ __('Nama Sekolah') }}</label>

                            <div class="col-md-6">
                                <input id="nama_sekolah" type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required>

                                @error('nama_sekolah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenjang" class="col-md-4 col-form-label text-md-end">{{ __('Jenjang') }}</label>

                            <div class="col-md-6">
                                <select id="jenjang" class="form-control @error('jenjang') is-invalid @enderror" name="jenjang" required>
                                    <option value="">Pilih Jenjang</option>
                                    <option value="SD" {{ old('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ old('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="SMK" {{ old('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                                </select>

                                @error('jenjang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Negeri" {{ old('status') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                    <option value="Swasta" {{ old('status') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Region fields (Province, City, District, Village) -->
                        <div class="row mb-3">
                            <label for="province_id" class="col-md-4 col-form-label text-md-end">{{ __('Provinsi') }}</label>

                            <div class="col-md-6">
                                <select id="province_id" class="form-control @error('province_id') is-invalid @enderror" name="province_id" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>

                                @error('province_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="city_id" class="col-md-4 col-form-label text-md-end">{{ __('Kabupaten/Kota') }}</label>

                            <div class="col-md-6">
                                <select id="city_id" class="form-control @error('city_id') is-invalid @enderror" name="city_id" required>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>

                                @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="district_id" class="col-md-4 col-form-label text-md-end">{{ __('Kecamatan') }}</label>

                            <div class="col-md-6">
                                <select id="district_id" class="form-control @error('district_id') is-invalid @enderror" name="district_id" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>

                                @error('district_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="village_id" class="col-md-4 col-form-label text-md-end">{{ __('Kelurahan/Desa') }}</label>

                            <div class="col-md-6">
                                <select id="village_id" class="form-control @error('village_id') is-invalid @enderror" name="village_id" required>
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>

                                @error('village_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat Sekolah') }}</label>

                            <div class="col-md-6">
                                <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required>{{ old('alamat') }}</textarea>

                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="kode_pos" class="col-md-4 col-form-label text-md-end">{{ __('Kode Pos') }}</label>

                            <div class="col-md-6">
                                <input id="kode_pos" type="text" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" value="{{ old('kode_pos') }}" required maxlength="5">

                                @error('kode_pos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_telp" class="col-md-4 col-form-label text-md-end">{{ __('No. Telepon Sekolah') }}</label>

                            <div class="col-md-6">
                                <input id="no_telp" type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ old('no_telp') }}" required>

                                @error('no_telp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="website" class="col-md-4 col-form-label text-md-end">{{ __('Website') }}</label>

                            <div class="col-md-6">
                                <input id="website" type="url" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website') }}">

                                @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="akreditasi" class="col-md-4 col-form-label text-md-end">{{ __('Akreditasi') }}</label>

                            <div class="col-md-6">
                                <select id="akreditasi" class="form-control @error('akreditasi') is-invalid @enderror" name="akreditasi">
                                    <option value="">Pilih Akreditasi</option>
                                    <option value="A" {{ old('akreditasi') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('akreditasi') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('akreditasi') == 'C' ? 'selected' : '' }}>C</option>
                                </select>

                                @error('akreditasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="kepala_sekolah" class="col-md-4 col-form-label text-md-end">{{ __('Nama Kepala Sekolah') }}</label>

                            <div class="col-md-6">
                                <input id="kepala_sekolah" type="text" class="form-control @error('kepala_sekolah') is-invalid @enderror" name="kepala_sekolah" value="{{ old('kepala_sekolah') }}" required>

                                @error('kepala_sekolah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nip_kepala_sekolah" class="col-md-4 col-form-label text-md-end">{{ __('NIP Kepala Sekolah') }}</label>

                            <div class="col-md-6">
                                <input id="nip_kepala_sekolah" type="text" class="form-control @error('nip_kepala_sekolah') is-invalid @enderror" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah') }}" maxlength="18">

                                @error('nip_kepala_sekolah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foto" class="col-md-4 col-form-label text-md-end">{{ __('Foto Sekolah') }}</label>

                            <div class="col-md-6">
                                <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">

                                @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Daftar') }}
                                    </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Load cities when province is selected
        $('#province_id').change(function() {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: '/api/cities/' + provinceId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#city_id').empty();
                        $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>');
                        $.each(data, function(key, value) {
                            $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#city_id').empty();
                $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>');
            }
            $('#district_id').empty();
            $('#district_id').append('<option value="">Pilih Kecamatan</option>');
            $('#village_id').empty();
            $('#village_id').append('<option value="">Pilih Kelurahan/Desa</option>');
        });

        // Load districts when city is selected
        $('#city_id').change(function() {
            var cityId = $(this).val();
            if (cityId) {
                $.ajax({
                    url: '/api/districts/' + cityId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#district_id').empty();
                        $('#district_id').append('<option value="">Pilih Kecamatan</option>');
                        $.each(data, function(key, value) {
                            $('#district_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#district_id').empty();
                $('#district_id').append('<option value="">Pilih Kecamatan</option>');
            }
            $('#village_id').empty();
            $('#village_id').append('<option value="">Pilih Kelurahan/Desa</option>');
        });

        // Load villages when district is selected
        $('#district_id').change(function() {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: '/api/villages/' + districtId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#village_id').empty();
                        $('#village_id').append('<option value="">Pilih Kelurahan/Desa</option>');
                        $.each(data, function(key, value) {
                            $('#village_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#village_id').empty();
                $('#village_id').append('<option value="">Pilih Kelurahan/Desa</option>');
            }
        });
    });
</script>

@endsection