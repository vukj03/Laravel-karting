@extends('layouts.admin')

@section('title', 'Sve rezervacije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-calendar-check text-primary"></i> Sve rezervacije
    </h2>
    <div class="text-muted">
        Ukupno: {{ $reservations->total() }}
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($reservations->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Korisnik</th>
                        <th>Datum</th>
                        <th>Vreme</th>
                        <th>Paket</th>
                        <th>Učesnici</th>
                        <th>Cena</th>
                        <th>Status</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>#{{ $reservation->id }}</td>
                        <td>{{ $reservation->user->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y.') }}</td>
                        <td>{{ $reservation->time_slot }}</td>
                        <td>
                            @if($reservation->package == 'beginner')
                                <span class="badge bg-info">Početni</span>
                            @elseif($reservation->package == 'advanced')
                                <span class="badge bg-warning">Napredni</span>
                            @else
                                <span class="badge bg-danger">Pro</span>
                            @endif
                        </td>
                        <td>{{ $reservation->participants }}</td>
                        <td><strong>{{ $reservation->total_price }}€</strong></td>
                        <td>
                            @if($reservation->status == 'confirmed')
                                <span class="badge bg-success">Potvrđeno</span>
                            @elseif($reservation->status == 'pending')
                                <span class="badge bg-warning">Na čekanju</span>
                            @elseif($reservation->status == 'cancelled')
                                <span class="badge bg-danger">Otkazano</span>
                            @else
                                <span class="badge bg-secondary">{{ $reservation->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning" title="Izmeni">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Da li ste sigurni da želite da obrišete ovu rezervaciju?')" title="Obriši">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="card-footer">
            {{ $reservations->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <h4>Nema rezervacija</h4>
        </div>
        @endif
    </div>
</div>
@endsection