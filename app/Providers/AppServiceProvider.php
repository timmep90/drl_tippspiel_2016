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
            if(Match::orderBy('match_datetime', 'asc')->where('match_datetime','>=',Carbon::today())->first() !== null)
                $view->with('nextMatch', Match::orderBy('match_datetime', 'asc')->where('match_datetime','>=',Carbon::today())->first()->matchday);
            else
                $view->with('nextMatch', 1);
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
