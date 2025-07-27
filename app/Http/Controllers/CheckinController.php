<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;    

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

        $userId = Auth::id();

        if ($reservation->user_id !== $userId) {
            return redirect()->back()->with('error', 'Kode tiket tidak valid!');
        }

        if (!$reservation) {
            return redirect()->back()->with('error', 'Kode tiket tidak valid!');
        }

        return view('checkin.detail', compact('reservation'));
    }

    public function checkManual(Request $request)
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

        $reservation->status = 'sudah_checkin';
        $reservation->checkin_at = now();
        $reservation->save();

        return redirect()->back()->with('success', 'Check-in berhasil.');
    }

    public function checkin(Reservation $reservation)
    {
        if ($reservation->isSudahCheckin()) {
            return redirect()->back()->with('error', 'Tiket sudah di-check-in sebelumnya!');
        }

        $reservation->checkIn();

        return redirect()->route('checkin.detail', $reservation->id)
                 ->with('success', 'Check-in berhasil!');
    }

    public function detail(Reservation $reservation)
    {
        return view('checkin.detail', compact('reservation'));
    }
}