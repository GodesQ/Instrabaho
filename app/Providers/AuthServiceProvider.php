<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
Use App\Models\Admin;

use App\Models\UserPermission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $user_permissions = UserPermission::all();
        foreach ($user_permissions as $key => $user_permission) {
            Gate::define($user_permission->permission, function(Admin $admin) use ($user_permission) {
                $permission_roles = explode("|", $user_permission->roles);
                return in_array($admin->role, $permission_roles);
            });
        }
    }
}
