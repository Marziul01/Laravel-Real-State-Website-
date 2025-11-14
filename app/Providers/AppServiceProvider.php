<?php

namespace App\Providers;

use App\Models\AdminAccess;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Send Site Settings to ALL views
        View::composer('*', function ($view) {
            $setting = SiteSetting::find(1);
            $view->with('setting', $setting);
        });

        // Send Admin Access ONLY to admin views
        View::composer('admin.*', function ($view) {
            $access = AdminAccess::where('admin_id', auth()->id())->first();
            $view->with('access', $access);
        });
    }
}
