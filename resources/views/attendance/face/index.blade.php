@extends('attendance.layouts.app')

@section('title', 'Data Wajah Siswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Data Wajah Siswa</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Status Data Wajah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->nis }}</td>
                            <td>{{ $student->nama_lengkap }}</td>
                            <td>
                                @if($student->faceData)
                                    <span class="badge bg-success">Terdaftar</span>
                                @else
                                    <span class="badge bg-danger">Belum Terdaftar</span>
                                @endif
                            </td>
                            <td>
                                @if(!$student->faceData)
                                    <a href="{{ route('face.create', $student) }}" class="btn btn-sm btn-primary">Daftarkan Wajah</a>
                                @else
                                    <form action="{{ route('face.destroy', $student->faceData) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data wajah?')">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection