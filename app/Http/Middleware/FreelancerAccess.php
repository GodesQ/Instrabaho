<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Freelancer;

class FreelancerAccess
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
        abort_if(session()->get('role') != 'freelancer', 403);

        $user_id = session()->get('id');
        $freelancer_exist = Freelancer::where('user_id', $user_id)->exists();
        if(!$freelancer_exist) return redirect()->route('freelancer.role_form')->with('Oops! Looks like you dont have a freelancer account. Create first to continue');
        return $next($request);
    }
}
