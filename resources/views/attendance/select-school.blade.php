@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Pilih Sekolah untuk Absensi</h2>

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('attendance.verify-token') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="sekolah_id" class="block text-sm font-medium text-gray-700">Pilih Sekolah</label>
                        <select name="sekolah_id" id="sekolah_id" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Pilih Sekolah</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->nama_sekolah }} - {{ $school->npsn }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="token" class="block text-sm font-medium text-gray-700">Token Sekolah</label>
                        <input type="password" name="token" id="token" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection