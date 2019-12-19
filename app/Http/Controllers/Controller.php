<?php

namespace raplet\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use raplet\Logs;
use raplet\Notifications;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function notifier($request)
    {
        $notifications = Notifications::where('name', $request['notification_name'])->where('content_id', $request['content_id'])->first();

        if ($notifications != null)
        {// the user was notified before
            DB::table('notifications')->where('id', $notifications->id)->increment('counter');
            $notifications->seen = '0';
            $notifications->update();
        }

        else
        {   // creating fresh notifications
            //content_type: 0->user; 1->post; 2->comment; 3->userban ...

            $notification = new Notifications();

            $notification->name = $request['notification_name'];
            $notification->url = $request['url'];
            $notification->user_id = $request['effected_user_id'];
            $notification->content_id = $request['content_id'];
            $notification->content_type = $request['content_type'];

            $notification->save();

            DB::table('userprofiles')->where('user_id', $request['effected_user_id'])->increment('notification_count');
        }

        return true;
    }

    public function logger($request)
    {
        $newlog = new Logs();

        $newlog->user_id = $request['actor_id'];
        $newlog->content_id = $request['logged_id'];
        $newlog->content_type = $request['log_type'];
        $newlog->save();

        return true;
    }

    public function invalid_request()
    {
        $success = '0';
        $message = trans('home.youshouldntdothat');
        return ['message' => $message, 'success' => $success];
    }

    public function valid_request()
    {
        $success = '1';
        $message = trans('home.success');
        return ['message' => $message, 'success' => $success];
    }
}
