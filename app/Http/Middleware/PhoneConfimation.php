<?php

namespace App\Http\Middleware;

use App\Exceptions\v1\PhoneNotConfirmedException;
use Closure;
use Illuminate\Http\Request;

class PhoneConfimation
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws PhoneNotConfirmedException
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->phone_verified_at == null){
            throw new PhoneNotConfirmedException();
        }
        return $next($request);
    }
}
