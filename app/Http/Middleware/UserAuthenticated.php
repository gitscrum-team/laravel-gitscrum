<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

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

        if ( !Auth::user() )
        {
            return redirect()->route('auth.login')->with('success', trans('GitScrum authentication is required'));
        }

        return $next($request);
    }
}
