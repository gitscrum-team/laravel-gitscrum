<?php
/**
 * GitScrum v0.1
 *
 * @package  GitScrum
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Middleware;

use Closure;
use GitScrum\Models\Sprint;
use Carbon\Carbon;
use Auth;

class SprintExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ( $slug = $request->slug )
        {

            $sprint = Sprint::where('slug','=',$slug)
                ->whereDate('date_finish', '<', Carbon::now()->format('Y-m-d'))
                //->whereNull('closed_at')
                ->first();

            if ( $sprint ){
                $msg = _('This Sprint has been expired at') . ' ' . $sprint->date_finish;
                view()->share('notification', ['alert'=>'danger', 'message'=> $msg]);
            }

        }

        return $next($request);
    }

}
