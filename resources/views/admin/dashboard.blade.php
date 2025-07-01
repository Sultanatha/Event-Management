@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-500 text-white">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Events</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 text-white">
                    <i class="fas fa-ticket-alt text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Reservations</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalReservations }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-500 text-white">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Today's Check-ins</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $todayCheckins }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Events</h3>
        </div>
        <div class="p-6">
            @if($recentEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($recentEvents as $event)
                        <div class="flex items-center justify-between p-4 border rounded-lg">
                            <div>
                                <h4 class="font-medium">{{ $event->nama_event }}</h4>
                                <p class="text-sm text-gray-600">{{ $event->tanggal_waktu->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium">{{ $event->total_reservasi }}/{{ $event->kuota_maksimal }}</p>
                                <p class="text-xs text-gray-600">reservations</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No events yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection