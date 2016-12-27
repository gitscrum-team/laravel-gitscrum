<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Middleware;

use Closure;
use GitScrum\Models\Issue;

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
        try {
            if (isset($request->slug)) {
                Issue::slug($request->slug)->firstOrFail();
            }
        } catch (\Exception $e) {
            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
