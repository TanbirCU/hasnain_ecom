<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       if (!auth()->check()) {
            return redirect()->route('admin_login'); // or your login route
        }

        if (auth()->user()->is_admin != 1) {
            auth()->logout();
            return redirect()->route('admin_login')->withErrors(['Access denied!']);
        }

        return $next($request);
    }
}
