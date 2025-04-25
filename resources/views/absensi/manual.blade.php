@extends('layouts.app')

@section('title', 'Input Absensi Manual')

@section('content')
<style>
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    
    /* Transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-sky-500/80 to-indigo-500/80 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="relative px-6 py-8 md:px-8 backdrop-blur-sm">
            <div class="absolute inset-0 bg-white/10"></div>
            <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center space-x-4">
                    <span class="p-2 bg-white/20 rounded-lg text-white">
                        <i class="fas fa-user-edit text-2xl"></i>
                    </span>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Input Absensi Manual</h1>
                        <p class="text-white/80 text-sm">Masukkan data absensi siswa secara manual</p>
                    </div>
                </div>
                
                <a href="{{ route('absensi.index') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg border border-white/20 backdrop-blur-sm transition duration-200 group">
                    <i class="fas fa-arrow-left mr-2 group-hover:translate-x-[-2px] transition-transform"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center text-gray-700">
                <i class="fas fa-search text-indigo-500 mr-2"></i>
                <h2 class="text-lg font-medium">Cari Data Siswa</h2>
            </div>
        </div>
        
        <div class="p-6">
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-600 flex items-center" role="alert">
                    <i class="fas fa-check-circle text-green-500 mr-2 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-600 flex items-center" role="alert">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            
            <div class="mb-8">
                <div class="space-y-2 group">
                    <label for="nisn" class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">NISN Siswa</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-indigo-500 transition-colors">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <input type="text" id="nisn" placeholder="Masukkan NISN Siswa" class="block w-full pl-10 pr-12 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button id="cek-siswa" class="inline-flex items-center px-3 py-1 bg-indigo-500 text-white text-sm font-medium rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <i class="fas fa-search mr-1"></i>
                                <span>Cek</span>
                            </button>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 pl-1">Masukkan NISN untuk mencari data siswa</p>
                </div>
            </div>
            
            <!-- Student Info (Hidden by default) -->
            <div id="siswa-info" class="hidden space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-800 flex items-center">
                        <i class="fas fa-user-graduate text-indigo-500 mr-2"></i>
                        Data Siswa
                    </h3>
                </div>
                
                <div class="bg-indigo-50 rounded-lg p-4">
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-1">
                            <dt class="text-sm font-medium text-gray-500">NISN</dt>
                            <dd id="display-nisn" class="text-sm font-semibold text-gray-800"></dd>
                        </div>
                        <div class="space-y-1">
                            <dt class="text-sm font-medium text-gray-500">Nama</dt>
                            <dd id="display-nama" class="text-sm font-semibold text-gray-800"></dd>
                        </div>
                        <div class="space-y-1">
                            <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                            <dd id="display-kelas" class="text-sm font-semibold text-gray-800"></dd>
                        </div>
                    </dl>
                </div>
                
                <form action="{{ route('absensi.manual.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="siswa_id" id="siswa_id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 group">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Tanggal Absensi</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-indigo-500 transition-colors">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" class="block w-full pl-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all" required>
                            </div>
                        </div>
                        
                        <div class="space-y-2 group">
                            <label for="status" class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Status Kehadiran</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-indigo-500 transition-colors">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <select id="status" name="status" class="block w-full pl-10 pr-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all" required>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Terlambat">Terlambat</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Alpa">Alpa</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 group">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Keterangan (Opsional)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute top-3 left-3 text-gray-400 group-hover:text-indigo-500 transition-colors">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <textarea id="keterangan" name="keterangan" rows="3" class="block w-full pl-10 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all"></textarea>
                        </div>
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-medium rounded-lg shadow-sm hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 group">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                            <span>Simpan Absensi</span>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Student Not Found (Hidden by default) -->
            <div id="siswa-not-found" class="hidden">
                <div class="rounded-lg bg-yellow-50 p-4 text-sm text-yellow-700">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium text-yellow-800">Siswa tidak ditemukan</h3>
                            <div class="mt-2">
                                <p>Siswa dengan NISN tersebut tidak ditemukan dalam database.</p>
                                <p class="mt-1">Pastikan NISN yang dimasukkan sudah benar atau hubungi administrator.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cekSiswaBtn = document.getElementById('cek-siswa');
        const nisnInput = document.getElementById('nisn');
        const siswaInfo = document.getElementById('siswa-info');
        const siswaNotFound = document.getElementById('siswa-not-found');
        
        cekSiswaBtn.addEventListener('click', function() {
            const nisn = nisnInput.value.trim();
            if (!nisn) {
                // Show toast notification
                showToast('error', 'Silahkan masukkan NISN siswa');
                return;
            }
            
            // Show loading state
            const originalBtnText = cekSiswaBtn.innerHTML;
            cekSiswaBtn.innerHTML = `
                <svg class="animate-spin h-4 w-4 mr-1 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mencari...
            `;
            cekSiswaBtn.disabled = true;
            
            fetch(`{{ route('absensi.check.student') }}?nisn=${nisn}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reset button state
                cekSiswaBtn.innerHTML = originalBtnText;
                cekSiswaBtn.disabled = false;
                
                if (data.found) {
                    document.getElementById('display-nisn').textContent = nisn;
                    document.getElementById('display-nama').textContent = data.siswa.nama_lengkap;
                    document.getElementById('display-kelas').textContent = data.siswa.kelas;
                    document.getElementById('siswa_id').value = data.siswa.id;
                    
                    siswaInfo.classList.remove('hidden');
                    siswaNotFound.classList.add('hidden');
                    
                    // Add animation
                    siswaInfo.style.opacity = '0';
                    siswaInfo.style.transform = 'translateY(10px)';
                    siswaInfo.style.transition = 'all 0.3s ease-out';
                    
                    setTimeout(() => {
                        siswaInfo.style.opacity = '1';
                        siswaInfo.style.transform = 'translateY(0)';
                        
                        // Smooth scroll to student info
                        siswaInfo.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 50);
                } else {
                    siswaInfo.classList.add('hidden');
                    siswaNotFound.classList.remove('hidden');
                    
                    // Add animation
                    siswaNotFound.style.opacity = '0';
                    siswaNotFound.style.transform = 'translateY(10px)';
                    siswaNotFound.style.transition = 'all 0.3s ease-out';
                    
                    setTimeout(() => {
                        siswaNotFound.style.opacity = '1';
                        siswaNotFound.style.transform = 'translateY(0)';
                        
                        // Smooth scroll to not found message
                        siswaNotFound.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 50);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show error toast
                showToast('error', 'Terjadi kesalahan saat mencari data siswa');
                
                cekSiswaBtn.innerHTML = originalBtnText;
                cekSiswaBtn.disabled = false;
            });
        });
        
        // Toast notification function
        function showToast(type, message) {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 rounded-lg shadow-lg p-4 transition-all transform translate-y-0 opacity-100 flex items-center ${type === 'error' ? 'bg-red-500 text-white' : 'bg-green-500 text-white'}`;
            
            const icon = document.createElement('i');
            icon.className = `mr-2 ${type === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-check-circle'}`;
            
            const text = document.createElement('span');
            text.textContent = message;
            
            toast.appendChild(icon);
            toast.appendChild(text);
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-[-20px]');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
    });
</script>

@endsection
