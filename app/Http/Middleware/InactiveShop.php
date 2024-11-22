<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class InactiveShop
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
        if (Auth::user()->status == 'Inactive') {
            return redirect('/inactive');
        }
        return $next($request);
    }
    // public function handle($request, Closure $next, $ability, ...$models)
    // {
    //     $this->gate->authorize($ability, $this->getGateArguments($request, $models));

    //     return $next($request);
    // }
}
