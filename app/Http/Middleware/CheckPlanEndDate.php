<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetail; // Import the UserDetails model

class CheckPlanEndDate
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $userDetails = UserDetail::where('user_id', $user->id)->first();

            if ($userDetails && $userDetails->plan_end_date < now()) {
                // Plan end date has passed, prevent login
                return redirect()->back()->with('plan_expired', 'Your plan has expired. Please renew to access.');
            }
        }

        return $next($request);
    }
}
