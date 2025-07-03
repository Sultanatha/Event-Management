<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     public function index()
    {
        if (Auth::user()->isAdmin()) {
            $totalEvents = Event::orderBy('tanggal_waktu')->get()->count();
            $totalReservations = Reservation::all()->count();
            $todayCheckins = Reservation::whereDate('checkin_at', Carbon::today())->count();
            $recentEvents = Event::orderBy('tanggal_waktu', 'desc')->get();
            return view('admin.dashboard', compact('totalEvents', 'totalReservations', 'todayCheckins', 'recentEvents'));

        }else{
             $events = Event::where('tanggal_waktu', '>', now())
                          ->orderBy('tanggal_waktu', 'asc')
                          ->get()
                          ->filter(fn($event) => $event->sisa_kuota > 0);
            return view('events.index', compact('events'));
        }
    }
}
