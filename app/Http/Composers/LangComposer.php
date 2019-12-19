<?php

namespace raplet\Http\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use raplet\Lang;

class LangComposer {
    public function compose(View $view){
        //    $cats = Cats::all();


        $langs = DB::table('langs')->orderBy('name', 'asc')->get();

        $view->with(['langs' => $langs]);
    }
}

