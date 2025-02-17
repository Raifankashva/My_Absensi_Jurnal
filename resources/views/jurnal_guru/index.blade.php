@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Jurnal Pembelajaran</h5>
                    <div>
                        <a href="{{ route('jurnal-guru.create') }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-plus"></i> Isi Jurnal Hari Ini
                        </a>
                        <a href="{{ route('jurnal-guru.laporan') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-file-alt"></i> Laporan
                        </a>
                    </div>
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Materi</th>
                                    <th>Hadir/Tidak Hadir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jurnalGuru as $index => $jurnal)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $jurnal->tanggal->format('d-m-Y') }}</td>
                                    <td>{{ $jurnal->kelas->nama_kelas }}</td>
                                    <td>{{ $jurnal->jadwalPelajaran->mata_pelajaran }}</td>
                                    <td>{{ Str::limit($jurnal->materi_yang_disampaikan, 50) }}</td>
                                    <td>{{ $jurnal->jumlah_siswa_hadir }}/{{ $jurnal->jumlah_siswa_tidak_hadir }}</td>
                                    <td>
                                        @if($jurnal->status_pertemuan == 'Terlaksana')
                                            <span class="badge bg-success">Terlaksana</span>
                                        @elseif($jurnal->status_pertemuan == 'Diganti')
                                            <span class="badge bg-warning">Diganti</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('jurnal-guru.show', $jurnal->id) }}" class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('jurnal-guru.edit', $jurnal->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('jurnal-guru.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jurnal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data jurnal</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $jurnalGuru->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection