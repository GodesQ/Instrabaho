<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Freelancer;
use App\Models\Employer;
use Carbon\Carbon;

class PlanExpiration
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
        $user_id = session()->get('id');
        $role = session()->get('role');
        
        if($role == 'freelancer') {
            $freelancer = Freelancer::where('user_id', $user_id)->first();
            if($freelancer->package_date_expiration < Carbon::now()) {
                return redirect('/dashboard')->with('fail', 'Fail Your Current Plan is already expired. Please purchase new plan.');
            }
        } else {
            $employer = Employer::where('user_id', $user_id)->first();
            if($employer->package_date_expiration < Carbon::now()) {
                return redirect('/dashboard')->with('fail', 'Fail Your Current Plan is already expired. Please purchase new plan.');
            }
        }
        
        return $next($request);
    }
}