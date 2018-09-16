<?php

namespace App\Http\Middleware;

use Closure;

class CheckForSession
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
        if ($request->session()->has('bearer') !== true) {
            $request->session()->flush();
            $request->session()->save();
            return redirect()->action('AuthenticationController@signIn');
        }

        return $next($request);
    }

}
