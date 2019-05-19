<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\PermissionsObserver;
use App\Permission;

class ObserveNotifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Permission::observe(new PermissionsObserver);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
