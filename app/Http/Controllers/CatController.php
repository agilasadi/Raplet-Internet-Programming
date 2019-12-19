<?php

namespace raplet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use raplet\Category;

class CatController extends Controller
{
    public function catSelector(Request $request){
        if ($request['content_id'] == 0){
            $cookie = Cookie::forget('category');
            session()->forget('category');

            $success = '1';
            return response()->json(['success' => $success])->cookie($cookie);
        }
        $selectedCat = Category::where('id', $request['content_id'])->first();

        if (count($selectedCat) > 0){
            $cookie = Cookie::forever('category', $request['content_id']);
            session(['category' => $request['content_id']]);

            $success = '1';
            $message = trans('home.success');
            return response()->json(['message' => $message, 'success' => $success])->cookie($cookie);
        }
        else{
            $success = '0';
            $message = trans('home.failiur');
            return response()->json(['message' => $message, 'success' => $success]);
        }
    }
}
