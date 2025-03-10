@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Hasil Import Data Siswa</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('adminsiswa.import') }}" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition">
                            Import Lagi
                        </a>
                        <a href="{{ route('adminsiswa.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
                
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                {{ $stats['success'] }} data berhasil diimpor. {{ $stats['failed'] }} data gagal diimpor.
                            </p>
                        </div>
                    </div>
                </div>
                
                @if(count($newUsers) > 0)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Data Akun Siswa yang Berhasil Dibuat</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Password</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($newUsers as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user['nisn'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user['email'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user['password'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('adminsiswa.export.credentials') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Download Kredensial
                        </a>
                    </div>
                </div>
                @endif
                
                @if(count($failedImports) > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Data yang Gagal Diimpor</h3>
                    <div class="bg-red-50 border border-red-200 rounded-md">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-red-200">
                                <thead class="bg-red-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Baris</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Data</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Alasan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-red-200">
                                    @foreach($failedImports as $failed)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $failed['row'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $failed['data'] ?? json_encode($failed['row_data']) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-red-600">{{ $failed['error'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection