<?php

namespace raplet\Providers;

use Illuminate\Support\ServiceProvider;

class CategoryComposerProvider extends ServiceProvider
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
        $this->composeCategory();
    }
    public function composeCategory(){
        view()->composer('includes.pageHeader', 'raplet\Http\Composers\CategoryComposer');
        view()->composer('creatheader', 'raplet\Http\Composers\CategoryComposer');
        view()->composer('editpost', 'raplet\Http\Composers\CategoryComposer');
        view()->composer( 'admin.category.index', 'raplet\Http\Composers\CategoryComposer');
    }
}