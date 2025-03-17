<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            Log::info('User is logged in', ['user_id' => Auth::id(), 'is_admin' => Auth::user()->is_admin]);

            if (Auth::user()->is_admin) {
                return $next($request);
            }

            Log::warning('User is not an admin', ['user_id' => Auth::id()]);
        } else {
            Log::warning('User is not logged in');
        }

        return redirect('/');
    }

    protected function checkIfUserIsAdmin($user)
    {
        // Przykład: Użytkownik jest administratorem, jeśli ma określoną rolę lub flagę
        return $user && $user->is_admin;
    }
}