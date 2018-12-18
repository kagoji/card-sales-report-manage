<?php

namespace App\Http\Middleware;

use Closure;

class AclCheck
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

        $route_name = \Request::route()->getName();
        if(!(\Auth::check()) && !(\Auth::user()->can($route_name)))
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                \Session::flash('errormessage','Invalid Request');
                \Session::put('pre_login_url',\URL::current());
                return redirect()->guest('/500'); /* default => 'auth/login' */
            }
        }

        return $next($request);
    }
}
