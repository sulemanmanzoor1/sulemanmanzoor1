<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
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



        if (Auth::guard('user')->check()) {

            if (Auth::guard('user')->user()->role == 1) {
                return $next($request);
            } else {
                return redirect('admin');
            }
        } else {

            return redirect('admin');
        }
    }
}
