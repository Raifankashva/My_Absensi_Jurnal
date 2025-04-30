@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pengaturan Jadwal Harian {{ $sekolah->nama }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('settings.daily.store') }}">
                        @csrf
                        <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">
                        
                        <div class="alert alert-info">
                            <strong>Catatan:</strong> Anda dapat mengatur jadwal berbeda untuk setiap hari dalam seminggu.
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Masuk</th>
                                    <th>Batas Terlambat</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($daysOfWeek as $index => $hari)
                                <tr>
                                    <td>
                                        <input type="hidden" name="hari[{{ $index }}]" value="{{ $hari }}">
                                        <strong>{{ $hari }}</strong>
                                    </td>
                                    <td>
                                        <input type="time" class="form-control" name="jam_masuk[{{ $index }}]" 
                                            value="{{ $settings[$hari]->jam_masuk }}" required>
                                    </td>
                                    <td>
                                        <input type="time" class="form-control" name="batas_terlambat[{{ $index }}]" 
                                            value="{{ $settings[$hari]->batas_terlambat }}" required>
                                    </td>
                                    <td>
                                        <input type="time" class="form-control" name="jam_pulang[{{ $index }}]" 
                                            value="{{ $settings[$hari]->jam_pulang }}" required>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_active[{{ $index }}]" 
                                                id="active_{{ $index }}" {{ $settings[$hari]->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active_{{ $index }}">
                                                Aktif
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection