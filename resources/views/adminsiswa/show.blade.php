{{-- resources/views/adminsiswa/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Data Siswa</h5>
                    <div>
                        <a href="{{ route('adminsiswa.index') }}" class="btn btn-light btn-sm">Kembali</a>
                        <a href="{{ route('adminsiswa.edit', $dataSiswa->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Foto Profil -->
                        <div class="col-md-3 text-center mb-4">
                            <div class="border rounded p-2">
                                @if($dataSiswa->foto)
                                    <img src="{{ asset('storage/' . $dataSiswa->foto) }}" alt="Foto {{ $dataSiswa->nama_lengkap }}" 
                                         class="img-fluid rounded">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" 
                                         class="img-fluid rounded">
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Utama -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="border-bottom pb-2">Data Pribadi</h4>
                                </div>
                                
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">NISN</td>
                                            <td width="20">:</td>
                                            <td>{{ $dataSiswa->nisn }}</td>
                                        </tr>
                                        <tr>
                                            <td>NIS</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->nis }}</td>
                                        </tr>
                                        <tr>
                                            <td>NIK</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->nik }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Lengkap</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td>:</td>
                                            <td>{{ ucfirst($dataSiswa->jenis_kelamin) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">Tempat Lahir</td>
                                            <td width="20">:</td>
                                            <td>{{ $dataSiswa->tmp_lahir }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Lahir</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->tgl_lahir->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Agama</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->agama }}</td>
                                        </tr>
                                        <tr>
                                            <td>No. HP</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->hp ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->user->email }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Data Akademik -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4 class="border-bottom pb-2">Data Akademik</h4>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">Sekolah</td>
                                            <td width="20">:</td>
                                            <td>{{ $dataSiswa->sekolah->nama_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kelas</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->kelas->nama_kelas }} Tingkat : {{ $dataSiswa->kelas->tingkat }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Data Alamat -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4 class="border-bottom pb-2">Data Alamat</h4>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">Alamat Lengkap</td>
                                            <td width="20">:</td>
                                            <td>{{ $dataSiswa->fullAddressAttribute }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status Tinggal</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->tinggal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Transportasi</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->transport }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Data Orang Tua/Wali -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4 class="border-bottom pb-2">Data Orang Tua/Wali</h4>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">Nama Ayah</td>
                                            <td width="20">:</td>
                                            <td>{{ $dataSiswa->ayah }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pekerjaan Ayah</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->kerja_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Ibu</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->ibu }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pekerjaan Ibu</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->kerja_ibu ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">Nama Wali</td>
                                            <td width="20">:</td>
                                            <td>{{ $dataSiswa->wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pekerjaan Wali</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->kerja_wali ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Data Tambahan -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4 class="border-bottom pb-2">Data Tambahan</h4>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">Tinggi Badan</td>
                                            <td width="20">:</td>
                                            <td>{{ $dataSiswa->tb ? $dataSiswa->tb . ' cm' : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Berat Badan</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->bb ? $dataSiswa->bb . ' kg' : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">KKS</td>
                                            <td width="20">:</td>
                                            <td>{{ $dataSiswa->kks ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>KPH</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->kph ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>KIP</td>
                                            <td>:</td>
                                            <td>{{ $dataSiswa->kip ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-borderless td {
        padding: 0.5rem;
    }
    .card-header h5 {
        font-weight: 600;
    }
</style>

@endsection