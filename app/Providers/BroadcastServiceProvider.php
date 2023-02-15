<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        if (request()->wantsJson()) {
            Broadcast::routes(['middleware' => ['api', 'auth:sanctum']]);
        } else {
            Broadcast::routes(['middleware' => ['web', 'auth:user']]);
        }

        require base_path('routes/channels.php');
    }
}
