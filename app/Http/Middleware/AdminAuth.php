<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserType;

class AdminAuth
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
        $role = session()->get('role');
        abort_if(!$role, 404);

        $user_types_array = array();
        $user_types = UserType::get(['slug'])->toArray();

        foreach ($user_types as $key => $user_type) {
            array_push($user_types_array, $user_type['slug']);
        }

        abort_if(!in_array($role, $user_types_array), 403);

        return $next($request);
    }
}
