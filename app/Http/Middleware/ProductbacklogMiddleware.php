<?php

namespace GitScrum\Http\Middleware;

use Closure;
use Auth;

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
        $total = Auth::user()->organizations()->count();
        $tipo_provider = in_array(Auth::user()->provider, ['gitlab', 'github', 'gitbucket' ]); 

        if (!$total && $tipo_provider == TRUE) {
            return redirect()->route('wizard.step1');
        }

        return $next($request);
    }
}
