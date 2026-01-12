<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Kart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Čuvanje nove rezervacije
    public function store(Request $request)
    {
        // Validacija
        $validated = $request->validate([
            'package' => 'required|in:beginner,advanced,pro',
            'date' => 'required|date|after:today',
            'time_slot' => 'required',
            'participants' => 'required|integer|min:1|max:10',
            'instructions' => 'nullable|string|max:500',
        ]);
        
        // Cene paketa
        $packagePrices = [
            'beginner' => 20,
            'advanced' => 40,
            'pro' => 60
        ];
        
        // Cene dodataka
        $addonPrices = [
            'helmet' => 5,
            'insurance' => 10,
            'video' => 15
        ];
        
        // Izračunaj ukupnu cenu
        $basePrice = $packagePrices[$validated['package']] * $validated['participants'];
        $addons = 0;
        
        if ($request->has('helmet') && $request->helmet == '1') {
            $addons += $addonPrices['helmet'] * $validated['participants'];
        }
        
        if ($request->has('insurance') && $request->insurance == '1') {
            $addons += $addonPrices['insurance'] * $validated['participants'];
        }
        
        if ($request->has('video') && $request->video == '1') {
            $addons += $addonPrices['video'] * $validated['participants'];
        }
        
        $totalPrice = $basePrice + $addons;
        
        // Pronađi dostupan kart (prvi dostupan)
        $kart = Kart::where('available', true)->first();
        
        // Kreiraj rezervaciju
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'kart_id' => $kart ? $kart->id : 1,
            'reservation_date' => $validated['date'],
            'package' => $validated['package'],
            'time_slot' => $validated['time_slot'],
            'participants' => $validated['participants'],
            'helmet' => $request->has('helmet') ? 1 : 0,
            'insurance' => $request->has('insurance') ? 1 : 0,
            'video' => $request->has('video') ? 1 : 0,
            'instructions' => $validated['instructions'] ?? null,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);
        
        // Ako smo našli kart, označi ga kao zauzet
        if ($kart) {
            $kart->available = false;
            $kart->save();
        }
        
        // Sačuvaj podatke rezervacije u sesiji za modal
        $request->session()->flash('reservation_data', [
            'package' => $validated['package'],
            'date' => $validated['date'],
            'time_slot' => $validated['time_slot'],
            'participants' => $validated['participants'],
            'total' => $totalPrice,
        ]);
        
        return redirect()->route('dashboard')
            ->with('success', 'Booking confirmed! Check your email for confirmation.');
    }
    
    // Brisanje rezervacije
    public function destroy(Reservation $reservation)
    {
        // Proveri da li korisnik sme da obriše rezervaciju
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ako rezervacija ima kart, oslobodi ga
        if ($reservation->kart) {
            $reservation->kart->available = true;
            $reservation->kart->save();
        }
        
        $reservation->delete();
        
        return redirect()->route('dashboard')
            ->with('success', 'Booking cancelled successfully.');
    }
}