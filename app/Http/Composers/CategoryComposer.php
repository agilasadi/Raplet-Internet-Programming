<?php

namespace raplet\Http\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use raplet\Lang;


class CategoryComposer {
    public function compose(View $view){

        $cats = DB::table('category')->where('deleted_at', null)->orderBy('interest', 'desc')->get();

        $view->with(['cats' => $cats]);
    }
}

