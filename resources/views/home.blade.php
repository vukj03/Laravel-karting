@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Dobrodošao, {{ auth()->user()->name }}!</h1>
        <p>Ovo je tvoja početna stranica kao običan korisnik.</p>
        <a href="{{ route('dashboard') }}" class="text-blue-500 underline mt-4 inline-block">Idi na dashboard</a>
    </div>
</div>
@endsection
