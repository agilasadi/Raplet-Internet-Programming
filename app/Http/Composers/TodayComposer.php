<?php

namespace raplet\Http\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use raplet\Category;
use raplet\Lang;
use raplet\Post;
use Illuminate\Http\Request;

class TodayComposer {
    protected $posts_per_page = 15;

    public function __construct(Request $request)
    {
        $this->request= $request;
    }


    public function compose(View $view){
        $is_featured = [0,4];


        $catSessionCheck = session('category');
        $catCookieCheck = Cookie::get('category');

        if ($catSessionCheck != null){
            $posts = Post::where('category_id', $catSessionCheck)->whereNotIn('is_featured', $is_featured)->orderBy('created_at', 'desc')->paginate($this->posts_per_page, ["*"], 'sidebar')->withPath('postPaginator');
            $category = Category::where('id', $catSessionCheck)->first();
        }
        else if ($catCookieCheck){
            $posts = Post::where('category_id', $catCookieCheck)->whereNotIn('is_featured', $is_featured)->orderBy('created_at', 'desc')->paginate($this->posts_per_page, ["*"], 'sidebar')->withPath('postPaginator');
            $category = Category::where('id', $catCookieCheck)->first();

        }
        else {
            $posts = Post::whereNotIn('is_featured', $is_featured)->orderBy('created_at', 'desc')->paginate($this->posts_per_page, ["*"], 'sidebar')->withPath('postPaginator');
            $category = 'null';

        }



        $local = Lang::where('short_name', Config::get('app.locale'))->first();


        $view->with(['local' => $local, 'posts' => $posts, 'category' => $category]);
    }
}
