@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">{{ $event->nama_event }}</h1>
            <a href="{{ route('events.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Daftar Event
            </a>
        </div>
    </div>

    <!-- Event Details -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Event</h3>
                <p class="text-gray-600 mb-4">{{ $event->deskripsi }}</p>
                <div class="space-y-2">
                    <p><span class="font-medium">Tanggal & Waktu:</span> {{ $event->tanggal_waktu->format('d M Y, H:i') }}</p>
                    <p><span class="font-medium">Kuota:</span> {{ $event->kuota_maksimal }}</p>
                    <p><span class="font-medium">Total Reservasi:</span> {{ $event->total_reservasi }}</p>
                </div>
            </div>
        </div>
    </div>
     @if(auth()->user()->isAdmin())
    <!-- Reservations List -->
    <div class="bg-white shadow-md rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Reservasi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Tiket</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Reservasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $reservation->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $reservation->kode_tiket }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($reservation->isSudahCheckin())
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Checked-in</span>
                                @else
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Belum Check-in</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $reservation->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(!$reservation->isSudahCheckin())
                                    <form action="{{ route('reservations.update_checkin', $reservation) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-blue-600 hover:text-blue-900" onclick="return confirm('Check-in user ini?')">
                                            Check-in
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600">Check-in pada {{ $reservation->checkin_at->format('d M Y, H:i') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada reservasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="mt-6">
        {{ $reservations->links() }}
    </div>
</div>
@endsection
