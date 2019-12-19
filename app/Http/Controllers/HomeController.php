<?php

namespace raplet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use raplet\Lang;
use raplet\Post;
use raplet\Category;
use raplet\Rapletrules;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $is_featured = [0,4];

    // $lasthundred = Post::where('type', '0')->where()->where('is_featured', '1')->orwhere('is_featured', '2')->orderByDesc('id')->with('bestComment')->take(150)->get();
        $posts = Post::where('type', '0')->whereNotIn('is_featured', $is_featured)
        ->orderByDesc('posts.id')->paginate(15, ["*"], 'homepaginator');

        $selectedLang =  Lang::where('short_name', Config::get('app.locale'))->first();

        return view('home', ['posts' => $posts, 'selectedLang' => $selectedLang]);
    }

    public function solarsystem(){
        $is_featured = [0,4];
        $lasthundred = Post::where('type', '0')->whereNotIn('is_featured', $is_featured)->orderByDesc('id')->take(150)->get();
        $extrapoint = 0;
       if (count($lasthundred) > 0){

           $sorted = $lasthundred->sortByDesc(function ($lasthundred){
              return $lasthundred->likecount + $lasthundred->entrycount + $lasthundred->sharecount;
           });

           $posts = $sorted->values()->all();

           return view('solarsystem', ['posts' => $posts]);
       }
       else{
           return redirect()->back();
       }
    }
     public function entireRaplet(){
         $is_featured = [0,4];
         $posts = Post::whereNotIn('is_featured', $is_featured)->orderByDesc('id')->paginate(15);
         $categories = Category::orderbyDesc('name')->get();

           return view('entireRaplet', ['posts' => $posts, 'categories' => $categories]);
    }

    public function termsAndPolicy(){

         $lang =  Lang::where('short_name', Config::get('app.locale'))->first();
         $rules = Rapletrules::where('lang_id', $lang->id)->first();

         if ($rules == null){
             $rules = Rapletrules::where('lang_id', "2")->first();
             if ($rules == null){
                 $ruleContent = trans('home.rulesNotCreated');
             }
             else{
                 $ruleContent = $rules->content;
             }
         }
         else{
             $ruleContent = $rules->content;
         }

         return view('staticview.terms', ['ruleContent' => $ruleContent]);
    }

}











