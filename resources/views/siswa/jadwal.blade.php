@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Jadwal Pelajaran</h1>
            <p class="mt-1 text-sm text-gray-500">
                Semester {{ $user->dataSiswa->semester_aktif ?? 'Ganjil' }} Tahun Ajaran {{ $user->dataSiswa->tahun_ajaran ?? '2024/2025' }}
            </p>
        </div>

        <!-- Schedule Tabs -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex" aria-label="Tabs">
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                    <button 
                        onclick="showSchedule('{{ $hari }}')"
                        class="tab-btn w-1/6 py-4 px-1 text-center border-b-2 font-medium text-sm
                            {{ $loop->first ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        id="tab-{{ $hari }}"
                    >
                        {{ $hari }}
                    </button>
                    @endforeach
                </nav>
            </div>

            <!-- Schedule Content -->
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
            <div 
                id="schedule-{{ $hari }}" 
                class="schedule-content p-6 {{ !$loop->first ? 'hidden' : '' }}"
            >
                @if(isset($jadwalPerHari[$hari]) && $jadwalPerHari[$hari]->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($jadwalPerHari[$hari]->sortBy('waktu_mulai') as $jadwal)
                            <tr class="{{ Carbon\Carbon::now()->format('l') == $hari && 
                                        Carbon\Carbon::now()->between(
                                            Carbon\Carbon::parse($jadwal->waktu_mulai),
                                            Carbon\Carbon::parse($jadwal->waktu_selesai)
                                        ) ? 'bg-green-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - 
                                    {{ Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $jadwal->mata_pelajaran }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $jadwal->guru->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500">{{ $jadwal->guru->nip }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $jadwal->ruangan ?? 'Default' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Tidak ada jadwal pelajaran untuk hari {{ $hari }}</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function showSchedule(day) {
    // Hide all schedule contents
    document.querySelectorAll('.schedule-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-btn').forEach(tab => {
        tab.classList.remove('border-blue-500', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected schedule
    document.getElementById(`schedule-${day}`).classList.remove('hidden');
    
    // Activate selected tab
    document.getElementById(`tab-${day}`).classList.remove('border-transparent', 'text-gray-500');
    document.getElementById(`tab-${day}`).classList.add('border-blue-500', 'text-blue-600');
}
</script>

@endsection