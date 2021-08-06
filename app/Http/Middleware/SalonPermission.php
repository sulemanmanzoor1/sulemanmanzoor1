<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SalonPermission
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
        if (Auth::guard('salon')->check()) {

            if (Auth::guard('salon')->user()->role == 3 && Auth::guard('salon')->user()->status == 1) {
                return $next($request);
            } else {
                Session::flash('warning', 'Your acount is not activated');
                return redirect('salon');
            }
        } else {

            return redirect('salon');
        }
    }
}
