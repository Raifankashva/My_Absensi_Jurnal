@extends('layouts.app')
@section('title', 'Settings')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Attendance Settings</h2>
                    
                    <form method="POST" action="{{ route('attendance.settings.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">School Name</label>
                                <input type="text" name="sekolah_id" value="{{ $settings->nama_sekolah ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"> 
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Entry Time</label>
                                <input type="time" name="jam_masuk" value="{{ $settings->jam_masuk ?? '' }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Late Limit</label>
                                <input type="time" name="batas_telat" value="{{ $settings->batas_telat ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Exit Time</label>
                                <input type="time" name="jam_pulang" value="{{ $settings->jam_pulang ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            @if($settings)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Scan Page Token</label>
                                    <input type="text" value="{{ $settings->token }}" readonly
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                                </div>
                            @endif
                            
                            <div>
                                <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Save Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection