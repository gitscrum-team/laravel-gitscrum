<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Http\Middleware;

use Closure;
use GitScrum\Models\Sprint;

class GlobalActivities
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
        $sprint = Sprint::where('slug', 'credits-and-debits')
            ->with('issues.statuses')
            ->first();

        //view()->share('globalActivities', $sprint->activities());

        return $next($request);
    }
}
