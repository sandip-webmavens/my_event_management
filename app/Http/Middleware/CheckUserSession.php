<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user')&& !session()->has('id')) {
            return redirect()->route('user.login')->with('error', 'Please log in to access this page.');
        }
        return $next($request);
    }
}

