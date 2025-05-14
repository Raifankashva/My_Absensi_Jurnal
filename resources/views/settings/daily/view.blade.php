@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-4 py-3 border-b">
            <h3 class="text-lg font-medium text-gray-900">Pengaturan Jadwal Harian - {{ $sekolah->nama_sekolah }}</h3>
        </div>

        <div class="p-4">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button class="tab-btn active py-2 px-4 border-b-2 border-blue-500 text-blue-600 font-medium" 
                            data-target="weekly">Pengaturan Mingguan</button>
                    <button class="tab-btn py-2 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium" 
                            data-target="calendar">Kalender Hari Libur</button>
                </nav>
            </div>

            <div class="tab-content mt-4">
                <!-- Tab Pengaturan Mingguan -->
                <div id="weekly" class="tab-pane block">
                    <form method="POST" action="{{ route('settings.daily.store') }}">
                        @csrf
                        <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">

                        <div class="overflow-x-auto mt-3">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktif</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Terlambat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($daysOfWeek as $day)
                                        @php $setting = $settings[$day] ?? null; @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $day }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                                           type="checkbox" 
                                                           name="is_active[]" 
                                                           value="{{ $loop->index }}" 
                                                           id="is_active_{{ $loop->index }}"
                                                           {{ ($setting && $setting->is_active) ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="time" 
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                       name="jam_masuk[]" 
                                                       value="{{ $setting->jam_masuk ?? '07:00' }}" 
                                                       required>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="time" 
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                       name="batas_terlambat[]" 
                                                       value="{{ $setting->batas_terlambat ?? '07:30' }}" 
                                                       required>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="time" 
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                       name="jam_pulang[]" 
                                                       value="{{ $setting->jam_pulang ?? '15:00' }}" 
                                                       required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab Kalender Hari Libur -->
                <div id="calendar-tab" class="tab-pane hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <div id="calendar"></div>
                        </div>
                        <div class="md:col-span-1">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="px-4 py-3 bg-gray-50 border-b">
                                    <h5 class="text-base font-medium text-gray-900">Tambah/Hapus Hari Libur</h5>
                                </div>
                                <div class="p-4">
                                    <form id="hariLiburForm" method="POST" action="{{ route('settings.daily.store-hari-libur') }}">
                                        @csrf
                                        <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">
                                        <input type="hidden" name="action" id="action" value="add">
                                        
                                        <div class="mb-4">
                                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                                            <input type="date" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                   id="tanggal" 
                                                   name="tanggal" 
                                                   required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                                            <input type="text" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                   id="keterangan" 
                                                   name="keterangan" 
                                                   required>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" 
                                                    id="submitBtn">Tambah Hari Libur</button>
                                            <button type="button" 
                                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 hidden" 
                                                    id="deleteBtn">Hapus Hari Libur</button>
                                            <button type="button" 
                                                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 hidden" 
                                                    id="cancelBtn">Batal</button>
                                        </div>
                                    </form>
                                    
                                    <div class="mt-6">
                                        <h5 class="text-base font-medium text-gray-900 mb-2">Daftar Hari Libur Bulan Ini</h5>
                                        <ul class="divide-y divide-gray-200">
                                            @forelse($hariLibur as $libur)
                                                <li class="py-2">
                                                    {{ $libur->tanggal->format('d F Y') }} - {{ $libur->keterangan }}
                                                </li>
                                            @empty
                                                <li class="py-2 text-gray-500">Tidak ada hari libur bulan ini</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    $formattedHariLibur = $hariLibur->map(function($item) {
        return [
            'id' => $item->id,
            'title' => $item->keterangan,
            'start' => $item->tanggal->format('Y-m-d'),
            'allDay' => true,
            'backgroundColor' => '#dc3545',
            'borderColor' => '#dc3545'
        ];
    });
@endphp

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
    .fc-daygrid-day.fc-day-today {
        background-color: #e6f7ff;
    }
    .fc-daygrid-day.fc-day-disabled {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    .fc-event {
        cursor: pointer;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/id.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and hide all panes
                tabButtons.forEach(btn => btn.classList.remove('active', 'border-blue-500', 'text-blue-600'));
                tabButtons.forEach(btn => btn.classList.add('border-transparent', 'text-gray-500'));
                tabPanes.forEach(pane => pane.classList.add('hidden'));
                
                // Add active class to clicked button and show corresponding pane
                button.classList.add('active', 'border-blue-500', 'text-blue-600');
                button.classList.remove('border-transparent', 'text-gray-500');
                
                const target = button.getAttribute('data-target');
                if (target === 'weekly') {
                    document.getElementById('weekly').classList.remove('hidden');
                } else if (target === 'calendar') {
                    document.getElementById('calendar-tab').classList.remove('hidden');
                    // Trigger window resize to fix calendar rendering
                    window.dispatchEvent(new Event('resize'));
                }
            });
        });
        
        // Calendar functionality
        var calendarEl = document.getElementById('calendar');
        var hariLiburData = @json($formattedHariLibur);

        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            events: hariLiburData,
            dateClick: function(info) {
                // Set tanggal yang diklik ke form
                document.getElementById('tanggal').value = info.dateStr;
                document.getElementById('keterangan').focus();
                
                // Cek apakah tanggal sudah ada di hari libur
                var existingEvent = hariLiburData.find(function(event) {
                    return event.start === info.dateStr;
                });
                
                if (existingEvent) {
                    // Mode edit/hapus
                    document.getElementById('action').value = 'delete';
                    document.getElementById('keterangan').value = existingEvent.title;
                    document.getElementById('submitBtn').classList.add('hidden');
                    document.getElementById('deleteBtn').classList.remove('hidden');
                    document.getElementById('cancelBtn').classList.remove('hidden');
                } else {
                    // Mode tambah baru
                    document.getElementById('action').value = 'add';
                    document.getElementById('keterangan').value = '';
                    document.getElementById('submitBtn').classList.remove('hidden');
                    document.getElementById('deleteBtn').classList.add('hidden');
                    document.getElementById('cancelBtn').classList.add('hidden');
                }
            },
            eventClick: function(info) {
                // Set data event yang diklik ke form
                document.getElementById('tanggal').value = info.event.startStr;
                document.getElementById('keterangan').value = info.event.title;
                document.getElementById('action').value = 'delete';
                
                document.getElementById('submitBtn').classList.add('hidden');
                document.getElementById('deleteBtn').classList.remove('hidden');
                document.getElementById('cancelBtn').classList.remove('hidden');
                
                info.el.style.borderColor = 'red';
            }
        });
        
        calendar.render();
        
        // Tangani tombol batal
        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.getElementById('tanggal').value = '';
            document.getElementById('keterangan').value = '';
            document.getElementById('action').value = 'add';
            
            document.getElementById('submitBtn').classList.remove('hidden');
            document.getElementById('deleteBtn').classList.add('hidden');
            document.getElementById('cancelBtn').classList.add('hidden');
        });
    });
</script>
@endsection