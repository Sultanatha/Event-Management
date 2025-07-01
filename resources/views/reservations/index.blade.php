@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Reservasi Saya</h1>

    @forelse ($reservations as $reservation)
        <div class="border rounded p-4 mb-3">
            <h2 class="text-lg font-semibold">{{ $reservation->event->nama_event }}</h2>
            <p class="text-gray-600">{{ $reservation->event->tanggal_waktu->format('d M Y, H:i') }}</p>
            <p class="text-gray-600">Kode Tiket: {{ $reservation->kode_tiket }}</p>
            <p class="text-gray-700 mt-1">Status Check-in: 
                <span class="{{ $reservation->isSudahCheckin() ? 'text-green-600' : 'text-red-600' }}">
                    {{ $reservation->isSudahCheckin() ? 'Sudah' : 'Belum' }}
                </span>
            </p>
        </div>
    @empty
        <p class="text-gray-500">Belum ada reservasi.</p>
    @endforelse
</div>
@endsection
