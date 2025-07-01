<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function index()
    {
        return view('checkin.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
        ]);

        $reservation = Reservation::where('kode_tiket', $request->kode_tiket)
                                 ->with(['user', 'event'])
                                 ->first();

        if (!$reservation) {
            return redirect()->back()->with('error', 'Kode tiket tidak valid!');
        }

        return view('checkin.detail', compact('reservation'));
    }

    public function checkin(Reservation $reservation)
    {
        if ($reservation->isSudahCheckin()) {
            return redirect()->back()->with('error', 'Tiket sudah di-check-in sebelumnya!');
        }

        $reservation->checkIn();

        return redirect()->back()->with('success', 'Check-in berhasil!');
    }
}