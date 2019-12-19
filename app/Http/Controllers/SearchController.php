<?php

namespace raplet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use raplet\Comment;
use raplet\Like;
use raplet\Post;
use raplet\User;
use raplet\Userprofile;
use Illuminate\Validation\Rule;
use raplet\Userstat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use raplet\Vote;


class SearchController extends Controller
{
    public function navSearch(Request $request){
        $is_featured = [0,4];

        //search posts
        $posts = Post::where('content', 'like', '%' . $request['content'] . '%')->whereNotIn('is_featured', $is_featured)
            ->orderBy('entrycount', 'desc')->with('postmedia')->with('userprofile')->take(3)->get();

        //search comments
        $comments = Comment::where('content', 'like', '%' . $request['content'] . '%')->whereNotIn('is_featured', $is_featured)->orderBy('likecount', 'desc')->with('userprofile')->take(3)->get();

        //search users
        $users = DB::table('userprofiles')->where('name', 'like', '%' . $request['content'] . '%')->orWhere('slug', 'like', '%' . $request['content'] . '%')->orderBy('reputation', 'desc')->take(3)->get();

        $usercount = count($users);
        $postcount = count($posts);
        $commentcount = count($comments);

        $postlink = route('word', '');
        $commentlink = route('entry', '');
        $userlink = route('profile', '');

        $userimgurl = url('storage/profile/'.'');
        $postimgurl = url('storage/posts/'.'');

        $count = $usercount + $postcount + $commentcount;


        return response()->json(['posts' => $posts,'comments' => $comments, 'users' => $users,
            'count' => $count, 'usercount' => $usercount, 'postcount' => $postcount, 'commentcount' => $commentcount,
            'postlink' => $postlink, 'userlink' => $userlink, 'commentlink' => $commentlink,
            'userimgurl' => $userimgurl, 'postimgurl' => $postimgurl]);
    }

    public function checkSearch(Request $requset){
        $searchlink = route('search', '');

        return response()->json(['searchlink' => $searchlink, 'searched' => $requset['searchRequest']]);
    }


    public function search($searched){
        $is_featured = [0,4];
        //search posts
        // $posts = Post::where('content', 'like', '%' .$searched . '%')->orderBy('entrycount', 'desc')->paginate(10, ["*"], 'p1');
        $posts = Post::where('content', 'like', '%' . $searched . '%')
            ->whereNotIn('is_featured', $is_featured)
            ->orderBy('entrycount', 'desc')->paginate(10, ["*"], 'p1');

        //search comments
        $comments = Comment::where('content', 'like', '%' . $searched . '%')->orderBy('likecount', 'desc')->whereNotIn('is_featured', $is_featured)->paginate(10, ["*"], 'p2');

        //search users
        $users = DB::table('userprofiles')->where('name', 'like', '%' . $searched . '%')->orWhere('slug', 'like', '%' . $searched . '%')->orderBy('reputation', 'desc')->paginate(10, ["*"], 'p3');


        $usercount = count($users);
        $postcount = count($posts);
        $commentcount = count($comments);

        $count = $usercount + $postcount + $commentcount;


        return response()->view('search', ['posts' => $posts, 'comments' => $comments, 'count' => $count,
            'users' => $users, 'usercount' => $usercount, 'postcount' => $postcount, 'commentcount' => $commentcount,
            'searched' => $searched
            ]);
    }
}



















