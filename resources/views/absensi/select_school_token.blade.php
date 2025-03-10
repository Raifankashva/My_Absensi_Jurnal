@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-3xl bg-white shadow-lg rounded-lg p-6">
        <div class="border-b pb-4 mb-4">
            <h4 class="text-xl font-semibold text-gray-800">Pilih Sekolah untuk Manajemen Token</h4>
        </div>
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($sekolah as $skl)
                <div class="bg-white shadow-md rounded-lg p-4 border">
                    <h5 class="text-lg font-semibold text-gray-800">{{ $skl->nama_sekolah }}</h5>
                    <p class="text-gray-600">{{ $skl->alamat }}</p>
                    <a href="{{ route('absensi.token.management', ['sekolah_id' => $skl->id]) }}" 
                       class="mt-3 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md w-full text-center">
                        Kelola Token
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
