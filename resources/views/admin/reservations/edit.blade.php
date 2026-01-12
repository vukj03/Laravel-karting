@extends('layouts.admin')

@section('title', 'Izmena rezervacije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-edit text-primary"></i> Izmena rezervacije #{{ $reservation->id }}
    </h2>
    <div>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad na listu
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Izmena podataka rezervacije</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Korisnik *</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Izaberite korisnika</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $reservation->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Datum vožnje *</label>
                            <input type="date" name="reservation_date" class="form-control" 
                                   value="{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}" 
                                   min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Vreme *</label>
                            <select name="time_slot" class="form-select" required>
                                @php
                                    $timeSlots = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];
                                @endphp
                                @foreach($timeSlots as $time)
                                    <option value="{{ $time }}" {{ $reservation->time_slot == $time ? 'selected' : '' }}>{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Paket *</label>
                            <select name="package" class="form-select" required id="packageSelect">
                                <option value="beginner" {{ $reservation->package == 'beginner' ? 'selected' : '' }}>Početni (20€/osoba)</option>
                                <option value="advanced" {{ $reservation->package == 'advanced' ? 'selected' : '' }}>Napredni (40€/osoba)</option>
                                <option value="pro" {{ $reservation->package == 'pro' ? 'selected' : '' }}>Pro (60€/osoba)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Broj učesnika *</label>
                            <input type="number" name="participants" class="form-control" id="participantsInput"
                                   min="1" max="10" value="{{ $reservation->participants }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dodatne opcije</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="helmet" value="1" 
                                       id="helmetCheckbox" {{ $reservation->helmet ? 'checked' : '' }}>
                                <label class="form-check-label" for="helmetCheckbox">Kaciga (+5€/osoba)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="insurance" value="1" 
                                       id="insuranceCheckbox" {{ $reservation->insurance ? 'checked' : '' }}>
                                <label class="form-check-label" for="insuranceCheckbox">Osiguranje (+10€/osoba)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="video" value="1" 
                                       id="videoCheckbox" {{ $reservation->video ? 'checked' : '' }}>
                                <label class="form-check-label" for="videoCheckbox">Video snimak (+15€/osoba)</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Ukupna cena (€) *</label>
                            <input type="number" name="total_price" class="form-control" id="totalPriceInput"
                                   step="0.01" min="0" value="{{ $reservation->total_price }}" required>
                            <small class="form-text text-muted">Možete ručno izmeniti ili koristiti dugme za automatski izračun</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Na čekanju</option>
                                <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Potvrđeno</option>
                                <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Otkazano</option>
                                <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Završeno</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Posebne instrukcije</label>
                        <textarea name="instructions" class="form-control" rows="3" maxlength="500">{{ $reservation->instructions }}</textarea>
                        <div class="form-text">Maksimalno 500 karaktera</div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Sačuvaj promene
                        </button>
                        
                        <button type="button" class="btn btn-secondary" onclick="calculatePrice()">
                            <i class="fas fa-calculator me-2"></i> Izračunaj cenu automatski
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informacije o rezervaciji</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>ID rezervacije:</strong><br>
                    #{{ $reservation->id }}
                </div>
                
                <div class="mb-3">
                    <strong>Originalni korisnik:</strong><br>
                    {{ $reservation->user->name ?? 'N/A' }}<br>
                    <small class="text-muted">{{ $reservation->user->email ?? '' }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Originalni paket:</strong><br>
                    {{ ucfirst($reservation->package) }}
                </div>
                
                <div class="mb-3">
                    <strong>Originalan datum:</strong><br>
                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y.') }}
                </div>
                
                <div class="mb-3">
                    <strong>Originalno vreme:</strong><br>
                    {{ $reservation->time_slot }}
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <strong>Kreirano:</strong><br>
                    {{ $reservation->created_at->format('d.m.Y. H:i') }}
                </div>
                
                <div class="mb-3">
                    <strong>Poslednja izmena:</strong><br>
                    {{ $reservation->updated_at->format('d.m.Y. H:i') }}
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Danger Zone</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" 
                      onsubmit="return confirm('Da li ste SIGURNI da želite da trajno obrišete ovu rezervaciju?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i> Trajno obriši rezervaciju
                    </button>
                </form>
                
                <div class="alert alert-warning mt-3">
                    <small>
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Pažnja:</strong> Brisanje je trajno i ne može se poništiti.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Funkcija za automatski izračun cene
function calculatePrice() {
    const packagePrices = {
        'beginner': 20,
        'advanced': 40,
        'pro': 60
    };
    
    // Dohvati vrednosti iz forme
    const package = document.getElementById('packageSelect').value;
    const participants = parseInt(document.getElementById('participantsInput').value) || 1;
    const helmet = document.getElementById('helmetCheckbox').checked;
    const insurance = document.getElementById('insuranceCheckbox').checked;
    const video = document.getElementById('videoCheckbox').checked;
    
    // Izračunaj osnovnu cenu
    let price = packagePrices[package] * participants;
    
    // Dodaj dodatke
    if (helmet) price += 5 * participants;
    if (insurance) price += 10 * participants;
    if (video) price += 15 * participants;
    
    // Postavi izračunatu cenu
    document.getElementById('totalPriceInput').value = price;
    
    // Prikaži notifikaciju
    alert('Cena je izračunata: ' + price + '€');
}

// Event listener-i za automatsko izračunavanje
document.getElementById('packageSelect').addEventListener('change', function() {
    if(confirm('Želite li automatski izračunati cenu na osnovu novog paketa?')) {
        calculatePrice();
    }
});

document.getElementById('participantsInput').addEventListener('change', function() {
    if(confirm('Želite li automatski izračunati cenu na osnovu novog broja učesnika?')) {
        calculatePrice();
    }
});

document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if(confirm('Želite li automatski izračunati cenu?')) {
            calculatePrice();
        }
    });
});
</script>
@endsection