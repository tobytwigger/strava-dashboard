<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleTeamIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->route()->getName() === 'dashboard') {
            $team = $request->route('team_slug');
            session()->put('current-team.id', $team->id);
        } else {
            session()->remove('current-team.id');
        }

        return $next($request);
    }
}
