<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('dashboard.index');
})->name('dashboard');

Route::get('/dashboard/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::middleware('auth')->group(function () {
    
    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::put('/reservations/{reservation}/checkin', [ReservationController::class, 'updateCheckin'])->name('reservations.update_checkin');
    });

    // Reservations (for pengunjung)
    Route::middleware('auth')->group(function () {
        Route::post('/events/{event}/reserve', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    });

    // Events (index dan show)
    Route::get('/events/', [EventController::class, 'index'])->name('events.index');

    // ❗ HARUS DI PALING BAWAH
    Route::get('/events/{event}', [EventController::class, 'show'])
         ->whereNumber('event') // mencegah bentrok dengan string seperti "create"
         ->name('events.show');
});

// Check-in routes (accessible without auth for flexibility)
Route::get('/checkin', [CheckinController::class, 'index'])->name('checkin.index');
Route::post('/checkin/check', [CheckinController::class, 'check'])->name('checkin.check');
Route::post('/checkin/{reservation}/checkin', [CheckinController::class, 'checkin'])->name('checkin.process');
Route::post('/checkin/checkManual', [CheckinController::class, 'checkManual'])->name('checkin.checked');
Route::get('/checkin/detail/{reservation}', [CheckinController::class, 'detail'])->name('checkin.detail');
// Route::get('/checkin/check', function () {
//     return redirect()->route('checkin.index')->with('error', 'Silakan isi kode tiket terlebih dahulu.');
// });
require __DIR__.'/auth.php';