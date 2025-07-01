@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Create New Event</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('events.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Event Name -->
                <div class="md:col-span-2">
                    <label for="nama_event" class="block text-sm font-medium text-gray-700">Event Name</label>
                    <input 
                        type="text" 
                        name="nama_event" 
                        id="nama_event" 
                        value="{{ old('nama_event') }}" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        required
                    >
                </div>

                <!-- Event Description -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Event Description</label>
                    <textarea 
                        name="deskripsi" 
                        id="deskripsi" 
                        rows="4" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        required
                    >{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Date & Time -->
                <div>
                    <label for="tanggal_waktu" class="block text-sm font-medium text-gray-700">Date & Time</label>
                    <input 
                        type="datetime-local" 
                        name="tanggal_waktu" 
                        id="tanggal_waktu" 
                        value="{{ old('tanggal_waktu') }}" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        required
                    >
                </div>

                <!-- Maximum Quota -->
                <div>
                    <label for="kuota_maksimal" class="block text-sm font-medium text-gray-700">Maximum Quota</label>
                    <input 
                        type="number" 
                        name="kuota_maksimal" 
                        id="kuota_maksimal" 
                        value="{{ old('kuota_maksimal') }}" 
                        min="1"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        required
                    >
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a 
                    href="{{ route('events.index') }}" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded"
                >
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
