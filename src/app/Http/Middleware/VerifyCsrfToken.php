<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    // app/Http/Middleware/VerifyCsrfToken.php

    // app/Http/Middleware/VerifyCsrfToken.php
public function handle($request, Closure $next)
{
    // Odkomentuj tę linię, aby wyłączyć CSRF
    // return $next($request);
}

}