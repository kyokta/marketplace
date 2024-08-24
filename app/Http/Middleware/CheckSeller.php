<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'seller') {
            return $next($request);
        }

        if ($request->is('api/*')) {
            return response()->json(['error' => 'You do not have access to this section.'], 403);
        }

        return redirect()->route('home.dashboard')->with('error', 'You do not have access to this section.');
    }
}