<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function store(Request $request, Event $event)
    {
        // Check if user already has reservation for this event
        $existingReservation = Reservation::where('user_id', Auth::id())
                                         ->where('event_id', $event->id)
                                         ->first();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'Anda sudah memiliki reservasi untuk event ini!');
        }

        // Check if event is still available
        if (!$event->isAvailableForReservation()) {
            return redirect()->back()->with('error', 'Event tidak tersedia untuk reservasi!');
        }

        DB::transaction(function () use ($event) {
            // Double check quota inside transaction
            $currentReservations = $event->reservations()->count();
            if ($currentReservations >= $event->kuota_maksimal) {
                throw new \Exception('Kuota sudah habis!');
            }

            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
            ]);
        });

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat!');
    }

    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
                                  ->with('event')
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function updateCheckin(Request $request, Reservation $reservation)
    {
        if ($reservation->isSudahCheckin()) {
            return redirect()->back()->with('error', 'Pengunjung sudah check-in!');
        }

        $reservation->checkIn();

        return redirect()->back()->with('success', 'Check-in berhasil!');
    }
}