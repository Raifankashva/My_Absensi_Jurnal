@extends('attendance.layouts.app')

@section('title', 'Absensi Hari Ini')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Absensi {{ now()->format('d F Y') }}</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jam Masuk</th>
                        <th>Status Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->siswa->nis }}</td>
                            <td>{{ $attendance->siswa->nama_lengkap }}</td>
                            <td>{{ $attendance->jam_masuk ? $attendance->jam_masuk->format('H:i:s') : '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $attendance->status_masuk == 'hadir' ? 'success' : ($attendance->status_masuk == 'telat' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($attendance->status_masuk) }}
                                </span>
                            </td>
                            <td>{{ $attendance->jam_pulang ? $attendance->jam_pulang->format('H:i:s') : '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $attendance->status_pulang == 'tepat' ? 'success' : ($attendance->status_pulang == 'awal' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($attendance->status_pulang) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data absensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection