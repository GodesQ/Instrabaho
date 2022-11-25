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
        // $user_permissions = UserPermission::all();
        // foreach ($user_permissions as $key => $user_permission) {
        //     Gate::define($user_permission->permission, function($admin) use ($user_permission) {
        //         $permission_roles = explode("|", $user_permission->roles);
        //         return in_array($admin->role, $permission_roles);
        //     });
        // }
    }
}
