<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SukarelawanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role->name === 'Sukarelawan') {
            return $next($request);
        }

        return redirect('/');
    }
}
