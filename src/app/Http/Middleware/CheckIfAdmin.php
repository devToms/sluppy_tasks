<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sprawdź, czy użytkownik jest zalogowany i ma uprawnienia administratora
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Jeśli użytkownik nie jest administratorem, przekieruj go na stronę główną
        return redirect('/');
    }
}