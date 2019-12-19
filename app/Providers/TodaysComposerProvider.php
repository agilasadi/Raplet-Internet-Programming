<?php

namespace raplet\Providers;

use Illuminate\Support\ServiceProvider;

class TodaysComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->composeTodays();
    }
    public function composeTodays(){
        view()->composer('includes.today', 'raplet\Http\Composers\TodayComposer');
        view()->composer('layouts.app', 'raplet\Http\Composers\TodayComposer');
    }
}