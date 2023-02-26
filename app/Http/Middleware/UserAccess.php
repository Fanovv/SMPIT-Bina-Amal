<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userLevel)
    {
        if (auth()->guest()) {
            abort(403);
        }
        if (auth()->user()->level !== $userLevel) {
            abort(403);
        }
        return $next($request);
        // return response()->json(['You do not have permission to access for this page.']);
    }
}
