<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class preventBack
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);

        $response = $next($request);

        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-validate')
            ->header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}
