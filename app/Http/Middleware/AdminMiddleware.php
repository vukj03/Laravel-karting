<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pretpostavljamo da admin ima role_id = 1
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect('/'); // šalje običnog korisnika na početnu
        }

        return $next($request);
    }
}
