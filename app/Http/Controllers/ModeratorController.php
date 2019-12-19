<?php

namespace raplet\Http\Controllers;

use Illuminate\Http\Request;
use raplet\Logpost;
use raplet\Logs;
use raplet\Post;
use raplet\Postbadges;
use raplet\Userbadges;
use raplet\Userprofile;
use Illuminate\Support\Facades\Auth;
use raplet\Rank;
use raplet\Badge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ModeratorController extends Controller
{
    public function moderateUser(Request $request)
    {
        if (Auth::check())
        {
            $moderatorId = Rank::where('slug', 'moderator')->first();
            $adminId = Rank::where('slug', 'admin')->first();
            if (Auth::user()->userprofile->role_id == $moderatorId->id || Auth::user()->userprofile->role_id == $adminId->id)
            {
                $user = Userprofile::where('user_id', $request['user_id'])->first();
                if (count($user) > 0)
                {
                    $user->role_id = $request['role_id'];
                    $user->update();

                    $message = trans('home.success');
                    $success = '1';
                    return response()->json(['success' => $success, 'message' => $message]);
                }
                else
                {
                    $message = trans('home.failiur');
                    $success = '0';
                    return response()->json(['success' => $success, 'message' => $message]);
                }
            }
            else
            {
                $message = trans('home.failiur');
                $success = '0';
                return response()->json(['success' => $success, 'message' => $message]);
            }
        }
        else
        {
            $message = trans('home.plzLogin');
            $success = '0';
            return response()->json(['success' => $success, 'message' => $message]);
        }


    }

    public function badgeContent(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'content_type' => 'required',
            'badge_id' => 'required',
            'content_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        else

            if ($request['content_type'] == '1')
            { /// post icin
                $post = Post::where('id', $request['content_id'])->first();
                if (count($post) > 0)
                {  /// --- checking to see if the post excists
                    $badgeexcisatance = Badge::where('id', $request['badge_id'])->first();
                    if (count($badgeexcisatance) > 0)
                    {  /// --- checking to see if the badge excists
                        $badgeCheck = $users = DB::table('badge_post')->where('post_id', '=', $request['content_id'])->where('badge_id', '=', $request['badge_id'])->first();

                        if (count($badgeCheck) > 0)
                        { /// --- checking to see if content granted this same badge before
                            if ($badgeCheck->user_id == Auth::id())
                            {
                                DB::table('badge_post')->where('post_id', '=', $request['content_id'])->where('badge_id', '=', $request['badge_id'])->delete();

                                $userprofile = Userprofile::where('user_id', $post->user_id)->first();
                                $userprofile->reputation = $userprofile->reputation - $badgeexcisatance->badge_buff;
                                $userprofile->save();

                                DB::table('badge_user')->where('badge_id', $request['badge_id'])->where('user_id', $userprofile->user_id)->decrement('count');

                                $badgeId = $request['badge_id'];
                                $message = trans('home.badgeDeleted');
                                $success = '2';
                                return response()->json(['success' => $success, 'message' => $message, 'badgeId' => $badgeId]);
                            }
                            elseif (Auth::user()->userprofile->role_id == '1' || Auth::user()->userprofile->role_id == '2')
                            {
                                DB::table('badge_post')->where('post_id', '=', $request['content_id'])->where('badge_id', '=', $request['badge_id'])->delete();

                                $userprofile = Userprofile::where('user_id', $post->user_id)->first();
                                $userprofile->reputation = $userprofile->reputation - $badgeexcisatance->badge_buff;
                                $userprofile->save();

                                DB::table('badge_user')->where('badge_id', $request['badge_id'])->where('user_id', $userprofile->user_id)->decrement('count');


                                $badgeId = $request['badge_id'];
                                $message = trans('home.badgeDeleted');
                                $success = '2';
                                return response()->json(['success' => $success, 'message' => $message, 'badgeId' => $badgeId]);
                            }
                            else
                            {
                                $message = trans('home.alreadyBadged');
                                $success = '0';
                                return response()->json(['success' => $success, 'message' => $message]);
                            }
                        }
                        else
                        {
                            if (Auth::user()->userprofile->role_id != '4')
                            {     /// -- checking to see if the user can grant this badge
                                if ($badgeexcisatance->badge_reqs <= Auth::user()->userprofile->role->replimit || $badgeexcisatance->badge_ruler == Auth::user()->userprofile->role->slug)
                                {
                                    //Post attaching badge
                                    $newbadge = new Postbadges();
                                    $newbadge->post_id = $request['content_id'];
                                    $newbadge->user_id = Auth::id(); // this is the user_id of who gives the badge to the content
                                    $newbadge->badge_id = $request['badge_id'];
                                    $newbadge->content_type = $request['content_type'];
                                    $newbadge->save();


                                    $userprofile = Userprofile::where('user_id', $post->user_id)->first();
                                    $userprofile->reputation = $userprofile->reputation + $badgeexcisatance->badge_buff;
                                    $userprofile->save();

                                    //user attaching bbadge
                                    $userbadgeattached = Userbadges::where('user_id', $userprofile->user_id)->where('badge_id', $request['badge_id'])->first();
                                    if (count($userbadgeattached) > 0)
                                    {
                                        DB::table('badge_user')->where('id', $userbadgeattached->id)->increment('count');
                                    }
                                    else// attach new badge to user
                                    {
                                        $newUserBadge = new Userbadges();
                                        $newUserBadge->user_id = $userprofile->user_id;
                                        $newUserBadge->badge_id = $request['badge_id'];
                                        $newUserBadge->count = '1';
                                        $newUserBadge->content_type = $request['content_type'];
                                        $newUserBadge->save();
                                    }

                                    $notify_data = [
                                        'content_id' => $post->id,
                                        'effected_user_id' => $post->user_id,
                                        'content_type' => '1',
                                        'url' => route('word', $post->slug),
                                        'notification_name' => 'yourContentBadged'
                                    ];
                                    $this->notifier($notify_data);


                                    $message = trans('home.badged');
                                    $success = '1';
                                    return response()->json(['success' => $success, 'message' => $message]);
                                }
                                else
                                {
                                    return response()->json($this->invalid_request());
                                }
                            }
                            else
                            {
                                return response()->json($this->invalid_request());
                            }

                        }
                    }
                    else
                    {
                        $message = trans('home.nosuchbadge');
                        $success = '0';
                        return response()->json(['success' => $success, 'message' => $message]);
                    }
                }
                else
                {
                    $message = trans('home.thereisnosuchdata');
                    $success = '0';
                    return response()->json(['success' => $success, 'message' => $message]);
                }
            }
            else
            {
                $message = trans('home.youshouldntdothat');
                $success = '0';
                return response()->json(['success' => $success, 'message' => $message]);
            }
    }

    public function edit_post_is_featured(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_featured_type' => 'required',
            'content_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $post = Post::where('id', $request['content_id'])->first();
        if ($post != null)
        {
            if (Auth::user()->userprofile->role_id != '4')
            {
                $moderatorId = Rank::where('slug', 'moderator')->first();
                $adminId = Rank::where('slug', 'admin')->first();

                if (Auth::user()->userprofile->role_id == $moderatorId->id || Auth::user()->userprofile->role_id == $adminId->id)
                {
                    if (Logpost::where('post_id', $request['content_id'])->where('log_type', $request['is_featured_type'])->exists())
                    {
                        DB::table('logposts')->where('post_id', $request['content_id'])->where('log_type', $request['is_featured_type'])->delete();
                    }

                    $logpost = new Logpost();
                    $logpost->post_id = $request['content_id'];
                    $logpost->user_id = Auth::id();
                    $logpost->log_type = $request['is_featured_type'];

                    $logpost->save();

                    $userprofile = Userprofile::where('user_id', $post->user_id)->first();

                    $notification_name = "postVerified";
                    $notification_url = route('word', $post->slug);
                    $notification_user_id = $post->user_id;
                    $notification_content_id = $post->id;
                    $notification_content_type = "1";

                    if ($request['is_featured_type'] == '2')
                    {
                        $userprofile->reputation = $userprofile->reputation + 10;
                        $userprofile->save();
                    }

                    elseif ($request['is_featured_type'] == '3')
                    {
                        $userprofile->reputation = $userprofile->reputation - 5;
                        $userprofile->save();

                        $notification_name = "postDuplicate";
                    }
                    elseif ($request['is_featured_type'] == '0')
                    {
                        $userprofile->reputation = $userprofile->reputation - 75;
                        $userprofile->save();
                        $post->is_featured = 0;
                        $post->update();

                        $notification_name = "postBanned";
                        $notification_url = route('profile', $post->userprofile->slug);
                        $notification_content_type = "0";
                    }

                    $notify_data = [
                        'content_id' => $notification_content_id,
                        'effected_user_id' => $notification_user_id,
                        'content_type' => $notification_content_type,
                        'url' => $notification_url,
                        'notification_name' => $notification_name
                    ];

                    $this->notifier($notify_data);


                    return response()->json($this->invalid_request());
                }
                else
                {
                    return response()->json($this->invalid_request());
                }
            }
            else
            {
                return response()->json($this->invalid_request());
            }
        }
        else
        {
            $message = trans('home.thereisnosuchdata');
            $success = '0';
            return response()->json(['success' => $success, 'message' => $message]);
        }
    }

    /**
     * Verify post to have the blue tick on it
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify_duplicate_ban(Request $request)
    {
        // todo Validate the $request data
        $post = Post::find($request['content_id']);

        if ($post != null)
        {
            $case_flag = 1;
            switch ($request['is_featured_type'])
            {
                case 0:
                    $reputation_update = $post->userprofile->reputation - 75;
                    break;
                case 2:
                    $reputation_update = $post->userprofile->reputation + 10;
                    break;
                case 3:
                    $reputation_update = $post->userprofile->reputation - 4;
                    break;
                default:
                    $case_flag = 0; // if case flag is 0 than the given is_featured_type is invalid
            }

            if ($case_flag == 0)
            { // ===> if case flag is 0 than the given is_featured_type is invalid
                return response()->json($this->invalid_request());
            }
            Logpost::create([
                'post_id' => $request['content_id'],
                'user_id' => Auth::id(),
                'log_type' => $request['is_featured_type']
            ]);

            Userprofile::where('user_id', $post->user_id)->first()->update(['reputation' => $reputation_update]);
            return response()->json($this->valid_request());
        }
        else
        {
            return response()->json($this->invalid_request());
        }
    }

    /**
     * This function bans post and responds as json
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ban_post(Request $request)
    {
        $post = Post::where('id', $request['post_id'])->first();

        if ($post != null)
        { // ===> Banning post
            $post->update(['asdad' => 0]);

            $logpost = new Logpost();
            $logpost->post_id = $request['post_id'];
            $logpost->user_id = Auth::id();
            $logpost->log_type = 0;
            $logpost->save();

            $notify_data = [
                'content_id' => $request['post_id'],
                'effected_user_id' => $post->user_id,
                'content_type' => "0",
                'url' => route('profile', $post->userprofile->slug),
                'notification_name' => "postBanned"
            ];
            $this->notifier($notify_data);

            $user_profile = Userprofile::find($post->user_id);

            $user_profile->update([
                'reputation' => $user_profile->reputation - 75
            ]);

            return response()->json($this->valid_request());
        }
        else
        {
            return response()->json($this->invalid_request());
        }
    }

    /**
     * This function un bans a banned post and responds as json
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function un_ban_post(Request $request)
    {
        $post = Post::where('id', $request['post_id'])->first();

        if ($post != null)
        { // ===> Banning post
            $post->update(['asdad' => 7]);

            $logpost = new Logpost();
            $logpost->post_id = $request['post_id'];
            $logpost->user_id = Auth::id();
            $logpost->log_type = 7;
            $logpost->save();

            $notify_data = [
                'content_id' => $request['post_id'],
                'effected_user_id' => $post->user_id,
                'content_type' => "3",
                'url' => route('profile', $post->userprofile->slug),
                'notification_name' => "postUnBanned"
            ];
            $this->notifier($notify_data);

            $user_profile = Userprofile::find($post->user_id);

            $user_profile->update([
                'reputation' => $user_profile->reputation + 74
            ]);

            return response()->json($this->valid_request());
        }
        else
        {
            return response()->json($this->invalid_request());
        }
    }

}


















