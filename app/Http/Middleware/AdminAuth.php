<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuth
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

        if( (!(\Auth::check())  && !isset(\Auth::user()->user_type)) || (\Auth::user()->user_type != "admin" && \Auth::user()->user_type != "root" ))
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                \Session::flash('errormessage','You have no permission to access this page.');
                \Session::put('pre_login_url',\URL::current());
                return redirect()->guest('/dashboard'); /* default => 'auth/login' */
            }
        }
        return $next($request);
    }
}
