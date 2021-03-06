<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = Notification::where('for', Auth::user()->role)->where('status', 0)->get();
                // dd($notifications);
                $view->with('notifications', $notifications);
                // View::share('notifications', $notifications);
            }
        });

        Schema::defaultStringLength(191);
    }
}
