@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(45deg, #3498db, #2980b9);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>{{ $totalUsers }}</h2>
                    <p class="mb-0">Ukupno korisnika</p>
                </div>
                <i class="fas fa-users fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(45deg, #2ecc71, #27ae60);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>{{ $totalReservations }}</h2>
                    <p class="mb-0">Ukupno rezervacija</p>
                </div>
                <i class="fas fa-calendar-check fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(45deg, #e74c3c, #c0392b);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>{{ $todayReservations }}</h2>
                    <p class="mb-0">Rezervacija danas</p>
                </div>
                <i class="fas fa-clock fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="table-container">
    <h4 class="mb-3">
        <i class="fas fa-users text-primary"></i> Svi korisnici ({{ $users->count() }})
    </h4>
    
    @if($users->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Ime</th>
                    <th>Email</th>
                    <th>Rola</th>
                    <th>Registrovano</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge badge-admin">Admin</span>
                        @else
                            <span class="badge badge-user">User</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d.m.Y. H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Nema registrovanih korisnika.
    </div>
    @endif
</div>
@endsection