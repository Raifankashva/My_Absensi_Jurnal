@extends('layouts.app')

@section('title', 'Pengaturan Jadwal Harian Sekolah')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
            @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-6 max-w-4xl w-full animate-fade-in" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ $errors->first() }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button type="button" class="inline-flex text-red-500 hover:text-red-600 focus:outline-none">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Pengaturan Jadwal Harian Sekolah</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <ul class="nav nav-tabs" id="schoolTabs" role="tablist">
                        @foreach($sekolahs as $index => $sekolah)
                            <li class="nav-item">
                                <a class="nav-link {{ $index == 0 ? 'active' : '' }}" 
                                   id="school-{{ $sekolah->id }}-tab" 
                                   data-toggle="tab" 
                                   href="#school-{{ $sekolah->id }}" 
                                   role="tab" 
                                   aria-controls="school-{{ $sekolah->id }}" 
                                   aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                    {{ $sekolah->nama }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mt-3" id="schoolTabsContent">
                        @foreach($sekolahs as $index => $sekolah)
                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" 
                                 id="school-{{ $sekolah->id }}" 
                                 role="tabpanel" 
                                 aria-labelledby="school-{{ $sekolah->id }}-tab">

                                <form action="{{ route('settings.daily.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="bg-primary text-white">
                                                    <th width="15%">Hari</th>
                                                    <th width="20%">Jam Masuk</th>
                                                    <th width="20%">Batas Terlambat</th>
                                                    <th width="20%">Jam Pulang</th>
                                                    <th width="15%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $daysOfWeek = \App\Models\SettingDaily::getDaysOfWeek();
                                                    $schoolSettings = $settings->where('sekolah_id', $sekolah->id)
                                                                               ->keyBy('hari')
                                                                               ->toArray();
                                                @endphp

                                                @foreach($daysOfWeek as $dayIndex => $day)
                                                    @php
                                                        $setting = $schoolSettings[$day] ?? [
                                                            'jam_masuk' => '07:00',
                                                            'batas_terlambat' => '07:30',
                                                            'jam_pulang' => '15:00',
                                                            'is_active' => $day !== 'Minggu'
                                                        ];
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $day }}</td>
                                                        <td>
                                                            <input type="time" 
                                                                   class="form-control @error('jam_masuk.'.$dayIndex) is-invalid @enderror" 
                                                                   name="jam_masuk[{{ $dayIndex }}]" 
                                                                   value="{{ old('jam_masuk.'.$dayIndex, $setting['jam_masuk'] ?? '07:00') }}" 
                                                                   required>
                                                        </td>
                                                        <td>
                                                            <input type="time" 
                                                                   class="form-control @error('batas_terlambat.'.$dayIndex) is-invalid @enderror" 
                                                                   name="batas_terlambat[{{ $dayIndex }}]" 
                                                                   value="{{ old('batas_terlambat.'.$dayIndex, $setting['batas_terlambat'] ?? '07:30') }}" 
                                                                   required>
                                                        </td>
                                                        <td>
                                                            <input type="time" 
                                                                   class="form-control @error('jam_pulang.'.$dayIndex) is-invalid @enderror" 
                                                                   name="jam_pulang[{{ $dayIndex }}]" 
                                                                   value="{{ old('jam_pulang.'.$dayIndex, $setting['jam_pulang'] ?? '15:00') }}" 
                                                                   required>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" 
                                                                       class="custom-control-input" 
                                                                       id="is_active_{{ $sekolah->id }}_{{ $dayIndex }}" 
                                                                       name="is_active[{{ $dayIndex }}]" 
                                                                       {{ isset($setting['is_active']) && $setting['is_active'] ? 'checked' : '' }}>
                                                                <label class="custom-control-label" 
                                                                       for="is_active_{{ $sekolah->id }}_{{ $dayIndex }}">
                                                                    {{ isset($setting['is_active']) && $setting['is_active'] ? 'Aktif' : 'Non-aktif' }}
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-4 text-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i> Simpan Pengaturan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Toggle label text when switch is clicked
        $('.custom-control-input').change(function() {
            const label = $(this).siblings('.custom-control-label');
            if($(this).is(':checked')) {
                label.text('Aktif');
            } else {
                label.text('Non-aktif');
            }
        });
    });
</script>
@endsection
