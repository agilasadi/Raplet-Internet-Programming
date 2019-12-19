<?php

namespace raplet\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use raplet\Events\NewPost;
use raplet\Listeners\postLog;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'raplet\Events\Event' => [
            'raplet\Listeners\EventListener',
        ],
        'raplet\Events\PostLog' => [
            'raplet\Listeners\NotifyListener',
        ],
        NewPost::class => [
            postLog::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
