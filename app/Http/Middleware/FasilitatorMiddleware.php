<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FasilitatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role->name === 'Fasilitator') {
            return $next($request);
        }

        return redirect('/');
    }
}
