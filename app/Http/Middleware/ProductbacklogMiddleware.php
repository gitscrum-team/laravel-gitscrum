<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

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

         if (!$total) {
             return redirect()->route('wizard.step1');
         }

         return $next($request);
     }
}
