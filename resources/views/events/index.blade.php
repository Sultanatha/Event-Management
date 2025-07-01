@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ auth()->user()->isAdmin() ? 'Kelola Events' : 'Daftar Events' }}</h2>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('events.create') }}" class="btn btn-primary">Buat Event Baru</a>
            @endif
        </div>

        @if($events->count() > 0)
            <div class="row">
                @foreach($events as $event)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->nama_event }}</h5>
                                <p class="card-text">{{ Str::limit($event->deskripsi, 100) }}</p>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ $event->tanggal_waktu->format('d M Y, H:i') }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-people"></i> 
                                    {{ $event->total_reservasi }}/{{ $event->kuota_maksimal }} peserta
                                </small>
                                
                                <div class="mt-3">
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary btn-sm">
                                        Detail
                                    </a>
                                    
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-warning btn-sm">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('events.destroy', $event) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Yakin ingin menghapus event ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        @if($event->isAvailableForReservation())
                                            <form method="POST" action="{{ route('reservations.store', $event) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Reservasi
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-danger">Tidak Tersedia</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                Belum ada event yang tersedia.
            </div>
        @endif
    </div>
</div>
@endsection