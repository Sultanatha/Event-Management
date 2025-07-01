@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Detail Tiket</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Informasi Pengunjung</h5>
                        <p><strong>Nama:</strong> {{ $reservation->user->name }}</p>
                        <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                        <p><strong>Kode Tiket:</strong> {{ $reservation->kode_tiket }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Informasi Event</h5>
                        <p><strong>Event:</strong> {{ $reservation->event->nama_event }}</p>
                        <p><strong>Tanggal:</strong> {{ $reservation->event->tanggal_waktu->format('d M Y, H:i') }}</p>
                        <p><strong>Status:</strong> 
                            @if($reservation->isSudahCheckin())
                                <span class="badge bg-success">Sudah Check-in</span>
                                <br><small>Check-in pada: {{ $reservation->checkin_at->format('d M Y, H:i') }}</small>
                            @else
                                <span class="badge bg-warning">Belum Check-in</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                @if(!$reservation->isSudahCheckin())
                    <div class="mt-4">
                        <form method="POST" action="{{ route('checkin.process', $reservation) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Konfirmasi Check-in
                            </button>
                        </form>
                    </div>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('checkin.index') }}" class="btn btn-secondary">
                        Cek Tiket Lain
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection