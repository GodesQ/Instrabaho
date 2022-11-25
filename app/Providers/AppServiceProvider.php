<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

use App\Models\UserPermission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer('*', function ($view)
        {
            $user_permissions = UserPermission::all();
            foreach ($user_permissions as $key => $user_permission) {
                $permission_roles = explode("|", $user_permission->roles);
                $auth_user_role = session()->get('role');
                // dd(in_array(session()->get('role'), $permission_roles));
                $gate = Gate::define($user_permission->permission, function(Admin $admin) {
                    return true;
                });
                // dd($gate);
            }
        });
    }
}
