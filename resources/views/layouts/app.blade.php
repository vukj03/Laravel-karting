<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Karting App')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-500 p-4 text-white">
        <a href="{{ route('home') }}" class="mr-4">Home</a>
        @auth
            @if(Auth::user()->id == 2)
                <a href="{{ route('admin.dashboard') }}" class="mr-4">Admin Dashboard</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="underline">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="mr-4">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </nav>

    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>
