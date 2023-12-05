<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role->name === 'Admin') {
            return $next($request);
        }

        return redirect('/');
    }
}
