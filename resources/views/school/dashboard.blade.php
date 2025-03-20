@extends('layouts.app')

@section('content')
<div class="py-8 bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with gradient background -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 shadow-lg mb-8 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <h1 class="text-3xl font-bold text-white">Dashboard Sekolah</h1>
            <img src="{{ asset('storage/' . $sekolah->foto) }}" alt="Foto {{ $sekolah->nama_sekolah }}" class="w-16 h-16 rounded-md">
            <h2 class="text-xl font-medium text-blue-100">{{ $sekolah->nama_sekolah }}</h2>
        </div>

        <!-- Stats Cards -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Students Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-blue-100">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-3 shadow-md">
                            <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Siswa</dt>
                                <dd class="text-3xl font-bold text-blue-700">{{ $totalSiswa }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('school.students') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 flex items-center">
                            Lihat semua siswa
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Teachers Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-blue-100">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg p-3 shadow-md">
                            <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Guru</dt>
                                <dd class="text-3xl font-bold text-blue-700">{{ $totalGuru }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('adminguru.index') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 flex items-center">
                            Lihat semua guru
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Classes Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-blue-100">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-700 rounded-lg p-3 shadow-md">
                            <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Kelas</dt>
                                <dd class="text-3xl font-bold text-blue-700">{{ $totalKelas }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('kelassekolah.index') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 flex items-center">
                            Lihat semua kelas
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Capacity Utilization Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-blue-100">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-indigo-500 to-blue-700 rounded-lg p-3 shadow-md">
                            <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Kapasitas Terpakai</dt>
                                <dd class="text-3xl font-bold text-blue-700">
                                    @php
                                    $totalKapasitas = $kelasUtilization->sum('kapasitas');
                                    $totalTerpakai = $kelasUtilization->sum(function($kelas) {
                                    return $kelas->kapasitas - $kelas->sisa_kapasitas;
                                    });
                                    $percentUsed = $totalKapasitas > 0 ? round(($totalTerpakai / $totalKapasitas) * 100) : 0;
                                    @endphp
                                    {{ $percentUsed }}%
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('school.classes.capacity') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 flex items-center">
                            Lihat kapasitas kelas
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Tables Section -->
        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Student Distribution by Gender -->
            <div class="bg-white shadow-md rounded-xl p-6 transition-all duration-300 hover:shadow-xl border border-blue-100">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Distribusi Siswa Berdasarkan Jenis Kelamin</h3>
                <div class="mt-4 h-64 bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <!-- Class Distribution by Grade -->
            <div class="bg-white shadow-md rounded-xl p-6 transition-all duration-300 hover:shadow-xl border border-blue-100">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Distribusi Kelas Berdasarkan Tingkat</h3>
                <div class="mt-4 h-64 bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>

            <!-- Teacher Distribution by Status -->
            <div class="bg-white shadow-md rounded-xl p-6 transition-all duration-300 hover:shadow-xl border border-blue-100">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Distribusi Guru Berdasarkan Status Kepegawaian</h3>
                <div class="mt-4 h-64 bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg">
                    <canvas id="teacherStatusChart"></canvas>
                </div>
            </div>

            <!-- Class Capacity Utilization -->
            <div class="bg-white shadow-md rounded-xl p-6 transition-all duration-300 hover:shadow-xl border border-blue-100">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Utilisasi Kapasitas Kelas</h3>
                <div class="mt-4 h-64 bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg">
                    <canvas id="capacityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Records Section -->
        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Recent Students -->
            <div class="bg-white shadow-md rounded-xl transition-all duration-300 hover:shadow-xl border border-blue-100">
                <div class="px-4 py-5 border-b border-blue-100 sm:px-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-t-xl">
                    <h3 class="text-lg font-semibold text-white">Siswa Terbaru</h3>
                </div>
                <div class="divide-y divide-blue-100">
                    @foreach($latestSiswa as $siswa)
                    <div class="px-4 py-4 sm:px-6 transition-colors duration-300 hover:bg-blue-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                @if($siswa->foto)
                                <img class="h-12 w-12 rounded-full object-cover border-2 border-blue-200 shadow-sm" src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                @else
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold shadow-sm">
                                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                                </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-blue-800">
                                    <a href="{{ route('school.student.show', $siswa->id) }}" class="hover:text-blue-600 transition-colors duration-300">{{ $siswa->nama_lengkap }}</a>
                                </div>
                                <div class="text-sm text-gray-500">
                                    NISN: {{ $siswa->nisn }} | Kelas: {{ $siswa->kelas->nama_kelas }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-4 sm:px-6 text-right rounded-b-xl">
                    <a href="{{ route('school.students') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 inline-flex items-center">
                        Lihat semua siswa
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Recent Teachers -->
            <div class="bg-white shadow-md rounded-xl transition-all duration-300 hover:shadow-xl border border-blue-100">
                <div class="px-4 py-5 border-b border-blue-100 sm:px-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-t-xl">
                    <h3 class="text-lg font-semibold text-white">Guru Terbaru</h3>
                </div>
                <div class="divide-y divide-blue-100">
                    @foreach($latestGuru as $guru)
                    <div class="px-4 py-4 sm:px-6 transition-colors duration-300 hover:bg-blue-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                @if($guru->foto)
                                <img class="h-12 w-12 rounded-full object-cover border-2 border-blue-200 shadow-sm" src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama_lengkap }}">
                                @else
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold shadow-sm">
                                    {{ substr($guru->nama_lengkap, 0, 1) }}
                                </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-blue-800">
                                    <a href="{{ route('school.teacher.show', $guru->id) }}" class="hover:text-blue-600 transition-colors duration-300">{{ $guru->nama_lengkap }}</a>
                                </div>
                                <div class="text-sm text-gray-500">
                                    @php
                                    $mapelArray = is_array($guru->mata_pelajaran) ? $guru->mata_pelajaran : json_decode($guru->mata_pelajaran, true);
                                    $mapelString = implode(', ', array_slice($mapelArray, 0, 2));
                                    if (count($mapelArray) > 2) {
                                    $mapelString .= ' +' . (count($mapelArray) - 2);
                                    }
                                    @endphp
                                    {{ $guru->status_kepegawaian }} | {{ $mapelString }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-4 sm:px-6 text-right rounded-b-xl">
                    <a href="{{ route('school.teachers') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 inline-flex items-center">
                        Lihat semua guru
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Custom blue color palette for charts
        const blueColors = [
            'rgba(37, 99, 235, 0.8)',   // blue-600
            'rgba(79, 70, 229, 0.8)',   // indigo-600
            'rgba(59, 130, 246, 0.8)',  // blue-500
            'rgba(99, 102, 241, 0.8)',  // indigo-500
            'rgba(147, 197, 253, 0.8)', // blue-300
        ];
        
        const blueColorsBorders = [
            'rgba(37, 99, 235, 1)',   // blue-600
            'rgba(79, 70, 229, 1)',   // indigo-600
            'rgba(59, 130, 246, 1)',  // blue-500
            'rgba(99, 102, 241, 1)',  // indigo-500
            'rgba(147, 197, 253, 1)', // blue-300
        ];

        // Add animation to all charts
        const animationOptions = {
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            family: 'Inter, system-ui, sans-serif',
                            size: 12
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.8)',
                    titleFont: {
                        family: 'Inter, system-ui, sans-serif',
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: 'Inter, system-ui, sans-serif',
                        size: 13
                    },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    boxPadding: 6
                }
            }
        };

        // Gender distribution chart
        const genderData = @json($siswaByGender);
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: genderData.map(item => item.jenis_kelamin === 'laki-laki' ? 'Laki-laki' : 'Perempuan'),
                datasets: [{
                    data: genderData.map(item => item.total),
                    backgroundColor: [blueColors[0], blueColors[1]],
                    borderColor: [blueColorsBorders[0], blueColorsBorders[1]],
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                ...animationOptions,
                cutout: '0%'
            }
        });

        // Grade distribution chart
        const gradeData = @json($kelasByTingkat);
        const gradeCtx = document.getElementById('gradeChart').getContext('2d');
        new Chart(gradeCtx, {
            type: 'bar',
            data: {
                labels: gradeData.map(item => 'Tingkat ' + item.tingkat),
                datasets: [{
                    label: 'Jumlah Kelas',
                    data: gradeData.map(item => item.total),
                    backgroundColor: blueColors[2],
                    borderColor: blueColorsBorders[2],
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: blueColors[0]
                }]
            },
            options: {
                ...animationOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.6)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Teacher status chart
        const teacherData = @json($guruByStatus);
        const teacherCtx = document.getElementById('teacherStatusChart').getContext('2d');
        new Chart(teacherCtx, {
            type: 'doughnut',
            data: {
                labels: teacherData.map(item => item.status_kepegawaian),
                datasets: [{
                    data: teacherData.map(item => item.total),
                    backgroundColor: blueColors,
                    borderColor: blueColorsBorders,
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                ...animationOptions,
                cutout: '60%'
            }
        });

        // Class capacity utilization chart
        const capacityData = @json($kelasUtilization);
        const capacityCtx = document.getElementById('capacityChart').getContext('2d');
        new Chart(capacityCtx, {
            type: 'bar',
            data: {
                labels: capacityData.map(item => item.nama_kelas),
                datasets: [{
                    label: 'Kapasitas Terpakai (%)',
                    data: capacityData.map(item => item.utilization),
                    backgroundColor: capacityData.map(item => {
                        // Color based on utilization percentage with blue theme
                        if (item.utilization < 50) return 'rgba(59, 130, 246, 0.7)'; // blue-500
                        if (item.utilization < 75) return 'rgba(37, 99, 235, 0.7)';  // blue-600
                        if (item.utilization < 90) return 'rgba(29, 78, 216, 0.7)';  // blue-700
                        return 'rgba(30, 64, 175, 0.7)'; // blue-800
                    }),
                    borderColor: 'rgba(219, 234, 254, 0.8)', // blue-100
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.6
                }]
            },
            options: {
                ...animationOptions,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.6)'
                        },
                        title: {
                            display: true,
                            text: 'Persentase Kapasitas Terpakai',
                            font: {
                                family: 'Inter, system-ui, sans-serif',
                                size: 12
                            }
                        }
                    },
                    y: {
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const item = capacityData[context.dataIndex];
                                return `${context.formattedValue}% (${item.kapasitas - item.sisa_kapasitas}/${item.kapasitas})`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    /* Additional custom styles for enhanced appearance */
    body {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    /* Smooth hover transitions for all interactive elements */
    a, button {
        transition: all 0.3s ease;
    }
    
    /* Enhance card hover effects */
    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(37, 99, 235, 0.04);
    }
    
    /* Gradient text for headings */
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        background-image: linear-gradient(to right, #2563eb, #4f46e5);
    }
    
    /* Pulse animation for important stats */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }
    
    .animate-pulse-slow {
        animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Enhanced scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #93c5fd;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #60a5fa;
    }
</style>

@endsection

