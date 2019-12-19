<?php

namespace raplet\Http\Controllers\Authed;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use raplet\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use raplet\Notifications;


class NotificationController extends Controller
{
    public function get_notifications()
    {
	    if (Auth::check()){
		    $notifications = Notifications::where('user_id', Auth::id())->where('seen', '0')->orderBy('updated_at', 'desc')
			    ->with(['post', 'userprofile', 'comment'])->get();
		    $notifyCount= DB::table('notifications')->where('user_id', Auth::id())->where('seen', '0')->count();
	    }
	    else{
		    $notifications = 'null';
		    $notifyCount = 'null';
	    }

	    $notification_ids = $notifications->pluck('id')->toArray();
	    Notifications::whereIn('id', $notification_ids)->update(array("seen" => "1"));
	    DB::table('userprofiles')->where('user_id', Auth::id())->update(array("notification_count" => "0"));

	    return ['notifications' => $notifications, 'notifyCount' => $notifyCount];
    }
}
