<?php

namespace raplet\Listeners;

use raplet\Events\NewUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use raplet\Logs;

class registerLog
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
     * @param  Event  $event
     * @return void
     */

    public function handle(NewUser $event)
    {
        $newlog = new Logs();
        $newlog->user_id = $event->user->id;
        $newlog->content_id = $event->user->id;
        $newlog->content_type = '0';
        $newlog->save();
    }
}
