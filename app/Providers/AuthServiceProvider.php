<?php

namespace raplet\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'raplet\Model' => 'raplet\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }


    
    public function contentIndex(){
        contentIndexCheck();
    }    

    public function contentIndexCheck(){

        $thisMonth = Carbon::today()->month();

        $nonIndexed = Article::where('indexed', "0")->get();
        $outdated = Article::where('indexDate', '!=', $thisMonth)->get();
        
        newIndex($nonIndexed);
        updateIndex($outdated);
    }
}


