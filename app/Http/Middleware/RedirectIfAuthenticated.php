<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(Auth::user())
       {
        if(Auth::user()->hasRole('superadmin'))
        {
            return redirect("superadmin/home");
        }
        else if(Auth::user()->hasRole("admin"))
        {
            return redirect("admin/home");
        }
        else if(Auth::user()->hasRole("superdistributor"))
        {
            return redirect("superdistributor/home");
        }
        else if(Auth::user()->hasRole("distributor"))
        {
            return redirect("distributor/home");
        }
        else if(Auth::user()->hasRole("retailer"))
        {
            return redirect("retailer/home");
        }
        else if(Auth::user()->hasRole("user"))
        {
            return redirect("user/home");
        }
        else if(Auth::user()->hasRole("reseller"))
        {
            return redirect("reseller/home");
        }
        else if(Auth::user()->hasRole("businessmanager"))
        {
            return redirect("businessmanager/home");
        }
        else if(Auth::user()->hasRole("agentuser"))
        {
            return redirect("agentuser/home");
        }     
        else if(Auth::user()->hasRole("agentmanager"))
        {
            return redirect("agentmanager/home");
        }
    }

    return $next($request);
    }
}
