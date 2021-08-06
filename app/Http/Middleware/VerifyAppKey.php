<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyAppKey
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
        if (request()->header('APP_KEY')) {
            if (request()->header('APP_KEY') == 'HGwADiSjyHSAWZwTZRNXfNoJYZVyPf38x4Aq6jBaDrIyH76FKeNDBcy1UrEq0FInDgC9SWRMVIlmZ4jX') {
                return $next($request);
            } else {
                return response()->json(['message' => 'App key is incorrect', 'status' => false,], 401);
            }
        } else {
            return response()->json(['message' => 'App key is missing', 'status' => false,], 401);
        }
    }
}
