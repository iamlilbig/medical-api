<?php

namespace App\Http\Middleware;

use App\Exceptions\v1\UserIsBanException;
use Closure;
use Illuminate\Http\Request;

class UserBanDetector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->banned_to > now()){
            throw new UserIsBanException();
        }
        return $next($request);
    }
}
