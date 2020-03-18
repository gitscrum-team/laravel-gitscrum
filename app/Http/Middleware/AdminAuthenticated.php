<?php

namespace GitScrum\Http\Middleware;

use Closure;
use Auth;

class AdminAuthenticated
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

        $request->user()->authorizeRoles(['admin']);
          

        return $next($request);
    }
}