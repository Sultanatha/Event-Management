<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'kode_tiket',
        'status',
        'checkin_at',
    ];

    protected $casts = [
        'checkin_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            $reservation->kode_tiket = 'TKT-' . strtoupper(Str::random(8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class)->withTrashed();
    }

    public function isSudahCheckin()
    {
        return $this->status === 'sudah_checkin';
    }

    public function checkIn()
    {
        $this->update([
            'status' => 'sudah_checkin',
            'checkin_at' => now(),
        ]);
    }

    public function isAvailableForReservation()
    {
        return $this->tanggal_waktu > now() && $this->reservations()->count() < $this->kuota_maksimal;
    }
}
