<?php

namespace GitScrum\Http\Middleware;

use Closure;
use Auth;

class UserAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()) {
            return redirect()->route('auth.login')->with('success', trans('gitscrum.GitScrum-authentication-is-required'));
        }

        return $next($request);
    }
}
