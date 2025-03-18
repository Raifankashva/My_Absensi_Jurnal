@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Kelas</h5>
                    <a href="{{ route('kelas.school.create') }}" class="btn btn-primary">Tambah Kelas</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('kelas.school.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tingkat">Tingkat</label>
                                    <select name="tingkat" id="tingkat" class="form-control">
                                        <option value="">Semua Tingkat</option>
                                        <option value="1" {{ request('tingkat') == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ request('tingkat') == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ request('tingkat') == '3' ? 'selected' : '' }}>3</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>
                                    <th>Kapasitas</th>
                                    <th>Terisi</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Wali Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kelas as $index => $k)
                                <tr>
                                    <td>{{ $index + $kelas->firstItem() }}</td>
                                    <td>{{ $k->nama_kelas }}</td>
                                    <td>{{ $k->tingkat }}</td>
                                    <td>{{ $k->jurusan ?? '-' }}</td>
                                    <td>{{ $k->kapasitas }}</td>
                                    <td>{{ $k->siswa->count() }}</td>
                                    <td>{{ $k->tahun_ajaran }}</td>
                                    <td>{{ $k->semester }}</td>
                                    <td>{{ $k->wali_kelas ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('kelas.school.show', $k->id) }}" class="btn btn-sm btn-info">Detail</a>
                                            <a href="{{ route('kelas.school.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('kelas.school.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data kelas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $kelas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection