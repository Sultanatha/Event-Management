@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Check-in Tiket</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('checkin.check') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_tiket" class="form-label">Kode Tiket</label>
                        <input type="text" class="form-control" id="kode_tiket" name="kode_tiket" 
                               placeholder="Masukkan kode tiket (contoh: TKT-ABC12345)" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cek Tiket</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection