<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAcces
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->user()->role == $role) {
            return $next($request);
        }
        return abort(403, 'unauthorized access');
    }
}
