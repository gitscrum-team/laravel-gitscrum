<?php

namespace GitScrum\Http\Middleware;

use Closure;
use GitScrum\Models\ProductBacklog;

class ProductbacklogMiddleware
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
        if (!ProductBacklog::count()) {
            return redirect()->route('wizard.step1');
        }

        return $next($request);
    }
}
