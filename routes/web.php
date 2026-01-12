<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Početna stranica za sve
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth rute Breeze
require __DIR__.'/auth.php';

// RUTE ZA OBICNE KORISNIKE
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard za rezervacije
    Route::get('/dashboard', function () {
        $reservations = Auth::user()->reservations()->orderBy('reservation_date', 'desc')->get();
        return view('dashboard', compact('reservations'));
    })->name('dashboard');
    
    // Leaderboard
    Route::get('/leaderboard', function () {
        return view('leaderboard');
    })->name('leaderboard');
    
    // Booking rute
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    
    // Profile rute
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN RUTE
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Admin rezervacije - CRUD (BEZ SHOW!)
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations.index');
    Route::get('/reservations/{id}/edit', [AdminController::class, 'editReservation'])->name('reservations.edit');
    Route::put('/reservations/{id}', [AdminController::class, 'updateReservation'])->name('reservations.update');
    Route::delete('/reservations/{id}', [AdminController::class, 'destroyReservation'])->name('reservations.destroy');
});

// Ostale rute
Route::middleware(['auth'])->group(function () {
    Route::resource('karts', \App\Http\Controllers\KartController::class);
});