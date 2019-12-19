<?php

namespace raplet\Http\Controllers;

use Illuminate\Http\Request;
use raplet\Post;
use raplet\Vote;
use raplet\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;



class PostmediaController extends Controller
{
    public function curiosity(){
        $is_featured = [0,4];
        $posts = Post::where('type', '1')->whereNotIn('is_featured', $is_featured)->orderByDesc('id')->paginate(15, ["*"], 'curious');
                return view('curiosity', ['posts' => $posts]);
        }

}
