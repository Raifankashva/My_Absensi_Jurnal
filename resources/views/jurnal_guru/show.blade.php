@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Jurnal Pembelajaran</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Tanggal:</dt>
                                <dd class="col-sm-8">{{ $jurnal->tanggal->format('d F Y') }}</dd>
                                
                                <dt class="col-sm-4">Guru:</dt>
                                <dd class="col-sm-8">{{ $jurnal->guru->nama_lengkap }}</dd>
                                
                                <dt class="col-sm-4">Kelas:</dt>
                                <dd class="col-sm-8">{{ $jurnal->kelas->nama_kelas }}</dd>
                                
                                <dt class="col-sm-4">Mata Pelajaran:</dt>
                                <dd class="col-sm-8">{{ $jurnal->jadwalPelajaran->mata_pelajaran }}</dd>
                            </dl>
                        </div>
                        
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">Jam Pelajaran:</dt>
                                <dd class="col-sm-7">{{ substr($jurnal->jadwalPelajaran->jam_mulai, 0, 5) }} - {{ substr($jurnal->jadwalPelajaran->jam_selesai, 0, 5) }}</dd>
                                
                                <dt class="col-sm-5">Status Pertemuan:</dt>
                                <dd class="col-sm-7">
                                    @if($jurnal->status_pertemuan == 'Terlaksana')
                                        <span class="badge bg-success">Terlaksana</span>
                                    @elseif($jurnal->status_pertemuan == 'Diganti')
                                        <span class="badge bg-warning">Diganti</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-5">Jumlah Siswa Hadir:</dt>
                                <dd class="col-sm-7">{{ $jurnal->jumlah_siswa_hadir }} siswa</dd>
                                
                                <dt class="col-sm-5">Jumlah Siswa Tidak Hadir:</dt>
                                <dd class="col-sm-7">{{ $jurnal->jumlah_siswa_tidak_hadir }} siswa</dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6 class="font-weight-bold">Materi yang Disampaikan:</h6>
                            <div class="p-3 bg-light rounded mb-3">
                                {!! nl2br(e($jurnal->materi_yang_disampaikan)) !!}
                            </div>
                            
                            @if($jurnal->catatan_pembelajaran)
                            <h6 class="font-weight-bold">Catatan Pembelajaran:</h6>
                            <div class="p-3 bg-light rounded mb-3">
                                {!! nl2br(e($jurnal->catatan_pembelajaran)) !!}
                            </div>
                            @endif
                            
                            @if($jurnal->data_siswa_tidak_hadir && count($jurnal->data_siswa_tidak_hadir) > 0)
                            <h6 class="font-weight-bold">Data Siswa Tidak Hadir:</h6>
                            <ul class="list-group mb-3">
                                @foreach($jurnal->data_siswa_tidak_hadir as $siswa)
                                <li class="list-group-item">{{ $siswa }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-between">
                            <a href="{{ route('jurnal-guru.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <div>
                                <a href="{{ route('jurnal-guru.edit', $jurnal->id) }}" class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('jurnal-guru.destroy', $jurnal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jurnal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection