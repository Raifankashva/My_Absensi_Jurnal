
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verifikasi Akun Sekolah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a6fdc;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            margin: 20px 0;
            background-color: #eee;
            border-radius: 5px;
            letter-spacing: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verifikasi Akun Sekolah</h1>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $user->name }}</strong></p>
            
            <p>Terima kasih telah mendaftar di sistem kami. Untuk memverifikasi akun Anda, silakan gunakan kode OTP berikut:</p>
            
            <div class="otp-code">{{ $otp }}</div>
            
            <p>Kode OTP ini akan kadaluarsa dalam 10 menit.</p>
            
            <p>Jika Anda tidak melakukan pendaftaran ini, silakan abaikan email ini.</p>
            
            <p>Salam,<br>Tim Administrasi</p>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>

{{-- resources/views/admin/schools/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Sekolah') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NPSN</th>
                                    <th>Nama Sekolah</th>
                                    <th>Jenjang</th>
                                    <th>Status</th>
                                    <th>Email</th>
                                    <th>Status Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schools as $index => $school)
                                <tr>
                                    <td>{{ $index + $schools->firstItem() }}</td>
                                    <td>{{ $school->npsn }}</td>
                                    <td>{{ $school->nama_sekolah }}</td>
                                    <td>{{ $school->jenjang }}</td>
                                    <td>{{ $school->status }}</td>
                                    <td>{{ $school->email }}</td>
                                    <td>
                                        @if ($school->user->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.schools.toggle-activation', $school->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $school->user->is_active ? 'btn-warning' : 'btn-success' }}">
                                                {{ $school->user->is_active ? 'Non-Aktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.schools.show', $school->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $schools->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>