<?php

namespace GitScrum\Http\Middleware;

use Closure;

class IssueMiddleware
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
        /*
        try {
            if (isset($request->slug)) {
                Issue::slug($request->slug)->firstOrFail();
            }
        } catch (\Exception $e) {
            return redirect()->route('user.dashboard');
        }*/

        return $next($request);
    }
}
