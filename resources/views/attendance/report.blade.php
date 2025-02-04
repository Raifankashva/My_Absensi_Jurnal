@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Laporan Kehadiran Siswa</h2>
            
            <div class="flex space-x-2">
                <button id="export-pdf" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3a1 1 0 102 0V8zm-3 4a1 1 0 100 2h3a1 1 0 100-2H8z" clip-rule="evenodd" />
                    </svg>
                    Ekspor PDF
                </button>
                <button id="export-excel" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1zm4-1a1 1 0 00-1 1v6a1 1 0 102 0V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Ekspor Excel
                </button>
            </div>
        </div>

        <div class="p-6">
            <form id="filter-form" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sekolah</label>
                    <select name="sekolah_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">Semua Sekolah</option>
                        @foreach($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select name="kelas_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Kehadiran</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">Semua Status</option>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alfa">Alfa</option>
                        <option value="terlambat">Terlambat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Rentang Tanggal</label>
                    <div class="flex space-x-2">
                        <input type="date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300">
                        <input type="date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($attendances as $attendance)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->siswa->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->siswa->nisn }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->sekolah->nama_sekolah }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->kelas->nama_kelas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->attendance_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $attendance->status == 'hadir' ? 'bg-green-100 text-green-800' : 
                                       ($attendance->status == 'izin' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($attendance->status == 'sakit' ? 'bg-blue-100 text-blue-800' : 
                                       ($attendance->status == 'alfa' ? 'bg-red-100 text-red-800' : 
                                       'bg-gray-100 text-gray-800'))) }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="showAttendanceDetail({{ $attendance->id }})" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    @if(!$attendance->is_validated)
                                    <button onclick="validateAttendance({{ $attendance->id }})" class="text-green-600 hover:text-green-900">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>

    <!-- Attendance Detail Modal -->
    <div id="attendance-detail-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4" id="attendance-detail-content">
                    <!-- Modal Content Will Be Dynamically Populated -->
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeAttendanceDetailModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Filter functionality
    document.getElementById('filter-form').addEventListener('change', function() {
        this.submit();
    });

    // Export functionality
    document.getElementById('export-pdf').addEventListener('click', function() {
        const form = document.getElementById('filter-form');
        const formData = new FormData(form);
        
        // Redirect to PDF export route with query parameters
        window.location.href = "{{ route('attendance.export.pdf') }}?" + new URLSearchParams(formData).toString();
    });

    document.getElementById('export-excel').addEventListener('click', function() {
        const form = document.getElementById('filter-form');
        const formData = new FormData(form);
        
        // Redirect to Excel export route with query parameters
        window.location.href = "{{ route('attendance.export.excel') }}?" + new URLSearchParams(formData).toString();
    });

    // Attendance Detail Modal Functions
    function showAttendanceDetail(attendanceId) {
        fetch(`/attendance/${attendanceId}/detail`)
            .then(response => response.json())
            .then(data => {
                const modalContent = document.getElementById('attendance-detail-content');
                modalContent.innerHTML = `
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Absensi</h3>
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Siswa:</p>
                            <p class="font-semibold">${data.siswa.nama_lengkap}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NISN:</p>
                            <p class="font-semibold">${data.siswa.nisn}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Sekolah:</p>
                            <p class="font-semibold">${data.sekolah.nama_sekolah}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kelas:</p>
                            <p class="font-semibold">${data.kelas.nama_kelas}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal:</p>
                            <p class="font-semibold">${data.attendance_date}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status:</p>
                            <p class="font-semibold">${data.status}</p>
                        </div>
                    </div>
                    ${data.check_in_photo ? `
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Foto Check-In:</p>
                        <img src="${data.check_in_photo}" class="mt-2 w-full rounded-md" alt="Check-In Photo">
                    </div>` : ''}
                    ${data.keterangan ? `
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Keterangan:</p>
                        <p class="font-semibold">${data.keterangan}</p>
                    </div>` : ''}
                    `;
                document.getElementById('attendance-detail-modal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching attendance details:', error);
                alert('Gagal memuat detail absensi');
            });
    }

    function closeAttendanceDetailModal() {
        document.getElementById('attendance-detail-modal').classList.add('hidden');
    }

    function validateAttendance(attendanceId) {
        fetch(`/attendance/${attendanceId}/validate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the UI to remove validation button
                const row = document.querySelector(`tr:has(button[onclick="validateAttendance(${attendanceId})"])`);
                if (row) {
                    row.querySelector('td:last-child').innerHTML = `
                        <div class="text-green-600 flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Tervalidasi
                        </div>
                    `;
                }
                alert('Absensi berhasil divalidasi');
            } else {
                alert('Gagal memvalidasi absensi');
            }
        })
        .catch(error => {
            console.error('Error validating attendance:', error);
            alert('Terjadi kesalahan saat memvalidasi absensi');
        });
    }

    // Graphical Attendance Summary
    function renderAttendanceSummary() {
        const summaryContainer = document.getElementById('attendance-summary');
        
        // Fetch attendance summary data
        fetch('/attendance/summary')
            .then(response => response.json())
            .then(data => {
                // Create pie chart using Chart.js
                const ctx = document.createElement('canvas');
                summaryContainer.appendChild(ctx);

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Hadir', 'Izin', 'Sakit', 'Alfa', 'Terlambat'],
                        datasets: [{
                            data: [
                                data.hadir, 
                                data.izin, 
                                data.sakit, 
                                data.alfa, 
                                data.terlambat
                            ],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.6)',   // Hadir - Green
                                'rgba(255, 206, 86, 0.6)',   // Izin - Yellow
                                'rgba(54, 162, 235, 0.6)',   // Sakit - Blue
                                'rgba(255, 99, 132, 0.6)',   // Alfa - Red
                                'rgba(255, 159, 64, 0.6)'    // Terlambat - Orange
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Ringkasan Kehadiran'
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching attendance summary:', error);
            });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        renderAttendanceSummary();
    });
</script>

@endsection

