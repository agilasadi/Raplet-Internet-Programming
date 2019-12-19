<?php

namespace raplet\Http\Controllers\Authed;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use raplet\Http\Controllers\Controller;
use raplet\Lang;
use raplet\Post;


class PostController extends Controller
{
	public $success = true;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$langs = Lang::orderBy('name', 'desc')->get();
		return view('creatheader', ['langs' => $langs]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * @param $slug
	 * @param null $langname
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show($slug, $langname = null)
	{
		$is_featured = [0, 4];
		$post = Post::where('slug', $slug)->whereNotIn('is_featured', $is_featured)->firstOrFail();

		if ($post != null || count($post) > 0)
		{

			$postEditedBy = Logpost::where('post_id', $post->id)->where('log_type', '8')->where('user_id', "!=", "$post->user_id")->first();

			if ($postEditedBy == null)
			{
				$postEditedBy = 0;
			}

			if ($langname == null)
			{


				if (Auth::check())
				{
					$commentVoteUp = Vote::select('comment_id')->where('user_id', Auth::id())->where('vote', 1)->get();
					$commentVoteDown = Vote::select('comment_id')->where('user_id', Auth::id())->where('vote', 0)->get();
					$liked = Like::where('post_id', $post->id)->where('user_id', Auth::id())->first();

					if (!$commentVoteUp)
					{
						$commentVoteUp = "null";
					}
					if (!$commentVoteDown)
					{
						$commentVoteDown = "null";
					}
					if (!$liked)
					{
						$likedpost = '0';
					}
					else
					{
						$likedpost = '1';
					}
					$voteUps = array_flatten($commentVoteUp->toArray());
					$voteDowns = array_flatten($commentVoteDown->toArray());

					$badges = Badge::where('badge_type', '1')->where('badge_ruler', Auth::user()->userprofile->role->name)->orwhere('badge_reqs', '<=', Auth::user()->userprofile->reputation)->where('badge_type', '1')->orwhere('badge_reqs', '<=', Auth::user()->userprofile->role->replimit)->where('badge_type', '1')->get();
				}
				else
				{
					$voteUps = 'null';
					$voteDowns = 'null';
					$likedpost = '0';
					$badges = 'null';
				}


				$locale = $langname;
				$lang = DB::table('langs')->where('short_name', Config::get('app.locale'))->first();


				if ($post->comments() != null || count($post->comments()) > 0)
				{
					$comments = $post->comments()->whereNotIn('is_featured', $is_featured)->orderBy('likecount', 'desc')->orderBy('id', 'ASC')->paginate(25);
				}
				else
				{
					$comments = 'null';
				}


				return view('word', [
					'post' => $post,
					'comments' => $comments,
					'locale' => $locale,
					'voteUps' => $voteUps,
					'voteDowns' => $voteDowns,
					'likedpost' => $likedpost,
					'badges' => $badges,
					'postEditedBy' => $postEditedBy
				]);
			}


			if (Auth::check())
			{

				$commentVoteUp = Vote::where('user_id', Auth::id())->where('vote', 1)->get();
				$commentVoteDown = Vote::where('user_id', Auth::id())->where('vote', 0)->get();
				$liked = Like::where('post_id', $post->id)->where('user_id', Auth::id())->first();

				if (!$commentVoteUp)
				{
					$commentVoteUp = "null";
				}
				if (!$commentVoteDown)
				{
					$commentVoteDown = "null";
				}
				if (!$liked)
				{
					$likedpost = '0';
				}
				else
				{
					$likedpost = '1';
				}

				$voteUps = array_flatten($commentVoteUp->toArray());
				$voteDowns = array_flatten($commentVoteDown->toArray());


				$badges = Badge::where('badge_type', '1')->where('badge_ruler', Auth::user()->userprofile->role->name)->orwhere('badge_reqs', '<=', Auth::user()->userprofile->reputation)->where('badge_type', '1')->orwhere('badge_reqs', '<=', Auth::user()->userprofile->role->replimit)->where('badge_type', '1')->get();
			}
			else
			{
				$voteUps = 'null';
				$voteDowns = 'null';
				$likedpost = '0';
				$badges = 'null';
			}


			$locale = $langname;
			$lang = DB::table('langs')->where('short_name', $langname)->first();


			if ($post->comments() != null || count($post->comments()) > 0)
			{
				$comments = $post->comments()->where('lang_id', $lang->id)->whereNotIn('is_featured', $is_featured)->orderBy('likecount', 'desc')->orderBy('id', 'desc')->paginate(25, ["*"], 'wordcommentd');
			}
			else
			{
				$comments = 'null';
			}


			return view('word', [
				'post' => $post,
				'comments' => $comments,
				'locale' => $locale,
				'voteUps' => $voteUps,
				'voteDowns' => $voteDowns,
				'likedpost' => $likedpost,
				'badges' => $badges,
				'postEditedBy' => $postEditedBy
			]);
		}
		else
		{
			abort(404);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$post = Post::find($id);
		if ($post)
		{
			if (Auth::id() == $post->user_id)
			{
				$post->delete();
			}
			else
			{
				$this->success = false;
			}
		}
		else
		{
			$this->success = false;
		}

		return response()->json(['success' => $this->success]);
	}
}
