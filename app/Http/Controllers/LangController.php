<?php

namespace raplet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use raplet\Lang;
use Cocur\Slugify\Slugify;
use raplet\Userprofile;
use raplet\Multilingual;


class LangController extends Controller
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
        if (Auth::check()){
            if (Auth::guard('admin')){
                $langs =  Lang::all();
                return view('tags')->withTags($langs);
            }
            else{
                return back();
            }
        }
        else{
            return back();
        }
    }

    public function langCreate(Request $request){
              if (Auth::guard('admin')) {
                  $this->validate($request, [
                      'name' => 'required|unique:langs',
                      'short_name' => 'required|unique:langs',
                  ]);

                  $lang = New Lang();

                  $langslug = new Slugify();
                  $slug = $langslug->slugify($request['name']);


                  $lang->name = $request['name'];
                  $lang->short_name = strtolower($request['short_name']);
                  $lang->slug = $slug;

                  $lang->save();

                  $message = "Dil olusturulma basarili";

                  return response()->json(['message' => $message]);
              }
              else {
                  $message = "giris yapilmadi";

                  return response()->json(['message' => $message]);
              }
    }

    public function setNewLang(Request $request){
        $lang = Lang::where('id', $request['id'])->first();
        $cookie = Cookie::forever('locale', $lang->short_name);
        $lang_id = Cookie::forever('lang_id', $lang->id);
        App::setlocale($lang->short_name);

        if (Auth::check()){
            Userprofile::where('user_id', Auth::id())->update(array('lang_id' => $request['id']));
        }
        $message = trans('home.langchanged');

        return response()->json(['message' => $message])->cookie($cookie)->cookie($lang_id);
    }

    public function rapletTranslator(Request $request){
        $translations[] = array();
        $locale = App::getLocale();
        $lang = Lang::where('short_name', $locale)->first();

        foreach ($request['Linguals'] as $lingualMeaning){
             $translation = Multilingual::where('content_id', $lingualMeaning)->where('short_name', $locale)->first();
             if (count($translation) > 0){
                 $translations[] = $translation;
             }
             else{
                 $translation = Multilingual::where('content_id', $lingualMeaning)->where('short_name', 'en')->first();
                 $translations[] = $translation;
             }
        }
        return response()->json(['translations' => $translations]);
    }
}


















