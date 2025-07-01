<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_event',
        'deskripsi',
        'tanggal_waktu',
        'kuota_maksimal',
        'created_by',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getTotalReservasiAttribute()
    {
        return $this->reservations()->count();
    }

    public function getSisaKuotaAttribute()
    {
        return $this->kuota_maksimal - $this->total_reservasi;
    }

    public function isAvailableForReservation()
    {
        return $this->sisa_kuota > 0 && $this->tanggal_waktu > now();
    }
}
