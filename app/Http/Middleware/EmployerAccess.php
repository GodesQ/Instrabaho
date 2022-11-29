<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Employer;

class EmployerAccess
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
        abort_if(session()->get('role') != 'employer', 403);

        $user_id = session()->get('id');
        $employer_exist = Employer::where('user_id', $user_id)->exists();
        if(!$employer_exist) return redirect()->route('employer.role_form')->with('fail', "Oops! Looks like you do not have an employer account. Create first to continue");
        return $next($request);
    }
}
