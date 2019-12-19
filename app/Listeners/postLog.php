<?php

namespace raplet\Listeners;

use raplet\Events\NewPost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use raplet\Logs;

class postLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewPost  $event
     * @return void
     */
    public function handle(NewPost $event)
    {
        Logs::create([
            'content_id' => $event->post->id,
            'user_id' => $event->post->user_id,
            'content_type' => '1',
        ]);
    }
}
