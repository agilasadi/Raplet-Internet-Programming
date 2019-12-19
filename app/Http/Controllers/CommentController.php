<?php

namespace raplet\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use raplet\Comment;
use raplet\Commentlinks;
use raplet\Lang;
use raplet\Like;
use raplet\Post;
use Illuminate\Support\Facades\Validator;
use raplet\Vote;


class CommentController extends Controller
{

    /*============ Notification fields for this controller ============*/
    protected $notification_name = "postCommented";
    protected $notification_url = "word";

//    protected $notification_type = "word";

    public function createComments(Request $request)
    {

        if (Auth::check())
        {

            $linkerObjects = $request['jsonObj'];
            if (sizeof($linkerObjects) <= 5)
            {
                foreach ($linkerObjects as $linkerObject)
                {
                    if (sizeof($linkerObject) == 4)
                    {
                        $jsonobject = $jsonobject . ' = ' . $jsondrow['url'];
                        $jsonValidator = Validator::make($linkerObject, [
                            'text' => 'required|string|max:127',
                            'url' => 'required|string|max:300',
                            'type' => 'required|string|max:1',
                            'index' => 'required|string|numeric',
                        ]);
                        if ($jsonValidator->fails())
                        {
                            $message = trans('custommsg.jsonunknown');
                            $success = "0";
                            return response()->json(['success' => $success, 'message' => $message]);
                        }
                    }
                    else
                    {
                        $message = trans('custommsg.jsonunknown');
                        $success = "0";
                        return response()->json(['success' => $success, 'message' => $message]);
                    }
                }
            }
            else
            {
                $message = trans('custommsg.jsonunknown');
                $success = "0";
                return response()->json(['success' => $success, 'message' => $message]);
            }

            $post = Post::where('id', $request['post_id'])->first();
            if ($post != null)
            {
                $validator = Validator::make($request->all(), [
                    'content' => 'required|max:3028',
                    'post_id' => 'required',
                    'lang' => 'max:8',
                    'anonymousmode' => 'required',
                ]);
                if ($validator->fails())
                {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $commentslug = new Slugify();
                $slug = $commentslug->slugify(str_limit($request['content'], 80));

                while (Comment::where('slug', $slug)->exists())
                {
                    $slug = $slug . Auth::id();
                }
                // Replace the new line \r\n, \r first, then trim it.
                $content = nl2br($request["content"]);
                //$content = trim($content);
                $content = $request["content"];

                $comment = new Comment();

                if ($request['lang'] == null)
                {
                    $langname = Config::get('app.locale');
                    $lang = Lang::where('short_name', $langname)->first();
                }
                else
                {
                    $lang = Lang::where('short_name', $request['lang'])->first();
                }
                switch ($request['anonymousmode'])
                {
                    case 1:
                        $user_field = 1;
                        $anonym_field = Auth::id();
                        break;

                    default:
                        $user_field = Auth::id();
                        $anonym_field = 1;
                }

                $comment->content = $content;
                $comment->slug = $slug;
                $comment->post_id = $request['post_id'];
                $comment->is_featured = '1';
                $comment->lang_id = $lang->id;
                $comment->user_id = $user_field;
                $comment->anonym = $anonym_field;

                $comment->save();

                if ($request['jsonObj'] != null)
                {
                    $links = new Commentlinks();
                    //return $request['linkObj'];
                    $links->links = json_encode($request['jsonObj']);
                    $links->comment_id = $comment->id;
                    $links->save();
                }


                DB::table('userstats')->where('user_id', Auth::id())->increment('entrycount');
                DB::table('posts')->where('id', $request['post_id'])->increment('entrycount');

                // Create Log
                $log_data = [
                    'actor_id' => $user_field,
                    'logged_id' => $comment->id,
                    'log_type' => '2', // 2 means this was a comment
                ];

                $this->logger($log_data);

                // Create Notification
                $notify_data = [
                    'content_id' => $post->id,
                    'effected_user_id' => $post->user_id,
                    'content_type' => '1',
                    'url' => route('word', $post->slug),
                    'notification_name' => 'postCommented'
                ];

                $this->notifier($notify_data);

                $entryRoute = route('entry', $comment->slug);

                //response as html
                if ($comment->commentlinks != null)
                {
                    $commentLinks = $comment->commentlinks->links;
                }
                else
                {
                    $commentLinks = '';
                }

                $userImg = url('storage/profile/' . $comment->userprofile->userImg);
                $justNowPosted = trans('home.justNow');


                $success = '1';
                $message = trans('home.success');
                return response()->json(['commentLinks' => $commentLinks, 'success' => $success, 'message' => $message, 'theComment' => $comment,
                    'entryRoute' => $entryRoute, 'userImg' => $userImg, 'userinfo' => Auth::user()->userprofile, 'justNowPosted' => $justNowPosted]);

            }
            else
            {
                $success = '0';
                $message = trans('home.thereisnosuchdata');
                return response()->json(['message' => $message, 'success' => $success]);
            }


        }
        else
        {
            $success = '0';
            $message = trans('home.plzLogin');
            return response()->json(['message' => $message, 'success' => $success]);
        }

    }

    public function editComments(Request $request)
    {
        $comment = Comment::where('id', $request['comment_id'])->first();

        if (Auth::check())
        {

            if ($comment->user == Auth::user() || Auth::user()->userprofile->role == 1 || Auth::user()->userprofile->role == 2)
            {
                $linkerObjects = $request['jsonObj'];
                if (sizeof($linkerObjects) <= 5)
                {
                    foreach ($linkerObjects as $linkerObject)
                    {
                        if (sizeof($linkerObject) == 4)
                        {
                            $jsonobject = $jsonobject . ' = ' . $jsondrow['url'];
                            $jsonValidator = Validator::make($linkerObject, [
                                'text' => 'required|string|max:127',
                                'url' => 'required|string|max:300',
                                'type' => 'required|string|max:1',
                                'index' => 'required|string|numeric',
                            ]);
                            if ($jsonValidator->fails())
                            {
                                $message = trans('custommsg.jsonunknown');
                                $success = "0";
                                return response()->json(['success' => $success, 'message' => $message]);
                            }
                        }
                        else
                        {
                            $message = trans('custommsg.jsonunknown');
                            $success = "0";
                            return response()->json(['success' => $success, 'message' => $message]);
                        }
                    }
                }
                else
                {
                    $message = trans('custommsg.jsonunknown');
                    $success = "0";
                    return response()->json(['success' => $success, 'message' => $message]);
                }

                $post = Post::where('id', $request['post_id'])->first();
                if ($post != null)
                {
                    $validator = Validator::make($request->all(), [
                        'content' => 'required|max:3028',
                        'post_id' => 'required',
                        'lang' => 'max:8',
                        'anonymousmode' => 'required',
                    ]);
                    if ($validator->fails())
                    {
                        return response()->json(['errors' => $validator->errors()->all()]);
                    }

                    $content = $request["content"];

                    if ($request['lang'] == null)
                    {
                        $langname = Config::get('app.locale');
                        $lang = Lang::where('short_name', $langname)->first();
                    }
                    else
                    {
                        $lang = Lang::where('short_name', $request['lang'])->first();
                    }
                    switch ($request['anonymousmode'])
                    {
                        case 1:
                            $user_field = 1;
                            $anonym_field = Auth::id();
                            break;

                        default:
                            $user_field = Auth::id();
                            $anonym_field = 1;
                    }
                    $comment->content = $content;
                    $comment->post_id = $request['post_id'];
                    $comment->is_featured = '1';
                    $comment->lang_id = $lang->id;
                    $comment->user_id = $user_field;
                    $comment->anonym = $anonym_field;

                    $comment->update();

                    $links = $comment->commentlinks;
                    if ($links != null)
                    {
                        if ($request['jsonObj'] != null)
                        {
                            $links->links = json_encode($request['jsonObj']);
                            $links->comment_id = $comment->id;
                            $links->update();
                        }
                        else
                        {
                            $links->delete();
                            $links = null;
                        }
                    }
                    else
                    {
                        if ($request['jsonObj'] != null)
                        {
                            $links = new Commentlinks();
                            //return $request['linkObj'];
                            $links->links = json_encode($request['jsonObj']);
                            $links->comment_id = $comment->id;
                            $links->save();
                        }
                    }

                    DB::table('userstats')->where('user_id', Auth::id())->increment('entrycount');
                    DB::table('posts')->where('id', $request['post_id'])->increment('entrycount');


                    // Create Notification
                    $notify_data = [
                        'content_id' => $post->id,
                        'effected_user_id' => $post->user_id,
                        'content_type' => '1',
                        'url' => route('word', $post->slug),
                        'notification_name' => 'postCommentEdited'
                    ];

                    $this->notifier($notify_data);

                    $entryRoute = route('entry', $comment->slug);

                    //response as html
                    if ($comment->commentlinks != null)
                    {
                        $commentLinks = $comment->commentlinks->links;
                    }
                    else
                    {
                        $commentLinks = '';
                    }

                    $userImg = url('storage/profile/' . $comment->userprofile->userImg);
                    $justNowPosted = trans('home.justNow');

                    $success = '1';
                    $message = trans('home.success');
                    return response()->json(['commentLinks' => ($links == null) ? "" : $links->links, 'success' => $success, 'message' => $message, 'theComment' => $comment,
                        'entryRoute' => $entryRoute, 'userImg' => $userImg, 'userinfo' => Auth::user()->userprofile, 'justNowPosted' => $justNowPosted]);

                }
                else
                {
                    $success = '0';
                    $message = trans('home.thereisnosuchdata');
                    return response()->json(['message' => $message, 'success' => $success]);
                }

            }
            else
            {
                $success = '0';
                $message = trans('home.notYourPost');
                return response()->json(['message' => $message, 'success' => $success]);
            }

        }
        else
        {
            $success = '0';
            $message = trans('home.plzLogin');
            return response()->json(['message' => $message, 'success' => $success]);
        }


    }

    public function deleteComments(Request $request)
    {
        $comment = Comment::where('id', $request['content_id'])->first();
        if ($comment != null)
        {//comment excists
            if ($comment->user_id = Auth::id())
            {
                $comment->is_featured = '4'; //4 means deleted

                $comment->update();

                DB::table('posts')->where('id', $comment->post_id)->decrement('entrycount');
                DB::table('userstats')->where('user_id', $comment->user_id)->decrement('entrycount');

                $success = '1';
                $message = trans('home.deletedsuccess');
                return response()->json(['message' => $message, 'success' => $success]);
            }
            else
            {
                $success = '0';
                $message = trans('home.youshouldntdothat');
                return response()->json(['message' => $message, 'success' => $success]);
            }

        }
        else
        {
            $success = '0';
            $message = trans('home.thereisnosuchdata');
            return response()->json(['message' => $message, 'success' => $success]);

        }
    }

    public function index($local, $id)
    {
        // $post = Post::where('id', $id)->first();
        $lang = Lang::where('short_name', $local)->first();

        $comment = Comment::where('post_id', $id)->where('lang_id', $lang->id)->with('userprofile')->get();
        return response()->json($comment);
    }

    public function entry($slug)
    {
        $is_featured = [0, 4];
        $comment = Comment::where('slug', $slug)->whereNotIn('is_featured', $is_featured)->firstOrFail();
        if ($comment != 0)
        {
            if (Auth::check())
            {

                $commentVoteUp = Vote::select('comment_id')->where('comment_id', $comment->id)->where('user_id', Auth::id())->where('vote', 1)->get();
                $commentVoteDown = Vote::select('comment_id')->where('comment_id', $comment->id)->where('user_id', Auth::id())->where('vote', 0)->get();
                $likes = Like::select('post_id')->where('post_id', $comment->post_id)->where('user_id', Auth::id())->get();


                if (!$commentVoteUp)
                {
                    $commentVoteUp = "null";
                }
                if (!$commentVoteDown)
                {
                    $commentVoteDown = "null";
                }
                if (!$likes)
                {
                    $likes = '0';
                }

                $likeArr = array_flatten($likes->toArray());
                $voteUps = array_flatten($commentVoteUp->toArray());
                $voteDowns = array_flatten($commentVoteDown->toArray());


            }
            else
            {
                $voteUps = 'null';
                $voteDowns = 'null';
                $likeArr = '0';
            }

            return view('entry', ['comment' => $comment, 'likeArr' => $likeArr, 'voteUps' => $voteUps, 'voteDowns' => $voteDowns]);

        }
        else
        {
            return back();
        }

    }


}
