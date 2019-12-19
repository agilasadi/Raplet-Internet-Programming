<?php

namespace raplet\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use raplet\Lang;
use Cocur\Slugify\Slugify;
use raplet\Like;
use raplet\Logs;
use raplet\Logpost;
use raplet\Post;
use raplet\Postmedia;
use raplet\Report;
use raplet\Userprofile;
use raplet\Vote;
use raplet\Badge;
use Illuminate\Validation\Rule;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Cookie;
use raplet\Category;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends Controller
{
    public function word($slug, $langname = null)
    {
        $is_featured = [0, 4];
        $post = Post::where('slug', $slug)->whereNotIn('is_featured', $is_featured)->firstOrFail();

        if ($post != null || count($post) > 0) {
            $postEditedBy = Logpost::where('post_id', $post->id)->where('log_type', '8')->where('user_id', "!=", "$post->user_id")->first();

            if ($langname == null) {
                if (Auth::check()) {
                    $commentVoteUp = Vote::select('comment_id')->where('user_id', Auth::id())->where('vote', 1)->get();
                    $commentVoteDown = Vote::select('comment_id')->where('user_id', Auth::id())->where('vote', 0)->get();
                    $liked = Like::where('post_id', $post->id)->where('user_id', Auth::id())->first();

                    if (!$commentVoteUp) {
                        $commentVoteUp = "null";
                    }
                    if (!$commentVoteDown) {
                        $commentVoteDown = "null";
                    }
                    if (!$liked) {
                        $likedpost = '0';
                    } else {
                        $likedpost = '1';
                    }
                    $voteUps = array_flatten($commentVoteUp->toArray());
                    $voteDowns = array_flatten($commentVoteDown->toArray());

                    $badges = Badge::where('badge_type', '1')
                        ->where('badge_ruler', Auth::user()->userprofile->role->name)
                        ->orwhere('badge_reqs', '<=', Auth::user()->userprofile->reputation)->where('badge_type', '1')
                        ->orwhere('badge_reqs', '<=', Auth::user()->userprofile->role->replimit)->where('badge_type', '1')
                        ->get();
                } else {
                    $voteUps = 'null';
                    $voteDowns = 'null';
                    $likedpost = '0';
                    $badges = 'null';
                }

                $locale = $langname;
                $lang = DB::table('langs')->where('short_name', Config::get('app.locale'))->first();

                if ($post->comments() != null || count($post->comments()) > 0) {
                    $comments = $post->comments()->whereNotIn('is_featured', $is_featured)->orderBy('likecount', 'desc')->orderBy('id', 'ASC')->paginate(25);
                } else {
                    $comments = 'null';
                }

                return view('word', [
                    'post' => $post, 'comments' => $comments, 'locale' => $locale, 'voteUps' => $voteUps,
                    'voteDowns' => $voteDowns, 'likedpost' => $likedpost, 'badges' => $badges, 'postEditedBy' => $postEditedBy
                ]);
            }


            if (Auth::check()) {
                $commentVoteUp = Vote::where('user_id', Auth::id())->where('vote', 1)->get();
                $commentVoteDown = Vote::where('user_id', Auth::id())->where('vote', 0)->get();
                $liked = Like::where('post_id', $post->id)->where('user_id', Auth::id())->first();

                if (!$commentVoteUp) {
                    $commentVoteUp = "null";
                }
                if (!$commentVoteDown) {
                    $commentVoteDown = "null";
                }
                if (!$liked) {
                    $likedpost = '0';
                } else {
                    $likedpost = '1';
                }
                $voteUps = array_flatten($commentVoteUp->toArray());
                $voteDowns = array_flatten($commentVoteDown->toArray());

                $badges = Badge::where('badge_type', '1')
                    ->where('badge_ruler', Auth::user()->userprofile->role->name)
                    ->orwhere('badge_reqs', '<=', Auth::user()->userprofile->reputation)->where('badge_type', '1')
                    ->orwhere('badge_reqs', '<=', Auth::user()->userprofile->role->replimit)->where('badge_type', '1')
                    ->get();
            } else {
                $voteUps = 'null';
                $voteDowns = 'null';
                $likedpost = '0';
                $badges = 'null';
            }

            $locale = $langname;
            $lang = DB::table('langs')->where('short_name', $langname)->first();

            if ($post->comments() != null || count($post->comments()) > 0) {
                $comments = $post->comments()->where('lang_id', $lang->id)->whereNotIn('is_featured', $is_featured)->orderBy('likecount', 'desc')->orderBy('id', 'desc')->paginate(25, ["*"], 'wordcommentd');
            } else {
                $comments = 'null';
            }

            return view('word', [
                'post' => $post, 'comments' => $comments, 'locale' => $locale,
                'voteUps' => $voteUps, 'voteDowns' => $voteDowns, 'likedpost' => $likedpost, 'badges' => $badges, 'postEditedBy' => $postEditedBy
            ]);
        } else {
            return response()->json($this->invalid_request());
        }
    }


    public function index()
    {
        return view('admin.admin');
    }

    public function postCreate(Request $request)
    {
        if (Auth::guard('admin')) {

            $validator = Validator::make($request->all(), [
                'content' => 'required|unique:posts',
                'type' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            } else

                $post = new Post();

            $postslug = new Slugify();
            $slug = $postslug->slugify($request['content']);


            $post->content = $request['content'];
            $post->type = $request['type'];
            $post->user_id = '0';
            $post->slug = $slug;

            $post->save();

            $post->langs()->sync($request->langs, false);

            $message = "Baslik olusturulma basarili";

            return response()->json(['message' => $message]);
        } else {
            $message = "giris yapilmadi";

            return response()->json(['message' => $message]);
        }
    }

    public function makePost()
    {
        if (Auth::check()) {
            $langs = Lang::orderBy('name', 'desc')->get();
            return view('creatheader', ['langs' => $langs]);
        } else {
            $message = trans('home.plzLogin');
            Session::flash('message', $message);

            return redirect('home');
        }
    }

    public function recicle_posts($slug = null)
    {
        if (Auth::check()) {
            $user = Auth::user()->userprofile;
            if ($slug == null) {
                $slug = $user->slug;
            }
            if ($user->role_id == 1 || $user->role_id == 2) {
                $is_featured = [0, 4];
                $user = Userprofile::where("slug", $slug)->first();
                $logs = Logs::where('user_id', $user->user_id)->whereIn('log_type', $is_featured)->orderBy('id', 'desc')->paginate(25, ["*"], 'profilelogs');
            } else {
                $logs = Logs::where('user_id', $user->user_id)->where('log_type', "4")->orderBy('id', 'desc')->paginate(25, ["*"], 'profilelogs');
            }
            return view('update.post_recicle_bin', ['logs' => $logs, 'user' => $user]);
        } else {
            return response()->json($this->invalid_request());
        }
    }

    //By user
    //By user
    //By user
    public function createPost(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'content' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            //=====> Creating slug for the post
            $postslug = new Slugify();
            $slug = $postslug->slugify($request['content']);
            if (Post::where('slug', $slug)->exists()) {
                $slug = $slug . "-" . Auth::user()->userprofile->slug;
                if (Post::where('slug', $slug)->exists()) {
                    $slug = $slug . time();
                    while (Post::where('slug', $slug)->exists()) {
                        $slug = $slug . Auth::id();
                    }
                }
            }
            $post = new Post();

            //===> Assigning the category to the post
            if ($request['category']) {
                if (Category::find($request['category'])) {
                    $post->category_id = $request['category'];
                }
            }

            $post->content = $request['content'];
            $post->user_id = Auth::id();
            $post->slug = $slug;

            $post->save();

            Config::get('app.locale');
            $rotation = route('word', $slug);

            // Handle File Upload
            if ($request->hasFile('image')) {
                // Get filename with the extension
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;


                // Upload Image
                $path = $request->file('image')->move('storage/posts', $fileNameToStore);

                Image::make($path)->resize(1024, 1024, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);

                $postmedia = new Postmedia();

                $postmedia->post_id = $post->id;
                $postmedia->image = $fileNameToStore;

                $postmedia->save();

                DB::table('posts')->where('id', $post->id)->increment('type');
            }

            DB::table('userstats')->where('user_id', Auth::id())->increment('headercount');

            $message = trans('home.headercreated');
            $success = '1';

            return response()->json(['message' => $message, 'success' => $success, 'rotation' => $rotation]);
        } else {
            return response()->json($this->invalid_request());
        }
    }

    // public function delete_post(Request $request)
    // {
    //     if (Auth::check())
    //     {   // CHECK if user authenticated
    //         $post = Post::where('id', $request['post_id'])->first();
    //         if ($post != null || count($post) > 0)
    //         { // CHECK if post exists
    //             if (Auth::id() == $post->user_id)
    //             { // CASE: authenticated user is the owner of the post
    //                 $logpost = new Logpost();
    //                 $logpost->post_id = $request['post_id'];
    //                 $logpost->user_id = Auth::id();
    //                 $logpost->log_type = '4';
    //                 $logpost->save();

    //                 $post->delete();

    //                 $success = "1";
    //                 $message = trans('home.postDeactivated');
    //                 return response()->json(['message' => $message, 'success' => $success]);
    //             }
    //             elseif (Auth::user()->userprofile->role_id == 1 || Auth::user()->userprofile->role_id == 2)
    //             { // CASE: this user is admin or moderator
    //                 $logpost = new Logpost();
    //                 $logpost->post_id = $request['post_id'];
    //                 $logpost->user_id = Auth::id();
    //                 $logpost->log_type = '4';
    //                 $logpost->save();

    //                 $post->is_featured = '4';
    //                 $post->update();

    //                 $success = "1";
    //                 $message = trans('home.postDeactivated');
    //                 return response()->json(['message' => $message, 'success' => $success]);
    //             }
    //             else
    //             { // CASE: no permission to delete this post
    //                  return response()->json($this->invalid_request());
    //             }
    //         }
    //         else
    //         {
    //              return response()->json($this->invalid_request());
    //         }
    //     }
    //     else
    //     {
    //         $success = "0";
    //         $message = trans('home.plzLogin');
    //         return response()->json(['message' => $message, 'success' => $success]);
    //     }
    // }

    public function enablePost(Request $request)
    {
        if (Auth::check()) {   // CHECK if user authenticated
            $post = Post::where('id', $request['post_id'])->first();
            if ($post != null || count($post) > 0) { // CHECK if post excists

                if ($post->is_featured == 0) { // CASE: content was banned
                    if (Auth::user()->userprofile->role_id == 1 || Auth::user()->userprofile->role_id == 2) { // CASE: this user is admin or moderator
                        $post->is_featured = '7';
                        $post->restore();
                        //todo write banning and deleting actions separately from each others

                        $success = "1";
                        $message = trans('home.postReactivated');
                        return response()->json(['message' => $message, 'success' => $success]);
                    } else { // CASE: no permission to delete this post
                        return response()->json($this->invalid_request());
                    }
                } elseif ($post->is_featured == 4) { // CASE: content was deactivated
                    if (Auth::id() == $post->user_id) { // CASE: authed user is the owner of the post
                        $post->is_featured = '7';
                        $post->restore();

                        $success = "1";
                        $message = trans('home.postReactivated');
                    } elseif (Auth::user()->userprofile->role_id == 1 || Auth::user()->userprofile->role_id == 2) { // CASE: this user is admin or moderator
                        $post->is_featured = '7';
                        $post->update();

                        $success = "1";
                        $message = trans('home.postReactivated');
                    } else {
                        return response()->json($this->invalid_request());
                    }

                    $logpost = new Logpost();
                    $logpost->post_id = $request['post_id'];
                    $logpost->user_id = Auth::id();
                    $logpost->log_type = $post->is_featured;
                    $logpost->save();
                    return response()->json(['message' => $message, 'success' => $success]);
                } else {
                    return response()->json($this->invalid_request());
                }
            } else {
                return response()->json($this->invalid_request());
            }
        } else {
            $success = "0";
            $message = trans('home.plzLogin');
            return response()->json(['message' => $message, 'success' => $success]);
        }
    }

    public function delete_post(Request $request)
    {
        if (Auth::check()) {
            $post = Post::find($request['post_id']);
            if ($post != null && $post->is_featured != 0) { // ===> Checked if post exists
                if ($post->user_id == Auth::id()) { // ===> Checked if this user is the owner of Post
                    $post->delete();
                } else {
                    return response()->json($this->invalid_request());
                }
            } else {
                return response()->json($this->invalid_request());
            }

            // ===> After the deleting was done, post data was logged
            $post->update(['is_featured' => '4']);

            $logpost = new Logpost();
            $logpost->post_id = $request['post_id'];
            $logpost->user_id = Auth::id();
            $logpost->log_type = $post->is_featured;

            $logpost->save();

            $success = "1";
            $message = trans('home.postDeactivated');
            return response()->json(['message' => $message, 'success' => $success]);
        } else {
            return response()->json($this->invalid_request());
        }
    }

    public function restore_post(Request $request)
    {
        if (Auth::check()) {
            $post = Post::withTrashed()->where('id', $request['post_id'])->first();
            if ($post != null && $post->is_featured != 0) { // ===> Checked if post exists
                if ($post->user_id == Auth::id()) { // ===> Checked if this user is the owner of Post
                    $post->restore();
                }
                //todo write and elseif case to check if the user is admin or moderator.
                else {
                    return response()->json($this->invalid_request());
                }
            } else {
                return response()->json($this->invalid_request());
            }

            // ===> After restoring was done, post data was logged
            $post->update(['is_featured' => '7']);

            $logpost = new Logpost();
            $logpost->post_id = $request['post_id'];
            $logpost->user_id = Auth::id();
            $logpost->log_type = $post->is_featured;

            $logpost->save();

            $success = "1";
            $message = trans('home.postReactivated');
            return response()->json(['message' => $message, 'success' => $success]);
        } else {
            return response()->json($this->invalid_request());
        }
    }

    public function postEdit(Request $request)
    {
        if (Auth::check()) {
            if (!$request['content_id']) {
                return response()->json($this->invalid_request());
            }

            $post = Post::find($request['content_id']);
            if ($post == null) {
                return response()->json($this->invalid_request());
            }


            if (Auth::id() != $post->user_id && Auth::user()->userprofile->role_id != 1 && Auth::user()->userprofile->role_id != 2) {
                return response()->json($this->invalid_request());
            } else {
                if ($post->type == 1) {
                    if ($request->hasFile('image')) {
                        if ($request['image'] != $post->postmedia->image) {
                            // Get filename with the extension
                            $filenameWithExt = $request->file('image')->getClientOriginalName();
                            // Get just filename
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            // Get just ext
                            $extension = $request->file('image')->getClientOriginalExtension();
                            // Filename to store
                            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                            // Upload Image
                            $path = $request->file('image')->move('storage/posts', $fileNameToStore);

                            $img = Image::make($path)->resize(1024, 1024, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->save($path);


                            $postmedia = Postmedia::where('post_id', $post->id)->first();

                            $postmedia->image = $fileNameToStore;

                            $postmedia->update();
                        }
                    }
                }

                $validator = Validator::make($request->all(), [
                    'content' => ['required', 'min:2', 'max:60', Rule::unique('posts')->ignore($post->id)],
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                } else


                    $post->content = $request['content'];

                if ($request['category'] != null || $request['category'] != "") {

                    if (Category::where('id', $request['category'])->exists()) {
                        $post->category_id = $request['category'];
                    }
                }


                $post->update();

                $logpost = new Logpost();
                $logpost->post_id = $request['content_id'];
                $logpost->user_id = Auth::id();
                $logpost->log_type = '8';
                $logpost->save();

                $local = Config::get('app.locale');

                $message = trans('home.updated');
                $success = "1";
                return response()->json(['message' => $message, 'slug' => $post->slug, 'success' => $success, 'local' => $local]);
            }
        } else {
            return response()->json($this->invalid_request());
        }
    }


    // type 0 = user, type 1 = post, type 2 = comment
    public function reportCreate(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'reason' => 'required|min:2',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            } else {
                $reportcheck = Report::where('user_id', Auth::id())->where('content_id', $request['content_id'])->where('type', $request['type'])->first();

                if ($reportcheck) {
                    $success = '0';
                    $message = trans('home.reportedBefore');
                    return response()->json(['success' => $success, 'message' => $message]);
                } else {
                    $report = new Report();

                    $report->reason = $request['reason'];
                    $report->type = $request['type'];
                    $report->content_id = $request['content_id'];
                    $report->user_id = Auth::id();

                    $report->save();

                    $success = '1';
                    $message = trans('home.reportSucceed');
                    return response()->json(['success' => $success, 'message' => $message]);
                }
            }
        } else {
            $success = '0';
            $message = trans('home.plzLogin');
            return response()->json(['success' => $success, 'message' => $message]);
        }
    }


    public function editingPostContnet(Request $request)
    {
        $post = Post::where('id', $request['id'])->first();

        if (Auth::check()) {
            if (Auth::id() == $post->user_id || Auth::user()->userprofile->role_id != 1 || Auth::user()->userprofile->role_id != 2) {
                $langs = Lang::all();
                return view('editpost', ['post' => $post, 'langs' => $langs]);
            } else {
                return response()->json($this->invalid_request());
            }
        } else {
            $success = '0';
            $message = trans('home.plzLogin');
            return response()->json(['success' => $success, 'message' => $message]);
        }
    }

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected $posts_per_page = 15;


    public function postPaginator()
    {
        $catSessionCheck = session('category');
        $catCookieCheck = Cookie::get('category');

        if ($catSessionCheck != null || count($catSessionCheck) > 0) {
            $posts = Post::where('category_id', $catSessionCheck)->orderBy('created_at', 'desc')->paginate($this->posts_per_page, ["*"], 'sidebar');
            $category = Category::where('id', $catSessionCheck)->first();
        } else if ($catCookieCheck) {
            $posts = Post::where('category_id', $catCookieCheck)->orderBy('created_at', 'desc')->paginate($this->posts_per_page, ["*"], 'sidebar');
            $category = Category::where('id', $catCookieCheck)->first();
        } else {
            $posts = Post::orderBy('created_at', 'desc')->paginate($this->posts_per_page, ["*"], 'sidebar');
            $category = 'null';
        }


        $local = Lang::where('short_name', Config::get('app.locale'))->first();


        if ($this->request->ajax()) {
            return [
                'posts' => view('ajax.sidebarindex', ['posts' => $posts])->render(),
                'next_page' => $posts->nextPageUrl(),
            ];
        }

        return view('home');
    }
}
