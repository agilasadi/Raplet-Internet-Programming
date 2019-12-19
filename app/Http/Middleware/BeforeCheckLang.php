<?php

namespace raplet\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use raplet\Lang;
use raplet\Userprofile;


class BeforeCheckLang
{

	public $language_id = "1";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        //there is user
        if (Auth::check()){
            $user = Auth::user();
            //user lang is set
            if ($user->userprofile!=null&&$user->userprofile->lang_id!=null&&$user->userprofile->lang_id != 0){
                $local = Lang::where('id', $user->userprofile->lang_id)->first();
                App::setLocale($local->short_name);
                $langIdCookie = Cookie::forever('lang_id', $local->id);
            }

            //user lang is not set
            else{

                //there is cookie
                if (Cookie::get('locale') !== false){
                    App::setlocale(Cookie::get('locale'));
                    $langIdCookie = Cookie::forever('lang_id', $local->id);
                }

                //there is no cookie
                else{
                    config('app.locale');
                    if (App::setlocale($request->server('HTTP_ACCEPT_LANGUAGE')) != null){
                        $locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                        App::setlocale($locale);
                        $langIdCookie = Cookie::forever('lang_id', $local->id);
                    }
                    else{
                        $locale = substr(config('app.locale'), 0, 2);
                        App::setlocale($locale);
                        $langIdCookie = Cookie::forever('lang_id', $local->id);
                    }
                }

            }

        }

        //there is no user
        else{
            //there is cookie
            if ($request->hasCookie('locale')){
                $shortNameCookie = Cookie::get('locale');
                App::setlocale($shortNameCookie);

                $local =  Lang::where('short_name', $shortNameCookie)->first();
                $langIdCookie =  Cookie::forever('lang_id', $local->id);
            }
            //there is no cookie
            else{
            	//todo Check in different languages to see what happens if user has an undefined language in browser
                if (App::setlocale($request->server('HTTP_ACCEPT_LANGUAGE')) != null){
                    $locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                    App::setlocale($locale);
                    $local = Lang::where('short_name', $locale)->first();
                    $this->language_id = $local ? $local : "1";
                    $langIdCookie = Cookie::forever('lang_id', $this->language_id);
                }
                else{
                    $locale = substr(config('app.locale'), 0, 2);
                    App::setlocale($locale);
                    $langIdCookie = Cookie::forever('lang_id', $this->language_id);
                }
            }
        }

        return $next($request)->cookie($langIdCookie);
    }
}
