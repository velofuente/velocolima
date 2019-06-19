<?php

namespace App\Http\Middleware;

use Closure, Log, Auth;

class userAccess
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
        if ($request->user()->role_id == 3) {
            return $next($request);
        }
        return redirect('/');
    }
}
