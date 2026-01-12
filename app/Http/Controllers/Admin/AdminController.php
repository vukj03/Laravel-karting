<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Provera da li je admin (pomocna metoda)
    private function checkAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Nemate pristup ovoj stranici');
        }
    }
    
    // Admin Dashboard
    public function index()
    {
        $this->checkAdmin();
        
        // Dohvati sve korisnike
        $users = User::orderBy('created_at', 'desc')->get();
        
        // Broj rezervacija za statistiku
        $totalReservations = Reservation::count();
        $todayReservations = Reservation::whereDate('created_at', today())->count();
        $totalUsers = User::count();
        
        return view('admin.dashboard', compact('users', 'totalReservations', 'todayReservations', 'totalUsers'));
    }
    
    // Lista svih rezervacija
    public function reservations()
    {
        $this->checkAdmin();
        
        $reservations = Reservation::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.reservations.index', compact('reservations'));
    }
    
    // editReservation metoda
public function editReservation($id)
{
    $this->checkAdmin();
    
    $reservation = Reservation::with('user')->findOrFail($id);
    $users = User::all(); // Dohvati sve korisnike za dropdown
    
    return view('admin.reservations.edit', compact('reservation', 'users'));
}

// updateReservation metoda
public function updateReservation(Request $request, $id)
{
    $this->checkAdmin();
    
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'reservation_date' => 'required|date|after_or_equal:today',
        'time_slot' => 'required',
        'package' => 'required|in:beginner,advanced,pro',
        'participants' => 'required|integer|min:1|max:10',
        'total_price' => 'required|numeric|min:0',
        'instructions' => 'nullable|string|max:500',
        
        
    ]);
    
    // Obradi checkbox-ove
    $validated['helmet'] = $request->has('helmet') ? 1 : 0;
    $validated['insurance'] = $request->has('insurance') ? 1 : 0;
    $validated['video'] = $request->has('video') ? 1 : 0;
    
    $reservation = Reservation::findOrFail($id);
    $reservation->update($validated);
    
    return redirect()->route('admin.reservations.index')->with('success', 'Rezervacija uspešno ažurirana!');
}
    
    // Brisanje rezervacije
    public function destroyReservation($id)
    {
        $this->checkAdmin();
        
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        
        return redirect()->route('admin.reservations.index')->with('success', 'Rezervacija uspešno obrisana!');
    }
}