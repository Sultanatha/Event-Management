@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">{{ $event->nama_event }}</h1>
            <a href="{{ route('events.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Events
            </a>
        </div>
    </div>

    <!-- Event Details -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Event Information</h3>
                <p class="text-gray-600 mb-4">{{ $event->deskripsi_event }}</p>
                <div class="space-y-2">
                    <p><span class="font-medium">Date & Time:</span> {{ $event->tanggal_waktu->format('d M Y, H:i') }}</p>
                    <p><span class="font-medium">Quota:</span> {{ $event->kuota_tersisa }}/{{ $event->kuota_maksimal }}</p>
                    <p><span class="font-medium">Total Reservations:</span> {{ $event->total_reservasi }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservations List -->
    <div class="bg-white shadow-md rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Reservations</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reserved At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $reservation->user->email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $reservation->kode_tiket }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($reservation->isSudahCheckin())
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Checked-in
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Not Checked-in
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $reservation->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(!$reservation->isSudahCheckin())
                                    <form action="{{ route('admin.events.checkin', $event) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">
                                        <button type="submit" class="text-blue-600 hover:text-blue-900" onclick="return confirm('Check-in this user?')">
                                            Check-in
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600">
                                        Checked-in at {{ $reservation->checkin_at->format('d M Y, H:i') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No reservations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $reservations->links() }}
    </div>
</div>
@endsection
