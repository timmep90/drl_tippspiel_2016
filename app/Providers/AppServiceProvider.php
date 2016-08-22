<?php

namespace App\Providers;

use App\Match;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.partials.sidebar', function($view){
            if(User::with('user_group.group')->find(Auth::user()->id) !== null)
                $view->with('eager_user', User::with('user_group.group')->find(Auth::user()->id));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
