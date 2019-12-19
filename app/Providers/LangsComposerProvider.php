<?php

namespace raplet\Providers;

use Illuminate\Support\ServiceProvider;

class LangsComposerProvider extends ServiceProvider
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
        $this->composeLangs();
    }
    public function composeLangs(){
        view()->composer('layouts.app', 'raplet\Http\Composers\LangComposer');
        view()->composer('includes.addheader', 'raplet\Http\Composers\LangComposer');
        view()->composer('home', 'raplet\Http\Composers\LangComposer');
        view()->composer('solarsystem', 'raplet\Http\Composers\LangComposer');
        view()->composer('curiosity', 'raplet\Http\Composers\LangComposer');
        view()->composer('profile', 'raplet\Http\Composers\LangComposer');
        view()->composer('word', 'raplet\Http\Composers\LangComposer');
    }
}