<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $events = Event::orderBy('tanggal_waktu')->paginate(10); 
            return view('admin.events.index', compact('events'));
        } else {
            $events = Event::where('tanggal_waktu', '>', now())
                          ->orderBy('tanggal_waktu', 'asc')
                          ->get()
                          ->filter(fn($event) => $event->sisa_kuota > 0);
            return view('events.index', compact('events'));
        }
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_waktu' => 'required|date|after:now',
            'kuota_maksimal' => 'required|integer|min:1',
        ]);

        Event::create([
            'nama_event' => $request->nama_event,
            'deskripsi' => $request->deskripsi,
            'tanggal_waktu' => $request->tanggal_waktu,
            'kuota_maksimal' => $request->kuota_maksimal,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat!');
    }

    public function show(Event $event)
    {
        if (Auth::user()->isAdmin()) {
            $reservations = $event->reservations()->with('user')->paginate(10);
            return view('admin.events.show', compact('event', 'reservations'));
        } else {
            $reservations = $event->reservations()->with('user')->paginate(10); // atau paginate juga jika perlu
            return view('events.show', compact('event', 'reservations'));
        }
    }

    public function edit(Event $event)
    {
        $event = Event::find($event->id);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_waktu' => 'required|date',
            'kuota_maksimal' => 'required|integer|min:' . $event->total_reservasi,
        ]);

        $event->update($request->only('nama_event', 'deskripsi', 'tanggal_waktu', 'kuota_maksimal'));

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus!');
    }
}